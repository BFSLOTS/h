
{!! Form::open(['route' => 'test.send.mail', 'method' => 'Post', 'enctype' => 'multipart/form-data']) !!}
<div class="row">
    <div class="form-group col-12 ">
        <label class="form-control-label" class="form-label" for="email">{{ __('Email') }}</label>
        <div class="input-group ">

            <input type="text" name="email" class="form-control" placeholder="{{ __('Enter Email') }} " required>
            @error('email')
                <span class="invalid-email" role="alert">
                    <strong class="text-danger">{{ $message }}</strong>
                </span>
            @enderror
        </div>
    </div>
</div>
<hr>
<div class="float-right">
    <button class="btn btn-primary" type="submit" id="save-btn">{{ __('Save Changes') }}</button>
    <a href="{{ route('setting', 'mail-setting') }}" class="btn btn-secondary">{{ __('Cancel') }}</a>
</div>
{!! Form::close() !!}

