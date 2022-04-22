<?php

namespace App\Domains\Auth\Http\Requests\Backend\User;

use App\Domains\Auth\Rules\UnusedPassword;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\ContextSpecificWords;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\DerivativesOfContextSpecificWords;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\DictionaryWords;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\RepetitiveCharacters;
use LangleyFoxall\LaravelNISTPasswordRules\Rules\SequentialCharacters;

/**
 * Class UpdateUserPasswordRequest.
 */
class UpdateUserPasswordRequest extends FormRequest
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
            'new_password' => [
                'max:100',
                'required',
                'string',
                'min:8',
                new UnusedPassword((int)$this->segment(4)),
                new SequentialCharacters(),
                new RepetitiveCharacters(),
                new DictionaryWords(),
                new ContextSpecificWords($this->email),
                new DerivativesOfContextSpecificWords($this->email),
                'same:password_confirmation',
            ],
            'old_password' => [
                Rule::requiredIf(! $this->user()->can('admin.access.user.change-password') || ($this->user->id == $this->user()->id && ! $this->user()->isMasterAdmin())),
            ],
            'password_confirmation' => [
                'required', 'same:new_password',
            ],
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
