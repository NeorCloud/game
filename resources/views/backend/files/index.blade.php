@extends('backend.layouts.app')

@section('title', $index != 'deleted' ? __('Files Index') : __('Files Deleted'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            <div class="clearfix">
                <div class="float-left">
                    @if($index == 'deleted')
                        @lang('Files Deleted')
                    @else
                        @lang('Files Index')
                    @endcan
                    <a href="{{ route('admin.files.create') }}" class="btn btn-success ml-1"
                       data-toggle="tooltip" title="@lang('Files Create')"><i class="fas fa-plus-circle"></i>
                    </a>
                </div>
                <div class="float-right mt-2">
                    <a class="card-header-action" href="{{ route('admin.backups.index') }}">@lang('Databases')</a>

                    @if($index == 'deleted')
                        <a class="card-header-action" href="{{ route('admin.files.index') }}">@lang('Files Index')</a>
                    @else
                        <a class="card-header-action" href="{{ route('admin.files.index', ['index'=>'deleted']) }}">@lang('Deleted')</a>
                    @endcan
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
                        <th>@lang('Title')</th>
                        <th>@lang('Type')</th>
                        <th>@lang('Creator')</th>
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
            var params = new URLSearchParams(location.search);
            var index = '';
            if (params.get('index') != null)
                index = 'index=' + params.get('index');
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: 0
                    }
                },
                order: [1, 'asc'],
                ajax: '{{ url('/admin/index2listFiles') }}?' + index,
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
                    {data: 'type', name: 'type'},
                    {data: 'creator', name: 'creator', searchable: false},
                    {data: 'created_at', name: 'created_at', searchable: false},
                    {data: 'action', name: 'action', searchable: false, sortable: false},
                ],
                @include('backend.includes.dtTranslate')
            });
        });
    </script>
@endsection
