{!! Form::model($permission, ['route' => ['permission.update', $permission->id], 'method' => 'Put', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="form-group col-6 ">
        {{ Form::label('name', __('First Name'), ['class' => 'form-label']) }}

        {{ Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Name']) }}
    </div>
    <div class="modal-footer">
        <div class="btn-flt float-end">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Close') }}</button>
            <button type="sub" class="btn btn-primary">{{ __('Save changes') }}</button>
        </div>
    </div>
    {!! Form::close() !!}
