@extends('backend.layouts.app')

@section('title', __('Files Show'))

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <div class="clearfix">
                        <div class="float-left">
                            <strong>@lang('Files Show')</strong>
                        </div>
                        <div class="float-right">
                            <form method="POST" action="{{ route('admin.files.destroy', $file->id)}}">
                                {{csrf_field()}}
                                {{method_field('delete')}}
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-danger btn-sm"
                                            title="@lang('Delete')"
                                            data-toggle="modal" data-target="#delete-{{$file->id}}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    <a class="btn btn-primary btn-sm"
                                       href="{{route('admin.files.edit', $file->id)}}"
                                       title="@lang('labels.backend.access.files.form.update')"><i
                                            class="fas fa-edit"></i>
                                    </a>
                                </div>
                                <div class="modal fade" id="delete-{{$file->id}}" tabindex="-1" role="dialog"
                                     aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">@lang('Sure')</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @lang('Are you sure')
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">
                                                    @lang('No')
                                                </button>
                                                <button type="submit" class="btn btn-success">@lang('Yes')</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div><!--card-header-->
                <div class="card-body">
                    <div class="row">
                        @if($file->format == 'video' || $file->format == 'image' || $file->format == 'audio')
                            @php($y = 9)
                        @else
                            @php($y = 12)
                        @endif
                        <div class="col-md-{{$y}}">
                            <table
                                class="table table-striped table-hover table-bordered table-sm table-responsive-md">
                                <tr>
                                    <th>@lang('ID')</th>
                                    <td>{{$file->id}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Title')</th>
                                    <td>{{$file->title}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Src')</th>
                                    <td>
                                        <a href="{{url($file->src)}}" target="_blank">{{$file->src}}</a>
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('Type')</th>
                                    <td>
                                        @lang($file->type)
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('Format')</th>
                                    <td>
                                        @lang($file->format)
                                    </td>
                                </tr>
                                <tr>
                                    <th>@lang('Creator')</th>
                                    <td>{{$file->creator->name}}</td>
                                </tr>
                                <tr>
                                    <th>@lang('Description')</th>
                                    <td>{{$file->description}}</td>
                                </tr>
                            </table>
                        </div>
                        @if($file->format == 'video' || $file->format == 'image' || $file->format == 'audio')
                            <div class="col-md-3">
                                @if($file->format == 'image')
                                    <img class="img-fluid" src="{{$file->src}}" alt="{{$file->title}}">
                                @elseif($file->format == 'video')
                                    <div class="embed-responsive embed-responsive-16by9">
                                        <video controls class="embed-responsive-item">
                                            <source src="{{$file->src}}" type="video/mp4">
                                        </video>
                                    </div>
                                @else
                                    <audio controls style="border-radius: 20px; margin:0 auto;width: 100%;">
                                        <source src="{{$file->src}}" type="audio/mpeg">
                                        Your browser does not support the audio tag.
                                    </audio>
                                @endif
                            </div>
                        @endif
                    </div>
                </div><!--card-body-->
                <div class="card-footer">
                    <div class="row">
                        <div class="col-6">
                            <strong>@lang('Created At')</strong>:
                            {{verta($file->created_at)->timezone(config('app.timezone'))->format('H:i y/m/d')}}
                        </div>
                        <div class="col-6">
                            <strong>@lang('Updated At')</strong>:
                            {{verta($file->updated_at)->timezone(config('app.timezone'))->format('H:i y/m/d')}}
                        </div>
                    </div>
                </div>
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection

