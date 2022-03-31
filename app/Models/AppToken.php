<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AppToken extends Model
{
    use HasFactory;

    protected $guarded = [];

    public static function authenticate($token)
    {
        return self::where('api_token', hash('sha256', $token))->exists();
    }

    protected static function generateToken()
    {
        return Str::random(60);
    }

    public static function createNewToken($name)
    {
        $token = self::generateToken();

        self::create([
            'name' => $name,
            'api_token' => hash('sha256', $token),
        ]);

        return $token;
    }

    public function regenerateToken()
    {
        $token = self::generateToken();

        $this->update([
            'api_token' => hash('sha256', $token)
        ]);

        return $token;
    }

}
