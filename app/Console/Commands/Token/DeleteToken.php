<?php

namespace App\Console\Commands\Token;

use Illuminate\Console\Command;
use App\Models\AppToken;

class DeleteToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'token:delete';

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

        $tokenId = $this->ask('Enter the ID of the token you\'d like to delete');

        $appToken = AppToken::find($tokenId);
        
        if (is_null($appToken)) {
            $this->error("The ID \"{$tokenId}\" could not be found. Please choose an id from the table above.");
            
            return 1;
        }

        if ($this->confirm("Confirm that you would like to delete the token for \"{$appToken->name}\"", true)) {
            $regeneratedToken = $appToken->delete();
            $this->info("The token for \"{$appToken->name}\" has been deleted");
        } else {
            $this->info("The token for \"{$appToken->name}\" has not been deleted");
        }

        $this->newLine();

        return 0;
    }
}
