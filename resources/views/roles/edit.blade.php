{!! Form::model($role, ['route' => ['roles.update', $role->id], 'method' => 'Put', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="form-group">
        {{ Form::label('name', __('Name'), ['class' => 'col-form-label']) }}

            {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter First Name')]) }}
    </div>
</div>
<div class="modal-footer">
    <div class="btn-flt float-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="sub" class="btn btn-primary">{{ __('Save') }}</button>
    </div>
</div>
{!! Form::close() !!}
