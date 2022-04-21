<?php

namespace App\Domains\Auth\Http\Requests\Backend\User;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ChangeAvatarRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user()->isMasterAdmin()) {
            return true;
        }
        if ($this->user->isMasterAdmin()) {
            return false;
        }
        return $this->user->id == $this->user()->id || $this->user()->can('admin.access.user');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'avatar_location' => ['file', 'image', Rule::requiredIf($this->input('avatar_type') == 'storage')],
            'avatar_type' => ['required', Rule::in(['storage','gravatar'])],
        ];
    }

    /**
     * @return array
     */
    public function messages()
    {
        return [
            'avatar_location.required' => __('File') . ' ' . __('Required'),
            'avatar_location.image' => __('File must be an image'),
            'avatar_type.required' => __('Avatar type') . ' ' . __('Required'),
            'avatar_type.in' => __('Avatar type') . ' ' . __('must be storage or gravatr'),
        ];
    }

    /**
     * Handle a failed authorization attempt.
     *
     * @return void
     *
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    protected function failedAuthorization()
    {
        throw new AuthorizationException(__('You dont have permission to do this'));
    }
}
