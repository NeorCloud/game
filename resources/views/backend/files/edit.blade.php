@extends('backend.layouts.app')

@section('title', __('Files Edit'))

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>@lang('Files Edit')</strong>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.files.update',$file->id)}}" method="POST">
                        {{csrf_field()}}
                        {{method_field('put')}}
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="title">@lang('Title')</label>
                                <input type="text" class="form-control" name="title" value="{{$file->title}}"
                                       id="title">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="description">@lang('Description')</label>
                                <textarea type="text" class="form-control" aria-describedby="name" rows="5"
                                          id="description" placeholder="@lang('Description')"
                                          name="description">{{$file->description}}</textarea>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div class="float-right">
                                <input type="submit" class="btn btn-primary" value="@lang('Update')">
                            </div>
                        </div>
                    </form>
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection
