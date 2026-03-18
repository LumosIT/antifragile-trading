<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Action extends Model
{
    use HasFactory;

    protected $guarded = [];


    public function client(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public static function register($userId, $action, $channelId): void
    {
        Action::create([
            'user_id' => $userId,
            'action' => $action,
            'channel' => Action::getChannelName($channelId)
        ]);
    }

    public static function getChannelName(string $id): string
    {
        switch ($id) {
            case '-70931186387659':
                return "Вторая ступень";
                break;
            case '-71321808014027':
                return "Третья ступень";
            default:
                return $id;
        }
    }
}
