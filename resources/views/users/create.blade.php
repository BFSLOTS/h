{!! Form::open(['route' => 'users.store', 'method' => 'Post', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="form-group  ">
        {{ Form::label('name', __('Name'), ['class' => 'col-form-label']) }}

        {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => __('Enter Name')]) !!}
    </div>
    <div class="form-group ">
        {{ Form::label('email', __('Email'), ['class' => 'col-form-label']) }}
        <div class="input-group">

            {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => __('Enter Email Address')]) !!}
        </div>
    </div>
    <div class="form-group  ">
        {{ Form::label('password', __('Password'), ['class' => 'col-form-label']) }}

        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => __('Enter  Password')]) !!}
    </div>
    <div class="form-group  ">
        {{ Form::label('confirm-password', __('Confirm Password'), ['class' => 'col-form-label']) }}

        {{ Form::password('confirm-password', ['class' => 'form-control','placeholder' => _('Enter Confirm Password')]) }}
    </div>
    <div class="form-group ">
        {{ Form::label('roles', __('Role'), ['class' => 'col-form-label']) }}

        {!! Form::select('roles', $roles, null, ['class' => 'form-select']) !!}
    </div>
</div>
<div class="modal-footer">
    <div class="btn-flt float-end">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Close') }}</button>
        <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>
    </div>
</div>
{!! Form::close() !!}
