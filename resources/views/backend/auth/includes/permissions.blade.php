<div class="form-group row">
    <label for="permissions" class="col-md-2 col-form-label">@lang('Additional Permissions')</label>

    <div class="col-md-10">
        @include('backend.auth.role.includes.no-permissions-message')
        @include('backend.auth.includes.partials.permission-type', ['type' => $model::TYPE_ADMIN])
    </div>
</div><!--form-group-->
