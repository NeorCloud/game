@extends('backend.layouts.app')

@section('title', __('Games Show'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            <div class="clearfix">
                <div class="float-left">
                    <div class="mt-0"><strong>@lang('Games Show')</strong></div>
                </div>
            </div>
        </x-slot>

        <x-slot name="body">
            <div class="table-responsive-md">
                <table class="table table-striped table-hover table-sm">
                    <tr>
                        <th>@lang('ID')</th>
                        <td>{{$game->id}}</td>
                    </tr>
                    <tr>
                        <th>@lang('Title')</th>
                        <td>{{$game->title}}</td>
                    </tr>
                    <tr>
                        <th>@lang('Description')</th>
                        <td>{{$game->description}}</td>
                    </tr>
                </table>
            </div>
        </x-slot>
        <x-slot name="footer">
            <div class="row">
                <div class="col-md-6">
                    <strong>@lang('Created At')</strong>:
                    {{verta($game->created_at)->timezone(config('app.timezone'))->format('H:i y/m/d')}}
                </div>
                <div class="col-md-6">
                    <strong>@lang('Updated At')</strong>:
                    {{verta($game->updated_at)->timezone(config('app.timezone'))->format('H:i y/m/d')}}
                </div>
            </div>
        </x-slot>
    </x-backend.card>
    <x-backend.card>
        <x-slot name="header">
            <div class="clearfix">
                <div class="float-left">
                    <div class="mt-0"><strong>@lang('Leaderboard')</strong></div>
                </div>
            </div>
        </x-slot>

        <x-slot name="body">
            <div class="table-responsive-md">
                <table class="table table-striped table-hover nowrap" id="table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>@lang('ID')</th>
                        <th>@lang('Nickname')</th>
                        <th>@lang('Score')</th>
                        <th>@lang('Duration')</th>
                        <th>@lang('Created At')</th>
                    </tr>
                    </thead>
                </table>
            </div>
        </x-slot>
    </x-backend.card>
@endsection

@section('add-field')
    <script>
        $(function () {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: 0
                    }
                },
                order: [3, 'desc'],
                ajax: '{{ url('/admin/games/') }}/{{$game->id}}/leaderboard',
                columns: [
                    {
                        data: null,
                        defaultContent: '',
                        className: 'control',
                        orderable: false,
                        targets: 0,
                        searchable: false
                    },
                    {data: 'id', name: 'id'},
                    {data: 'nickname', name: 'nickname'},
                    {data: 'score', name: 'score'},
                    {data: 'duration', name: 'duration'},
                    {data: 'created_at', name: 'created_at', searchable: false},
                ],
                @include('backend.includes.dtTranslate')
            });
        });
    </script>
@endsection
