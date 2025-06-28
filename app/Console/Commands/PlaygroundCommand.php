<?php

namespace App\Console\Commands;

use App\Events\TestingReverbEvent;
use Illuminate\Console\Command;

class PlaygroundCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'play';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.php
     */
    public function handle()
    {
        //
        foreach(range(1,12) as $i){

            TestingReverbEvent::dispatch();
        }
    }
}
