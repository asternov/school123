<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PaginationRequest
 * @package App\Http\Requests
 */
class CourseRequest extends FormRequest
{

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => '',
            'is_public' => '',
        ];
    }
}
