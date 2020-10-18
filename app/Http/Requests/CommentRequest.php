<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PaginationRequest
 * @package App\Http\Requests
 */
class CommentRequest extends FormRequest
{

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'text' => 'required',
            'parent_id' => '',
        ];
    }
}
