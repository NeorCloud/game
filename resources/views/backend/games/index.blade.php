@extends('backend.layouts.app')

@section('title', __('Games Index'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            <div class="clearfix">
                <div class="float-left">@lang('Games Index')</div>
            </div>
        </x-slot>

        <x-slot name="body">
            <div class="table-responsive-md">
                <table class="table table-striped table-hover nowrap" id="table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>@lang('ID')</th>
                        <th>@lang('Title')</th>
                        <th>@lang('Created At')</th>
                        <th>@lang('Actions')</th>
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
                responsive: {
                    details: {
                        type: 'column',
                        target: 0
                    }
                },
                order: [1, 'asc'],
                ajax: '{{ url('/admin/games/index2list') }}',
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
                    {data: 'title', name: 'title'},
                    {data: 'created_at', name: 'created_at', searchable: false},
                    {data: 'action', name: 'action', searchable: false, sortable: false},
                ],
                @include('backend.includes.dtTranslate')
            });
        });
    </script>
@endsection
