<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class TweetRandom extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tweet:random';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Throws a dice to send a tweet';

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
     * @return mixed
     */
    public function handle()
    {
        $rand = mt_rand(0, 80);
        if($rand == 40)
        {
            $this->call('tweet:post');
        }
    }
}
