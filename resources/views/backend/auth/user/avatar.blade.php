@extends('backend.layouts.app')

@section('title', __('Edit Avatar'))

@section('content')
    <form action="{{route('admin.auth.user.edit.uploadAvatar', $user)}}" method="post" enctype="multipart/form-data">
        @csrf
        <x-backend.card>
            <x-slot name="header">
                @lang('Edit Avatar')
            </x-slot>

            <x-slot name="headerActions">
                <x-utils.link class="card-header-action" :href="route('admin.auth.user.edit', $user)" :text="__('Cancel')" />
            </x-slot>

            <x-slot name="body">
                <div class="form-group row">
                    <label for="avatar" class="col-md-2 col-form-label">@lang('Avatar')</label>
                    <div class="col-md-10">
                        <div class="row">
                            <div class="col-md-2">
                                <img src="{{$user->avatar}}" class="c-avatar-img">
                            </div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md">
                                <input type="radio" name="avatar_type" value="gravatar"
                                       {{ $user->avatar_type == 'gravatar' ? 'checked' : '' }} /> @lang('Gravatar')
                            </div>
                            <div class="col-md">
                                <input type="radio" name="avatar_type" value="storage"
                                       {{ $user->avatar_type == 'storage' ? 'checked' : '' }} /> @lang('Upload')
                            </div>
                        </div>

                        <div class="row mt-3">
                            <div class="col-md hidden" id="avatar_location">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" name="avatar_location"
                                           accept=".png,.jpg,.jpeg">
                                    <label class="custom-file-label" for="avatar_location"
                                           data-browse="@lang('Upload')"></label>
                                    <span>@lang('Avatar format')</span>
                                </div>
                            </div>
                        </div>
                    </div><!--col-->
                </div><!--form-group-->

            </x-slot>

            <x-slot name="footer">
                <button class="btn btn-sm btn-primary float-right" type="submit">@lang('Update')</button>
            </x-slot>
        </x-backend.card>
    </form>
@endsection

@section('add-field')
    <script>
        $(function () {
            var avatar_location = $("#avatar_location");

            if ($('input[name=avatar_type]:checked').val() === 'storage') {
                avatar_location.show();
            } else {
                avatar_location.hide();
            }

            $('input[name=avatar_type]').change(function () {
                if ($(this).val() === 'storage') {
                    avatar_location.show();
                } else {
                    avatar_location.hide();
                }
            });
        });
    </script>
@endsection
