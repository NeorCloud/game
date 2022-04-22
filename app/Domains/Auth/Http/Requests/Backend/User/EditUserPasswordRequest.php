<?php

namespace App\Domains\Auth\Http\Requests\Backend\User;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class EditUserPasswordRequest.
 */
class EditUserPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->user->id == $this->user()->id) {
            return true;
        }
        if ($this->user->can('admin.access.user.change-password') && ! $this->user()->isMasterAdmin()) {
            return false;
        }
        if ($this->user()->can('admin.access.user.change-password')) {
            return true;
        }

        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
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
        if ($this->user->isMasterAdmin() && $this->user()->id != $this->user->id) {
            throw new AuthorizationException(__('Only the administrator can change their password.'));
        }
        throw new AuthorizationException(__('You do not have access to do that.'));
    }
}
