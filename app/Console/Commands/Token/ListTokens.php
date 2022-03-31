<?php

namespace App\Console\Commands\Token;

use Illuminate\Console\Command;
use App\Models\AppToken;

class ListTokens extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:list';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List currently configured app tokens';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->table(
            ['App Id', 'App Name'],
            AppToken::all(['id', 'name'])
        );

        return 0;
    }
}
