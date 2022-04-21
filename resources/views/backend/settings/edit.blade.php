@extends('backend.layouts.app')

@section('title', __('Settings Edit'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            <div class="clearfix">
                <div class="float-left">
                    <div class="mt-0"><strong>@lang('Settings Edit')</strong></div>
                </div>
            </div>
        </x-slot>

        <x-slot name="body">
            <form method="post" action="{{route('admin.settings.update',$setting->id)}}">
                {{csrf_field()}}
                {{method_field('put')}}
                <div class="row">
                    <div class="form-group col-md-6">
                        <label for="title">@lang('Title')</label>
                        <input id="title" name="title" class="form-control" value="{{$setting->title}}" required autofocus>
                    </div>
                    <div class="form-group col-md-6">
                        <label for="value">@lang('Value')</label>
                        <input id="value" name="value" class="form-control" value="{{$setting->value}}" required>
                    </div>
                </div>
                <div class="row">
                    <div class="form-group col-md">
                        <label for="desc">@lang('Description')</label>
                        <textarea name="description" class="form-control" rows="4" id="desc">{{$setting->description}}</textarea>
                    </div>
                </div>
                <div class="clearfix">
                    <div class="float-right">
                        <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                    </div>
                </div>

            </form>
        </x-slot>
    </x-backend.card>
@endsection
