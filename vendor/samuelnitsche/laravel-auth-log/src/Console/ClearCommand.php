<?php

namespace SamuelNitsche\AuthLog\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use SamuelNitsche\AuthLog\AuthLog;

class ClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'auth-log:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear old records from the auth log';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $this->comment('Clearing auth log...');

        $days = config('auth-log.older');
        $from = Carbon::now()->subDays($days)->format('Y-m-d H:i:s');

        AuthLog::where('login_at', '<', $from)->delete();

        $this->info('Auth log cleared successfully.');
    }
}
