<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\AppToken;

class AppTokenSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Server token for the following record:
        // u8cOaHZl1IIyHiN20JwhdnNMdJ1sUkXqBHLjuKWzLeJ1jsP0MkcQEWUyCRY1

        AppToken::create([
            'name' => 'Local Development',
            'api_token' => '5129d90ab9eb46bcf290676418112fe56d8113fb0cfe1c3815ef4c2f177cc43a',
        ]);
    }
}
