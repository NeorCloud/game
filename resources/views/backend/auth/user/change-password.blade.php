@extends('backend.layouts.app')

@section('title', __('Change Password for :name', ['name' => $user->name]))

@section('content')
    <x-forms.patch :action="route('admin.auth.user.change-password.update', $user)">
        <x-backend.card>
            <x-slot name="header">
                @lang('Change Password')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.auth.user.show',$user->id)" :text="__('Cancel')"/>
            </x-slot>

            <x-slot name="body">
                @if(! $logged_in_user->can('admin.access.user.change-password') || ($user->id == $logged_in_user->id && !$logged_in_user->isMasterAdmin()))
                    <div class="form-group row">
                        <label for="old_password" class="col-md-2 col-form-label">@lang('Old Password')</label>

                        <div class="col-md-10">
                            <input type="password" name="old_password" id="old_password" class="form-control"
                                   placeholder="{{ __('Old Password') }}" maxlength="100" required
                                   autocomplete="old-password"/>
                        </div>
                    </div><!--form-group-->
                @endif
                <div class="form-group row">
                    <label for="password" class="col-md-2 col-form-label">@lang('Password')</label>

                    <div class="col-md-10">
                        <input type="password" name="new_password" id="password" class="form-control"
                               placeholder="{{ __('Password') }}" maxlength="100" required autocomplete="new-password"/>
                    </div>
                </div><!--form-group-->

                <div class="form-group row">
                    <label for="password_confirmation"
                           class="col-md-2 col-form-label">@lang('Password Confirmation')</label>

                    <div class="col-md-10">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                               class="form-control" placeholder="{{ __('Password Confirmation') }}" maxlength="100"
                               required autocomplete="new-password"/>
                    </div>
                </div><!--form-group-->
            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update')</button>
            </x-slot>
        </x-backend.card>
    </x-forms.patch>
@endsection
