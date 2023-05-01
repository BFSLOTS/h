
{!! Form::open(['route' => 'roles.store', 'method' => 'Post', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="form-group">
        {{ Form::label('name', __('Name'),['class'=>'col-form-label']) }}

            {!! Form::text('name', null, ['placeholder' => __('Name'), 'class' => 'form-control']) !!}
    </div>
</div>
<div class="modal-footer">
    <div class="btn-flt float-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="sub" class="btn btn-primary">{{ __('Save') }}</button>
    </div>
</div>
{!! Form::close() !!}
