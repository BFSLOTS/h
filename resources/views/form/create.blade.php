@extends('layouts.main')
@section('title', __('Form'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Create Form') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('forms.index') }}">{{ __('Form') }}</a></li>
            <li class="breadcrumb-item"> {{ __('Create') }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">


                    <form class="form-horizontal " method="POST" id='payment-form' enctype="multipart/form-data"
                        action="{{ route('forms.store') }}">
                        @csrf
                        <div class="row">
                            <div class="col-xl-6 mx-auto order-xl-1">
                                <div class="card">
                                    <div class="card-header">
                                        <h5>{{ __('Create Form') }}</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class=" row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-label">{{ __('Title of form') }}</label>
                                                    <input type="text" name="title" class="form-control" id="password"
                                                        placeholder="{{ __('Title of form') }}">
                                                    @if ($errors->has('form'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('form') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>

                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name"
                                                        class="form-label">{{ __('Select Logo') }}</label>
                                                    <input type="file" name="form_logo" class="form-control"
                                                        value="Select  Logo">
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('Recipient Emails') }}</label>
                                                    <input type="text" name="email[]" class="form-control inputtags">
                                                </div>
                                            </div>



                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="success_msg"
                                                        class="form-label">{{ __('Success Message') }}</label>
                                                    <textarea name="success_msg" class="form-control" id="success_msg"
                                                        placeholder="{{ __('Success Message') }}"></textarea>
                                                    @if ($errors->has('success_msg'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('success_msg') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="thanks_msg"
                                                        class="form-label">{{ __('Client Message') }}</label>
                                                    <textarea name="thanks_msg" class="form-control" id="thanks_msg"
                                                        placeholder="{{ __('Client Message') }}"></textarea>
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
                                                    {!! Form::select('roles[]', $roles, null, ['class' => 'form-control','id'=>'choices-multiple-remove-button', 'multiple' => 'multiple']) !!}
                                                </div>
                                            </div>
                                            @if ($payment_type)


                                                <div class="col-md-8 form-group">
                                                    <label class="d-block">{{ __('Payment') }}</label>
                                                </div>

                                                <div class="col-md-4">
                                                    <div class="form-check form-switch custom-switch-v1 float-right">
                                                        <input type="checkbox" class="form-check-input input-primary "
                                                            name="payment" id="customswitchv1-1">
                                                        <label class="form-check-label" for="customswitchv1-1"></label>
                                                    </div>
                                                </div>
                                                <div class="card-body d-none" id="payment">
                                                    <div class="col-lg-12">

                                                        <div class="form-group">
                                                            {{ Form::label('payment_type', __('Payment Type'), ['class' => 'form-label']) }}
                                                            {!! Form::select('payment_type', $payment_type, null, ['class' => 'form-control ']) !!}
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-12">
                                                        <div class="form-group">
                                                            <label for="amount"
                                                                class="form-label">{{ __('Amount') }}</label>
                                                            <input type="number" name="amount" class="form-control"
                                                                id="amount" placeholder="{{ __('Amount') }}">
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
                                                                placeholder="{{ __('Currency symbol') }}">
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
                                                                placeholder="{{ __('Currency name') }}">
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
                                            <div class="text-end">
                                            <button type="submit"
                                                class=" form_payment btn btn-primary col-md-3 float-right ">{{ __('Create Form') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
    </div>
@endsection
@push('style')
    <link href="{{ asset('assets/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" />
@endpush
@push('script')
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script src="{{ asset('assets/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"></script>
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
            filebrowserUploadUrl: "{{ route('ckeditors.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
        CKEDITOR.replace('thanks_msg', {
            filebrowserUploadUrl: "{{ route('ckeditors.upload', ['_token' => csrf_token()]) }}",
            filebrowserUploadMethod: 'form'
        });
    </script>
@endpush
