<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class IdeHelperRun extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ide-helper:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a IDE Helper files if current environment is local';

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
     */
    public function handle(): void
    {
        if (app()->isLocal()) {
            $this->call('ide-helper:generate');
            $this->call('ide-helper:meta');
        }
    }
}
