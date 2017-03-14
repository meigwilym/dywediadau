<?php

namespace App\Console\Commands;

use App\Classes\Images;
use Illuminate\Console\Command;

class TweetImage extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tweet:image {saying}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make an image with saying';
    
    protected $images;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->images = app(Images::class);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $saying = $this->argument('saying');
        $imagePath = $this->images->textToImage($saying);

        $handle = fopen($imagePath, "r");
        $contents = fread($handle, filesize($imagePath));
        fclose($handle);

        if(\App::environment('production'))
        {
            $response = \Twitter::uploadMedia(['media' => $contents]);

            \Log::info('posted image', [$response->media_id]);
            
            unlink($imagePath);
            return $response->media_id_string;
        }
        
        return;
        
    }
}
