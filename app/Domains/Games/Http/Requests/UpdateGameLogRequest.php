<?php

namespace App\Domains\Games\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateGameLogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->ip() == $this->log->ip && $this->userAgent() == $this->log->user_agent;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'score' => 'required|integer',
            'duration' => 'required|numeric',
        ];
    }
}
