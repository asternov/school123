<?php

namespace App\Http\Controllers;

use App\Token;
use App\User;
use Illuminate\Http\Request;

class TokenController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create(Request $request, String $email, String $device_hash)
    {
        $user = User::query()->where('email', $email)->get()->first();
        $message = 'Неверная или устаревшая ссылка. попробуйте еще раз.';
        $device_hashs = [sha1($email. date('d').((int)date('H'))),
            sha1($email. date('d').((int)date('H') - 1))];
        $response = redirect('/login');

        if (isset($user) && in_array($device_hash, $device_hashs)) {
            if ($user->tokens->count() > 1) {
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function show(Token $token)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function edit(Token $token)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Token $token)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Token  $token
     * @return \Illuminate\Http\Response
     */
    public function destroy(Token $token)
    {
        //
    }
}
