<?php

namespace App\Http\Controllers;

use App\Jobs\Max\SendDocument;
use App\Models\Dialog;
use App\Models\Message;
use App\Models\User;
use App\Services\MaxMailing\MaxBaseService;
use App\Services\MaxService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SupportController extends Controller
{

    public function index()
    {
        return view('admin.pages.support.index');
    }

    public function getDialogs(Request $request): JsonResponse
    {
        $query = Dialog::with(['client:id,username,picture', 'lastMessage'])
            ->withCount(['messages as unread_count' => function ($query) {
                $query->where('read', false);
            }])
            ->whereHas('lastMessage')
            ->orderByRaw('unread_count > 0 DESC')
            ->orderByDesc(
                Message::select('created_at')
                    ->whereColumn('dialog_id', 'dialogs.id')
                    ->latest()
                    ->take(1)
            );

        if ($request->value != null) {
            $search = $request->value;
            $query->whereHas('client', function ($q) use ($search) {
                $q->where('username', 'like', '%' . $search . '%');
            });
        }

        $dialogs = $query->get()->map(function ($dialog) {
            return [
                'id' => $dialog->id,
                'client_id' => $dialog->client->id ?? null,
                'username' => $dialog->client->username ?? null,
                'last_message' => $dialog->lastMessage ? $dialog->lastMessage->text : null,
                'unread_count' => $dialog->unread_count,
                'image' => $dialog->client->picture ? asset($dialog->client->picture) : null,
                'file_exist' => $dialog->file_exist,
                'file_path' => $dialog->file_path,
                'created_at' => Carbon::parse($dialog->lastMessage ? $dialog->lastMessage->created_at : null)->toDateTimeString(),
            ];
        })->values();

        $hash = md5(json_encode($dialogs));

        return $this->successResponse('OK', [
            'dialogs' => $dialogs,
            'hash' => $hash,
        ]);
    }

    public function getMessages(Request $request): JsonResponse
    {
        Message::where('dialog_id', $request->dialog_id)
            ->where('read', false)
            ->update(['read' => true]);

        $messages = Message::where('dialog_id', $request->dialog_id)
            ->orderBy('created_at', 'asc')
            ->get(['read', 'text', 'created_at', 'author', 'file_exist', 'file_path'])
            ->map(function ($msg) {
                return [
                    'text' => $msg->text,
                    'read' => $msg->read,
                    'author' => $msg->author,
                    'file_exist' => $msg->file_exist,
                    'file_path' => $msg->file_path,
                    'created_at' => Carbon::parse($msg->created_at)->toDateTimeString(),
                ];
            });

        $hash = md5(json_encode($messages));

        return $this->successResponse('OK', [
            'messages' => $messages,
            'hash' => $hash,
        ]);
    }

    public function sendMessage(Request $request): JsonResponse
    {
        $request->validate([
            'file'  => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,pdf|max:10240',
            'voice' => 'nullable|file|max:10240'
        ]);

        $client = User::find($request->client_id);
        $text = $request->text ?? '';

        $fileExist = false;
        $filePath = null;
        $extension = null;
        $path = null;

        if (!$client) {
            return $this->errorResponse('Client not found');
        }

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $extension = $file->getClientOriginalExtension();
            $path = $file->store('support', 'public');
            $filePath = asset('storage/' . $path);
            $fileExist = true;
        } else if ($request->hasFile('voice')) {
            $file = $request->file('voice');
            $extension = $file->getClientOriginalExtension(); // например 'mp4'
            $filename = pathinfo($file->hashName(), PATHINFO_FILENAME) . '.' . $extension;
            $path = $file->storeAs('voices', $filename, 'public');
            $filePath = asset('storage/' . $path);
            $fileExist = true;
        }

        $bot = new MaxService(config('max.support_token'));

        if ($fileExist) {
            if (in_array($extension, ['webm','ogg','mp3', 'mp4'])) {
                SendDocument::dispatch($client, $path, $text, 'audio');
            } else if ($extension === 'pdf') {
                SendDocument::dispatch($client, $path, $text);
            } else {
                $bot->sendImage($client->max_support_chat, $filePath, $text);
            }
        } else {
            $bot->sendMessage($client->max_support_chat, $text);
        }

        Message::create([
            'dialog_id' => $request->dialog_id,
            'client_id' => $request->client_id,
            'author' => 'admin',
            'text' => $text,
            'read' => true,
            'file_exist' => $fileExist,
            'file_path' => $filePath
        ]);

        return response()->json([
            'success' => true,
            'file_path' => $filePath
        ]);
    }

    public function webhook(Request $request): JsonResponse
    {
        $data = $request->all();
        $headers = $request->headers->all();

        if($headers['x-max-bot-api-secret'][0] != config('max.secret_phrase')) {
            return response()->json();
        }

        $service = new MaxBaseService(config('max.support_token'));
        $service->parseMaxWebhook($data);
        $user = $service->getOrCreateUser(null, true);
        $dialog = Dialog::firstOrCreate([
            'client_id' => $user->id,
        ]);

        $bot = new MaxService(config('max.support_token'));

        if(str_contains($service->message, 'start') && empty($data['message']['body']['attachments'])) {
            $bot->sendMessage($user->max_support_chat, implode("\n", [
                "👋 Привет",
                '',
                'Это бот службы поддержки КЛУБА 257',
                'Здесь вы можете задать ваш вопрос',
            ]));
        } else if(!empty($data['message']['body']['attachments'])) {
            $lastKey = array_key_last($data['message']['body']['attachments']);

            foreach($data['message']['body']['attachments'] as $key => $attachment) {

                $filePath = null;

                if ($attachment['type'] === 'audio') {
                    $url = $attachment['payload']['url'];
                    $response = Http::get($url);

                    if ($response->successful()) {
                        $filename = 'voice_' . Str::uuid() . '.ogg';
                        $path = 'voices/' . $filename;
                        Storage::disk('public')->put($path, $response->body());
                        $filePath = asset('storage/' . $path);
                    }
                } else {
                    $filePath = $attachment['payload']['url'];
                }

                $messageText = $service->message == '/start'
                    ? null
                    : $service->message;

                Message::create([
                    'dialog_id' => $dialog->id,
                    'client_id' => $user->id,
                    'text' => ($key === $lastKey) ? $messageText : null,
                    'file_path' => $filePath,
                    'file_exist' => true
                ]);
            }

            $bot->sendMessage($user->max_support_chat, "Мы получили ваше сообщение, ожидайте ответа");
        } else {
            Message::create([
                'dialog_id' => $dialog->id,
                'client_id' => $user->id,
                'text' => $service->message,
                'file_exist' => false
            ]);

            $bot->sendMessage($user->max_support_chat, "Мы получили ваше сообщение, ожидайте ответа");
        }

        return response()->json();
    }

    public function setWebhook()
    {
        $service = new MaxService(config('max.support_token'));
        $response = $service->setWebhook('https://petr-petr.ru/support/webhook', config('max.secret_phrase'));

        return response()->json($response);
    }

    public function unreadCounter(): \Illuminate\Http\JsonResponse
    {
        $count = Message::where('read', false)->count();
        return response()->json($count);
    }
}