@extends('backend.layouts.app')

@section('extra')
    <style>
        .progress {
            position: relative;
            width: 100%;
            border: 1px solid #7F98B2;
            padding: 1px;
            border-radius: 3px;
        }

        .bar {
            background-color: #B4F5B4;
            width: 0%;
            height: 25px;
            border-radius: 3px;
        }

        .percent {
            position: absolute;
            display: inline-block;
            top: 3px;
            left: 48%;
            color: #7F98B2;
        }
    </style>
@endsection

@section('title', __('Files Create'))

@section('content')
    <div class="row">
        <div class="col">
            <div class="card">
                <div class="card-header">
                    <strong>@lang('Files Create')</strong>
                </div>
                <div class="card-body">
                    <form action="{{route('admin.files.store')}}" method="POST" enctype="multipart/form-data" id="form">
                        {{csrf_field()}}
                        <div class="row">
                            <div class="form-group col-md-3">
                                <label for="title">@lang('Title')</label>
                                <input type="text" class="form-control" name="title" value="{{old('title')}}"
                                       id="title">
                            </div>
                            <div class="form-group col-md-2">
                                <label for="type">@lang('Type')</label>
                                <select type="text" class="form-control" id="type" name="type">
                                    <option value="public" selected>@lang('Public')</option>
                                    <option value="private">@lang('Private')</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="description">@lang('Description')</label>
                                <textarea type="text" class="form-control" aria-describedby="name" rows="5"
                                          id="description" placeholder="@lang('Description')"
                                          name="description">{{old('description')}}</textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-md-12">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="customFile" name="file">
                                    <label class="custom-file-label" for="customFile"
                                           data-browse="@lang('Upload')"></label>
                                </div>
                                <div class="progress">
                                    <div class="bar"></div>
                                    <div class="percent">0%</div>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix">
                            <div class="float-right">
                                <input type="submit" class="btn btn-primary" value="@lang('Send')">
                            </div>
                        </div>
                    </form>
                </div><!--card-body-->
            </div><!--card-->
        </div><!--col-->
    </div><!--row-->
@endsection

@section('add-field')
    <script>
        $(document).ready(function () {
            function validate(formData, jqForm, options) {
                var form = jqForm[0];
                if (!form.file.value) {
                    alert('File not found');
                    return false;
                }
            }

            var bar = $('.bar');
            var percent = $('.percent');
            var status = $('#status');

            $('#form').ajaxForm({
                beforeSubmit: validate,
                beforeSend: function () {
                    status.empty();
                    var percentVal = '0%';
                    var posterValue = $('input[name=file]').fieldValue();
                    bar.width(percentVal);
                    percent.html(percentVal);
                },
                uploadProgress: function (event, position, total, percentComplete) {
                    var percentVal = percentComplete + '%';
                    bar.width(percentVal);
                    percent.html(percentVal);
                },
                success: function () {
                    var percentVal = 'Wait, Saving';
                    bar.width(percentVal);
                    percent.html(percentVal);
                },
                complete: function (xhr) {
                    var obj = JSON.parse(xhr.responseText);
                    status.html(xhr.responseText);
                    window.location.href = "/admin/files/" + obj.id;
                }
            });

        });
    </script>
@endsection
