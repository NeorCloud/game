<div class="form-group row">
    <label for="roles" class="col-md-2 col-form-label">@lang('Roles')</label>

    <div class="col-md-10">
        @include('backend.auth.includes.partials.role-type', ['type' => $model::TYPE_ADMIN])
    </div>
</div><!--form-group-->
