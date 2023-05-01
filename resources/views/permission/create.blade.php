{!! Form::open(['route' => 'permission.store', 'method' => 'Post', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="form-group col-6 ">
        {{ Form::label('name', __('Name'), ['class' => 'form-label']) }}

        {!! Form::text('name', null, ['placeholder' => 'Name', 'class' => 'form-control']) !!}
    </div>
</div>
<div class="modal-footer">
    <div class="btn-flt float-end">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
        <button type="sub" class="btn btn-primary">{{ __('Save') }}</button>
    </div>
</div>
{!! Form::close() !!}
