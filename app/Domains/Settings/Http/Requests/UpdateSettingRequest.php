<?php

namespace App\Domains\Settings\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
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
            'value' => 'required',
            'description' => 'nullable',
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'title.required' => __('Title') . ' ' . __('required'),
            'value.required' => __('Value') . ' ' . __('required'),
        ];
    }
}
