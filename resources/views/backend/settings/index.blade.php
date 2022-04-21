@extends('backend.layouts.app')

@section('title', __('Settings Index'))

@section('content')
    <x-backend.card>
        <x-slot name="header">
            @lang('Settings Index')
        </x-slot>

        <x-slot name="body">
            <div class="table-responsive-md">
                <table class="table table-striped table-hover nowrap" id="table">
                    <thead>
                    <tr>
                        <th></th>
                        <th>@lang('ID')</th>
                        <th>@lang('Title')</th>
                        <th>@lang('Value')</th>
                        <th>@lang('Created At')</th>
                        <th>@lang('Updated At')</th>
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
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: 0
                    }
                },
                order: [1, 'asc'],
                ajax: '{{ url('/admin/index2listSettings') }}',
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
                    {data: 'value', name: 'value'},
                    {data: 'created_at', name: 'created_at'},
                    {data: 'updated_at', name: 'updated_at'},
                    {data: 'actions', name: 'actions', sortable: false, searchable: false},
                ],
                @include('backend.includes.dtTranslate')
            });
        });
    </script>
@endsection
