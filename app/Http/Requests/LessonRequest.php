<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class PaginationRequest
 * @package App\Http\Requests
 */
class LessonRequest extends FormRequest
{

    /**
     * @inheritDoc
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => '',
            'content' => '',
            'course_id' => '',
            'is_public' => '',
        ];
    }
}
