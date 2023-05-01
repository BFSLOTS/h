@extends('layouts.main')
@section('title', __('Form'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Edit Forms') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('forms.index') }}">{{ __('Form') }}</a></li>
            <li class="breadcrumb-item"> {{ __('Edit') }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">


                    <form class="form-horizontal" enctype="multipart/form-data" method="POST"
                        action="{{ route('forms.update', $form->id) }}">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-xl-6 mx-auto order-xl-1">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('Edit Form') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="name">{{ __('Title of form') }}</label>
                                                    <input type="text" value="{{ $form->title }}" name="title"
                                                        class="form-control" id="password"
                                                        placeholder="{{ __('Title of form') }}">
                                                    @if ($errors->has('form'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('form') }}</strong>
                                                        </span>
                                                    @endif

                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                @if ($form->logo)
                                                    <div class="form-group bg-light text-center">
                                                        <img id="app-dark-logo"
                                                            class=" img-responsive my-5 w-100 justify-content-center text-center"
                                                            src="{{ asset('storage/app/' . $form->logo) }}"
                                                            alt="form_logo">
                                                    </div>
                                                @endif
                                                <div class="form-group">
                                                    <label class="form-label"
                                                        for="name">{{ __('Select Logo') }}</label>
                                                    <input type="file" name="form_logo" class="form-control"
                                                        value="Select  Logo">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('Recipient Emails') }}</label>
                                                    <input type="text" name="email[]" value="{{ $form->email }}"
                                                        class="form-control inputtags">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-label">{{ __('Success Message') }}</label>
                                                    <textarea name="success_msg" class="form-control" id="success_msg"
                                                        placeholder="{{ __('Success Message') }}">{{ $form->success_msg }}</textarea>
                                                    @if ($errors->has('success_msg'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('success_msg') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-label">{{ __('Thanks Message') }}</label>
                                                    <textarea name="thanks_msg" class="form-control" id="thanks_msg"
                                                        placeholder="{{ __('Client Message') }}">{{ $form->thanks_msg }}</textarea>
                                                    @if ($errors->has('thanks_msg'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('thanks_msg') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('Role') }}</label>
                                                    {!! Form::select('roles[]', $roles, $form_roles, ['class' => 'form-control', 'id' => 'choices-multiple-remove-button', 'multiple' => 'multiple']) !!}
                                                </div>
                                            </div>

                                            @if ($payment_type)
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label class="form-label">{{ __('Payment') }}</label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="form-check form-switch custom-switch-v1">
                                                            <label class="form-label custom-switch mt-2 float-right">
                                                                <input name="payment" class="form-check-input"
                                                                    type="checkbox"
                                                                    {{ $form->payment_status == '1' ? 'checked' : 'unchecked' }}>
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="card-body {{ $form->payment_status == '1' ? 'block' : 'd-none' }}"
                                                    id="payment">
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            {{ Form::label('payment_type', __('Payment Type'), ['class' => 'form-label']) }}
                                                            {!! Form::select('payment_type', $payment_type, $form->payment_type, ['class' => 'form-control']) !!}
                                                        </div>
                                                    </div>

                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="amount"
                                                                class="form-label">{{ __('Amount') }}</label>
                                                            <input type="number" name="amount" class="form-control"
                                                                id="amount" placeholder="{{ __('Amount') }}"
                                                                value="{{ $form->amount }}">
                                                            @if ($errors->has('amount'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('amount') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="currency_symbol"
                                                                class="form-label">{{ __('Currency Symbol') }}</label>
                                                            <input name="currency_symbol" class="form-control"
                                                                id="currency_symbol"
                                                                placeholder="{{ __('Currency symbol') }}"
                                                                value="{{ $form->currency_symbol }}">
                                                            @if ($errors->has('currency_symbol'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('currency_symbol') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="currency_name"
                                                                class="form-label">{{ __('Currency Name') }}</label>
                                                            <input name="currency_name" class="form-control"
                                                                id="currency_name"
                                                                placeholder="{{ __('Currency name') }}"
                                                                value="{{ $form->currency_name }}">
                                                            <p>{{ __('The name of currency is to be taken frome this document.') }}
                                                                <a href="https://stripe.com/docs/currencies"
                                                                    class="m-2"
                                                                    target="_blank">{{ __('Document') }}</a>
                                                            </p>

                                                            @if ($errors->has('currency_name'))
                                                                <span class="invalid-feedback" role="alert">
                                                                    <strong>{{ $errors->first('currency_name') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <div class="text-end"> <button type="submit"
                                                class=" form_payment btn btn-primary col-md-3 float-right ">{{ __('Update Form') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
    </div>
@endsection
@push('style')
    <link href="{{ asset('vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
@endpush
@push('script')
    <script src="{{ asset('vendor/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
    <script>
        var multipleCancelButton = new Choices(
            '#choices-multiple-remove-button', {
                removeItemButton: true,
            }
        );
    </script>
    <script src="{{ asset('js/ckeditor/ckeditor.js') }}"></script>
    <script>
        $(document).on('click', "input[name$='payment']", function() {
            if (this.checked) {
                $('#payment').fadeIn(500);
                $("#payment").removeClass('d-none');
                $("#payment").addClass('d-block');
            } else {
                $('#payment').fadeOut(500);
                $("#payment").removeClass('d-block');
                $("#payment").addClass('d-none');
            }
        })
    </script>
    <script>
        CKEDITOR.replace('success_msg', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('thanks_msg', {
            filebrowserUploadUrl: "{{ route('ckeditor.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
