<?php

namespace App\Console\Commands\Token;

use Illuminate\Console\Command;
use App\Models\AppToken;

class RefreshToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:refresh';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Refresh a given app token';

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

        $tokenId = $this->ask('Enter the ID of the token you\'d like to refresh');

        $appToken = AppToken::find($tokenId);
        
        if (is_null($appToken)) {
            $this->error("The ID \"{$tokenId}\" could not be found. Please choose an id from the table above.");
            return 1;
        }
        
        $regeneratedToken = $appToken->regenerateToken();

        $this->warn('Be sure to copy this token. It will only be displayed here.');
        $this->newLine();
        $this->line($regeneratedToken);
        $this->newLine();

        return 0;
    }
}
