<?php

namespace App\Console\Commands;

use App\Models\Text;
use App\Models\TextGroup;
use App\Services\PostsService;
use App\Services\TextsService;
use Illuminate\Console\Command;

class texts_create extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'texts:create {group_id} {text_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(TextsService $textsService, PostsService $postsService)
    {

        $group_id = trim($this->argument('group_id'));
        $text_id = trim($this->argument('text_id'));

        $group = TextGroup::query()->find($group_id);

        if(!$group){
            echo 'Такой группы не существует';
            return;
        }

        Text::create([
            'id' => $text_id,
            'value' => '',
            'index' => $group->texts()->max('index') + 1,
            'text_group_id'=> $group->id
        ]);

        return 0;
    }
}
