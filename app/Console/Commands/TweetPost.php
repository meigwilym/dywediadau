<?php

namespace App\Console\Commands;

use App\Classes\Sayings;
use Illuminate\Console\Command;

class TweetPost extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tweet:post';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a tweet';
    
    
    protected $sayings;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        
        $this->sayings = app(Sayings::class);
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // get random saying
        $saying = $this->sayings->getRandom();
        
        $media_id_string = $this->call('tweet:image', ['saying' => $saying]);
        
        // send to twitter 
        if(\App::environment('production'))
        {
            \Twitter::postTweet(['status' => $saying, 'media_ids' => $media_id_string]);
        } 
        $this->info('Posted "'.$saying.'"');
        \Log::info('Posted: "'.$saying.'"');
    }
}
