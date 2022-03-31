<?php

namespace App\Console\Commands\Token;

use Illuminate\Console\Command;
use App\Models\AppToken;

class SetupToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup a new app token to access this API';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $appName = $this->ask('App Name?');

        $appToken = AppToken::createNewToken($appName);

        $this->line("A token has been generated for \"{$appName}\"");
        $this->newLine();
        $this->warn('Be sure to copy this token. It will only be displayed here.');
        $this->newLine();
        $this->line($appToken);
        $this->newLine();

        return 0;
    }
}
