@extends('backend.layouts.app')

@section('title', __('Settings Show'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            <div class="clearfix">
                <div class="float-right">
                    <div class="btn-group" role="group">
                        <a href="{{route('admin.settings.edit',$setting->id)}}">
                            <button class="btn btn-sm btn-success" type="button"><i class="fas fa-edit"></i></button>
                        </a>
                    </div>
                </div>
                <div class="float-left">
                    <div class="mt-0"><strong>@lang('Settings Show')</strong></div>
                </div>
            </div>
        </x-slot>

        <x-slot name="body">
            <div class="table-responsive-md">
                <table class="table table-striped table-hover table-sm">
                    <tr>
                        <th>@lang('ID')</th>
                        <td>{{$setting->id}}</td>
                    </tr>
                    <tr>
                        <th>@lang('Title')</th>
                        <td>{{$setting->title}}</td>
                    </tr>
                    <tr>
                        <th>@lang('Value')</th>
                        <td>{{$setting->value}}</td>
                    </tr>
                    <tr>
                        <th>@lang('Description')</th>
                        <td>{{$setting->description}}</td>
                    </tr>
                </table>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="row">
                <div class="col-md-6">
                    <strong>@lang('Created At')</strong>:
                    {{verta($setting->created_at)->timezone(config('app.timezone'))->format('H:i y/m/d')}}
                </div>
                <div class="col-md-6">
                    <strong>@lang('Updated At')</strong>:
                    {{verta($setting->updated_at)->timezone(config('app.timezone'))->format('H:i y/m/d')}}
                </div>
            </div>
        </x-slot>
    </x-backend.card>
@endsection
