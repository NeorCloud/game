<?php

namespace App\Domains\Files\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StreamPrivateFilesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'id' => ['required', Rule::exists('files', 'id')],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'id.required' => __('ID') . ' ' . __('required'),
            'id.exists' => __('This ID of file dose not exists.'),
        ];
    }
}
