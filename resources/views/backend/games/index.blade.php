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
                        <th>@lang('Actions')</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td>1</td>
                        <td>Snake</td>
                        <td><a href="{{route('admin.games.run', 'snake')}}" class="btn btn-primary"><i class="fas fa-eye"></i></a></td>
                    </tr>
                    </tbody>
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
                @include('backend.includes.dtTranslate')
            });
        });
    </script>
@endsection
