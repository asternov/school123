<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PaginationRequest
 * @package App\Http\Requests
 */
class UserRequest extends FormRequest
{

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email',
            'name' => 'required',
            'password' => '',
            'is_admin' => '',
        ];
    }
}
