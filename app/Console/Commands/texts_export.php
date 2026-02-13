<?php

namespace App\Console\Commands;

use App\Services\PostsService;
use App\Services\TextsService;
use Illuminate\Console\Command;

class texts_dump extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'texts:export';

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

    protected function getTextsDumpPath() : string
    {

        $path = storage_path('app/temp');
        $filename = 'texts.json';

        return $path . '/' . $filename;

    }

    protected function getPostsDumpPath() : string
    {

        $path = storage_path('app/temp');
        $filename = 'posts.json';

        return $path . '/' . $filename;

    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(TextsService $textsService, PostsService $postsService)
    {

        $textsPath = $this->getTextsDumpPath();
        $postsPath = $this->getPostsDumpPath();

        $textsService->export($textsPath);
        $postsService->export($postsPath);

        return 0;
    }
}
