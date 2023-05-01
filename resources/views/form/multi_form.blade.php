<div class="row mx-0 mt-5">
    <div class="col-md-5 mx-auto">
        {{-- @if (!empty($form->logo))
            <div class="text-center gallery gallery-md">
                <img id="app-dark-logo" class="gallery-item float-none mb-4"
                    src="{{ asset('storage/app/' . $form->logo) }}" alt="form_logo">
            </div>
        @endif --}}
        @if (!empty($form->logo))
            <div class="text-center gallery gallery-md">
                <img id="app-dark-logo" class="gallery-item float-none "
                    src="{{ asset('storage/app/' . $form->logo) }}" alt="form_logo">
            </div>
        @endif
        <div class="card">
            <div class="card-header">
                <h5 class="text-center w-100">{{ $form->title }}</h5>
            </div>
            <div class="card-body">
                {{-- {{ Form::model($form, ['route' => ['forms.fill.store', $form->id], 'method' => 'PUT', 'id' => 'fill-form', 'enctype' => 'multipart/form-data']) }} --}}
                <form action="{{ route('forms.fill.store', $form->id) }}" method="POST" enctype="multipart/form-data"
                    id="fill-form">
                    @method('PUT')
                    @if (session()->has('success'))
                        <div class="text-center gallery" id="success_loader">
                            <img src="{{ asset('assets/images/success.gif') }}" />
                            <br>
                            <br>
                            <h2 class="w-100 ">{{ session()->get('success') }}</h2>
                        </div>
                    @else
                        @foreach ($array as $keys => $rows)
                            <div class="tab">
                                <div class="row">
                                    @foreach ($rows as $row_key => $row)
                                        @php
                                            if (isset($row->column)) {
                                                if ($row->column == 1) {
                                                    $col = 'col-12 step-' . $keys;
                                                } elseif ($row->column == 2) {
                                                    $col = 'col-6 step-' . $keys;
                                                } elseif ($row->column == 3) {
                                                    $col = 'col-4 step-' . $keys;
                                                }
                                            } else {
                                                $col = 'col-12 step-' . $keys;
                                            }
                                        @endphp
                                        @if ($row->type == 'checkbox-group')
                                            <div class="form-group {{ $col }} ">
                                                {{ Form::label($row->name, $row->label . ($row->required ? ' *' : ''), ['class' => 'd-block']) }}
                                                @if (isset($row->description))
                                                    <small class="d-block">{{ $row->description }}</small>
                                                @endif
                                                @foreach ($row->values as $key => $options)
                                                    @php
                                                        $attr = ['class' => 'form-check-input', 'id' => $row->name . '_' . $key];
                                                        $attr['name'] = $row->name . '[]';
                                                        if ($row->required) {
                                                            $attr['required'] = 'required';
                                                            $attr['class'] = $attr['class'] . ' required';
                                                        }
                                                        if ($row->inline) {
                                                            $class = 'form-check col-4 ';
                                                            if ($row->required) {
                                                                $attr['class'] = 'form-check-input required';
                                                            } else {
                                                                $attr['class'] = 'form-check-input';
                                                            }
                                                            $l_class = 'custom-check-label mb-0 ml-1';
                                                        } else {
                                                            $class = 'form-check ';
                                                            if ($row->required) {
                                                                $attr['class'] = 'form-check-input required';
                                                            } else {
                                                                $attr['class'] = 'form-check-input';
                                                            }
                                                            $l_class = 'form-check-label';
                                                        }
                                                    @endphp
                                                    <div class="{{ $class }}">
                                                        {{ Form::checkbox($row->name, $options->value, isset($options->selected) && $options->selected == 1 ? true : false, $attr) }}
                                                        <label class="{{ $l_class }}"
                                                            for="{{ $row->name . '_' . $key }}">{{ $options->label }}</label>
                                                    </div>
                                                @endforeach
                                                @if ($row->required)
                                                    <label class="required-msg form-check-label"
                                                        style="color:red"></label>
                                                @endif
                                            </div>
                                        @elseif($row->type == 'file')
                                            @php
                                                $attr = [];
                                                $attr['class'] = 'form-control';
                                                if (isset($row->multiple)) {
                                                    $attr['multiple'] = 'true';
                                                    $attr['name'] = $row->name . '[]';
                                                }
                                                if (isset($row->required) && (!isset($row->value) || empty($row->value))) {
                                                    $attr['required'] = 'required';
                                                    $attr['class'] = $attr['class'] . ' required';
                                                }
                                            @endphp
                                            <div class="form-group {{ $col }}">
                                                {{ Form::label($row->name, $row->label) }}@if ($row->required)
                                                    *
                                                @endif
                                                {{ Form::file($row->name, $attr) }}
                                                @if (isset($row->description))
                                                    <small>{{ $row->description }}</small>
                                                @endif
                                                <div>
                                                    @if (isset($row->value))
                                                        @if (is_array($row->value))
                                                            <div class="row">
                                                                @foreach ($row->value as $img)
                                                                    <div class="col-3">
                                                                        <img src="{{ Storage::url($img) }}"
                                                                            class="img-responsive img-thumbnail mb-2">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    @endif
                                                </div>
                                            </div>
                                        @elseif($row->type == 'header')
                                            @php
                                                $class = '';
                                                if (isset($row->className)) {
                                                    $class = $class . ' ' . $row->className;
                                                }
                                            @endphp
                                            <div class="{{ $col }}">
                                                <{{ $row->subtype }} class="{{ $class }}">
                                                    {{ $row->label }}
                                                    </{{ $row->subtype }}>
                                            </div>
                                        @elseif($row->type == 'paragraph')
                                            @php
                                                $class = '';
                                                if (isset($row->className)) {
                                                    $class = $class . ' ' . $row->className;
                                                }
                                            @endphp
                                            <div class="{{ $col }}">
                                                <{{ $row->subtype }} class="{{ $class }}">
                                                    {{ $row->label }}
                                                    </{{ $row->subtype }}>
                                            </div>
                                        @elseif($row->type == 'radio-group')
                                            <div class="form-group {{ $col }}">
                                                {{ Form::label($row->name, $row->label . ($row->required ? ' *' : ''), ['class' => 'd-block']) }}
                                                @if (isset($row->description))
                                                    <small class="d-block">{{ $row->description }}</small>
                                                @endif
                                                @foreach ($row->values as $key => $options)
                                                    @php
                                                        // $attr = ['class' => 'form-check-input', 'id' => $row->name . '_' . $key];
                                                        if ($row->required) {
                                                            $attr['required'] = 'required';
                                                            $attr = ['class' => 'form-check-input required', 'required' => 'required', 'id' => $row->name . '_' . $key];
                                                        } else {
                                                            $attr = ['class' => 'form-check-input', 'id' => $row->name . '_' . $key];
                                                        }
                                                        if ($row->inline) {
                                                            $class = 'form-check';
                                                            if ($row->required) {
                                                                $attr['class'] = 'form-check-input required';
                                                            } else {
                                                                $attr['class'] = 'form-check-input';
                                                            }
                                                            $l_class = 'custom-check-label mb-0 ml-1';
                                                        } else {
                                                            $class = 'form-check';
                                                            if ($row->required) {
                                                                $attr['class'] = 'form-check-input required';
                                                            } else {
                                                                $attr['class'] = 'form-check-input';
                                                            }
                                                            $l_class = 'form-check-label';
                                                        }
                                                    @endphp
                                                    <div class=" {{ $class }}">
                                                        {{ Form::radio($row->name, $options->value, isset($options->selected) && $options->selected ? true : false, $attr) }}
                                                        <label class="{{ $l_class }}"
                                                            for="{{ $row->name . '_' . $key }}">{{ $options->label }}</label>
                                                    </div>
                                                @endforeach

                                                @if ($row->required)
                                                    <label class="required-msg form-check-label"
                                                        style="color:red"></label>
                                                @endif
                                            </div>
                                        @elseif($row->type == 'select' || $row->type == 'autocomplete')
                                            <div class="form-group {{ $col }}">
                                                @php
                                                    $attr = ['class' => 'form-control  w-100', 'id' => $row->name, 'choices-single-default','data-trigger'];
                                                    if ($row->required) {
                                                        $attr['required'] = 'required';
                                                        $attr['class'] = $attr['class'] . ' required';
                                                    }
                                                    if (isset($row->multiple) && !empty($row->multiple)) {
                                                        $attr['multiple'] = 'true';
                                                        $attr['name'] = $row->name . '[]';
                                                    }
                                                    if (isset($row->className) && $row->className == 'calculate') {
                                                        $attr['class'] = $attr['class'] . ' ' . $row->className;
                                                    }
                                                    if ($row->label == 'Registration') {
                                                        $attr['class'] = $attr['class'] . ' registration';
                                                    }
                                                    if (isset($row->is_parent) && $row->is_parent == 'true') {
                                                        $attr['class'] = $attr['class'] . ' parent';
                                                        $attr['data-number-of-control'] = isset($row->number_of_control) ? $row->number_of_control : 1;
                                                    }
                                                    $values = [];
                                                    $selected = [];
                                                    foreach ($row->values as $options) {
                                                        $values[$options->value] = $options->label;
                                                        if (isset($options->selected)) {
                                                            $selected[] = $options->value;
                                                        }
                                                    }
                                                @endphp
                                                @if (isset($row->is_parent) && $row->is_parent == 'true')
                                                    {{ Form::label($row->name, $row->label) }}@if ($row->required)
                                                        *
                                                    @endif
                                                    <div class="input-group">
                                                        {{ Form::select($row->name, $values, $selected, $attr) }}
                                                        <div class="input-group-append">
                                                            <button type="button"
                                                                class="btn btn-outline-primary open-photo">{{ __('Add Photo') }}</button>
                                                        </div>
                                                    </div>
                                                @else
                                                    {{ Form::label($row->name, $row->label) }}@if ($row->required)
                                                        *
                                                    @endif
                                                    {{ Form::select($row->name, $values, $selected, $attr) }}
                                                @endif
                                                @if ($row->label == 'Registration')
                                                    <span class="text-warning registration-message"></span>
                                                @endif
                                            </div>
                                        @elseif($row->type == 'date')
                                            <div class="form-group {{ $col }}">
                                                @php
                                                    $attr = ['class' => 'form-control'];
                                                    if ($row->required) {
                                                        $attr['required'] = 'required';
                                                        $attr['class'] = $attr['class'] . ' required';
                                                    }
                                                @endphp
                                                {{ Form::label($row->name, $row->label) }}@if ($row->required)
                                                    *
                                                @endif
                                                {{ Form::date($row->name, isset($row->value) ? $row->value : null, $attr) }}
                                                @if (isset($row->description))
                                                    <small>{{ $row->description }}</small>
                                                @endif
                                            </div>
                                        @elseif($row->type == 'hidden')
                                            <div class="form-group {{ $col }}">
                                                {{ Form::hidden($row->name, isset($row->value) ? $row->value : null) }}
                                            </div>
                                        @elseif($row->type == 'number')
                                            <div class="form-group {{ $col }}">
                                                @php
                                                    $attr = ['class' => 'form-control'];
                                                    if ($row->required) {
                                                        $attr['required'] = 'required';
                                                        $attr['class'] = $attr['class'] . ' required';
                                                    }
                                                @endphp
                                                {{ Form::label($row->name, $row->label) }}
                                                @if ($row->required)
                                                    *
                                                @endif
                                                {{ Form::number($row->name, isset($row->value) ? $row->value : null, $attr) }}
                                            </div>
                                        @elseif($row->type == 'textarea')
                                            <div class="form-group {{ $col }}">
                                                @php
                                                    $attr = ['class' => 'form-control text-area-height'];
                                                    if ($row->required) {
                                                        $attr['required'] = 'required';
                                                        $attr['class'] = $attr['class'] . ' required';
                                                    }
                                                    if (isset($row->rows)) {
                                                        $attr['rows'] = $row->rows;
                                                    } else {
                                                        $attr['rows'] = '3';
                                                    }

                                                    if ($row->subtype == 'ckeditor') {
                                                        $attr['class'] = $attr['class'] . ' ck_editor';
                                                    }
                                                @endphp
                                                {{ Form::label($row->name, $row->label) }}
                                                {{ Form::textarea($row->name, isset($row->value) ? $row->value : null, $attr) }}
                                            </div>
                                        @elseif($row->type == 'button')
                                            <div class="form-group {{ $col }}">
                                                {{ Form::button(__($row->label), ['name' => $row->name, 'type' => $row->subtype, 'class' => $row->className, 'id' => $row->name]) }}
                                            </div>
                                        @elseif($row->type == 'text')
                                            <div class="form-group {{ $col }}">
                                                @php
                                                    $attr = ['class' => 'form-control ' . $row->subtype];
                                                    if ($row->required) {
                                                        $attr['required'] = 'required';
                                                        $attr['class'] = $attr['class'] . ' required';
                                                    }
                                                    if (isset($row->maxlength)) {
                                                        $attr['max'] = $row->maxlength;
                                                    }
                                                    if (isset($row->placeholder)) {
                                                        $attr['placeholder'] = $row->placeholder;
                                                    }
                                                    $value = isset($row->value) ? $row->value : '';
                                                    if ($row->subtype == 'datetime-local') {
                                                        $row->subtype = 'datetime-local';
                                                        $attr['class'] = $attr['class'] . ' date_time';
                                                    }
                                                @endphp
                                                {{ Form::label($row->name, $row->label) }}@if ($row->required)
                                                    *
                                                @endif
                                                {{ Form::input($row->subtype, $row->name, $value, $attr) }}
                                                @if (isset($row->description))
                                                    <small>{{ $row->description }}</small>
                                                @endif
                                            </div>
                                        @elseif($row->type == 'starRating')
                                            <div class="form-group {{ $col }}">
                                                @php
                                                    $value = isset($row->value) ? $row->value : 0;
                                                    $num_of_star = isset($row->number_of_star) ? $row->number_of_star : 5;
                                                @endphp
                                                {{ Form::label($row->name, $row->label) }}@if ($row->required)
                                                    *
                                                @endif
                                                <div id="{{ $row->name }}" class="starRating"
                                                    data-value="{{ $value }}"
                                                    data-num_of_star="{{ $num_of_star }}">
                                                </div>
                                                <input type="hidden" name="{{ $row->name }}"
                                                    value="{{ $value }}" class="calculate"
                                                    data-star="{{ $num_of_star }}">
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                        @if (!isset($form_value) && $form->payment_status == 1)
                            @if (!isset($form_value) && $form->payment_type == 'stripe')
                                <div class="strip">
                                    <strong class="d-block">{{ __('Payment') }}
                                        ({{ $form->currency_symbol }}{{ $form->amount }})</strong>
                                    <div id="card-element" class="form-control">
                                        <!-- a Stripe Element will be inserted here. -->
                                    </div>
                                    <span id="card-errors" class="payment-errors"
                                        style="color: red; font-size: 22px; "></span>
                                    <br>
                                </div>
                            @elseif(!isset($form_value) && $form->payment_type == 'razorpay')
                                <div class="razorpay">
                                    <p>{{ __('Make Payment') }}</p>
                                    <input type="hidden" name="payment_id" id="payment_id">
                                    <h5>{{ __('Payble Amount') }} : {{ $form->currency_symbol }}
                                        {{ $form->amount }}</h5>
                                </div>
                            @elseif(!isset($form_value) && $form->payment_type == 'paypal')
                                <div class="paypal">
                                    <p>{{ __('Make Payment') }}</p>
                                    <input type="hidden" name="payment_id" id="payment_id">
                                    <h5>{{ __('Payble Amount') }} : {{ $form->currency_symbol }}
                                        {{ $form->amount }}</h5>
                                    <div id="paypal-button-container"></div>
                                    <span id="paypal-errors" class="payment-errors"
                                        style="color: red; font-size: 22px; "></span>
                                    <br>

                                </div>
                            @endif
                        @endif
                        <div class="row">
                            <div class="col cap">
                                @if (env('CAPTCHASETTING'))
                                    @if (setting('captcha') == 'hcaptcha')
                                        {!! HCaptcha::renderJs() !!}
                                        {!! HCaptcha::display() !!}
                                    @endif
                                    @if (setting('captcha') == 'recaptcha')
                                        {!! NoCaptcha::renderJs() !!}
                                        {!! NoCaptcha::display() !!}
                                    @endif
                                @endif

                                <div class="form-actions pb-0 mt-3">
                                    <input type="hidden" name="form_value_id"
                                        value="{{ isset($form_value) ? $form_value->id : '' }}" id="form_value_id">
                                </div>
                            </div>
                        </div>
                    @endif
                    {{ Form::close() }}

                    <hr>
                    <div class="text-end">
                        <button type="button" class="btn btn-default" id="prevBtn" style="margin-right:10px;"
                            onclick="nextPrev(-1)">{{ __('Previous') }}</button>
                        <button type="button" class="btn btn-primary" id="nextBtn" style="margin-right:10px;"
                            onclick="nextPrev(1)">{{ __('Next') }}</button>
                    </div>
                    <!-- Circles which indicates the steps of the form: -->
                    <div style="text-align:center;margin-top:5px;">
                        @foreach ($array as $keys => $rows)
                            <span class="step"></span>
                        @endforeach
                    </div>
            </div>
        </div>
    </div>
</div>
