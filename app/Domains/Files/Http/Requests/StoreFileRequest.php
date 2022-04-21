<?php

namespace App\Domains\Files\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreFileRequest extends FormRequest
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
            'title' => 'required',
            'description' => 'nullable',
            'file' => 'required|file',
            'type' => ['required',Rule::in(['public', 'private'])],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => __('Title') . ' ' . __('Required'),
            'file.required' => __('File') . ' ' . __('Required'),
            'type.required' => __('Type') . ' ' . __('Required'),
            'type.in' => __('Type should to be public or private.'),
        ];
    }
}
