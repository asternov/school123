<?php

namespace App\Http\Controllers;

use App\Token;
use App\User;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    public function create(Request $request, String $email, String $device_hash)
    {
        $user = User::query()->where('email', $email)->get()->first();
        $message = 'Неверная или устаревшая ссылка. попробуйте еще раз.';
        $device_hashs = [sha1($email. date('d').((int)date('H'))),
            sha1($email. date('d').((int)date('H') - 1))];
        $response = redirect('/login');

        if (isset($user) && in_array($device_hash, $device_hashs)) {
            if ($user->tokens->count() > 2) {
                $user->tokens->last()->delete();
            }
            $response->withCookie('device_hash', $device_hash, 100000);
            $user->tokens()->create([
                'hash' => $device_hash,
                'user_agent' => $request->userAgent()
                ]);
            $message = 'Устройство зарегистрированно! пожалуйсте, введите данные повторно.';
        }

        return $response->withErrors($message);
    }
}
