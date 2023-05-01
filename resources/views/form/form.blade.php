    <div class="row mx-0 mt-5">
        <div class="col-md-5 mx-auto">
            @if (!empty($form->logo))
                <div class="text-center gallery gallery-md">
                    <img id="app-dark-logo" class="gallery-item float-none"
                        src="{{ asset('storage/app/' . $form->logo) }}" alt="form_logo">
                </div>
            @endif
            <div class="card">
                <div class="card-header">
                    <h5 class="text-center w-100">{{ $form->title }}</h5>
                </div>
                <div class="card-body">
                    {{-- {{ Form::model($form, ['route' => ['forms.fill.store', $form->id], 'method' => 'PUT', 'id' => 'fill-form', 'enctype' => 'multipart/form-data']) }} --}}
                    <form action="{{ route('forms.fill.store', $form->id) }}" method="POST"
                        enctype="multipart/form-data" id="fill-form">
                        @method('PUT')
                        @if (session()->has('success'))
                            <div class="text-center gallery" id="success_loader">
                                <img src="{{ asset('assets/images/success.gif') }}" />
                                <br>
                                <br>
                                <h2 class="w-100 ">{{ session()->get('success') }}</h2>
                            </div>
                        @else
                            <div class="row">
                                @foreach ($array as $row_key => $row)
                                    @php
                                        if (isset($row->column)) {
                                            if ($row->column == 1) {
                                                $col = 'col-12';
                                            } elseif ($row->column == 2) {
                                                $col = 'col-6';
                                            } elseif ($row->column == 3) {
                                                $col = 'col-4';
                                            }
                                        } else {
                                            $col = 'col-12';
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
                                                    $attr = ['class' => 'custom-control-input', 'id' => $row->name . '_' . $key];
                                                    $attr['name'] = $row->name . '[]';
                                                    if ($row->required) {
                                                        $attr['required'] = 'required';
                                                    }
                                                    if ($row->inline) {
                                                        $class = 'form-check form-check-inline col-4 ';
                                                        $attr['class'] = 'custom-check-input';
                                                        $l_class = 'custom-check-label mb-0 ml-1';
                                                    } else {
                                                        $class = 'custom-control custom-checkbox';
                                                        $attr['class'] = 'custom-control-input';
                                                        $l_class = 'custom-control-label';
                                                    }
                                                @endphp
                                                <div class="{{ $class }}">

                                                    {{ Form::checkbox($row->name, $options->value, isset($options->selected) && $options->selected == 1 ? true : false, $attr) }}
                                                    <label class="{{ $l_class }}"
                                                        for="{{ $row->name . '_' . $key }}">{{ $options->label }}</label>
                                                </div>

                                            @endforeach
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
                                            }
                                        @endphp
                                        <div class="form-group {{ $col }}">
                                            {{ Form::label($row->name, $row->label) }}@if ($row->required) * @endif
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
                                                    $attr = ['class' => 'custom-control-input', 'id' => $row->name . '_' . $key];
                                                    if ($row->required) {
                                                        $attr['required'] = 'required';
                                                    }
                                                    if ($row->inline) {
                                                        $class = 'form-check form-check-inline ';
                                                        $attr['class'] = 'custom-check-input';
                                                        $l_class = 'custom-check-label mb-0 ml-1';
                                                    } else {
                                                        $class = 'custom-control custom-radio';
                                                        $attr['class'] = 'custom-control-input';
                                                        $l_class = 'custom-control-label';
                                                    }
                                                @endphp
                                                <div class=" {{ $class }}">
                                                    {{ Form::radio($row->name, $options->value, isset($options->selected) && $options->selected ? true : false, $attr) }}
                                                    <label class="{{ $l_class }}"
                                                        for="{{ $row->name . '_' . $key }}">{{ $options->label }}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    @elseif($row->type == 'select' || $row->type == 'autocomplete')
                                        <div class="form-group {{ $col }}">
                                            @php
                                                $attr = ['class' => 'form-control custom_select', 'id' => $row->name];
                                                if ($row->required) {
                                                    $attr['required'] = 'required';
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
                                                {{ Form::label($row->name, $row->label) }}@if ($row->required) *
                                                @endif
                                                <div class="input-group">
                                                    {{ Form::select($row->name, $values, $selected, $attr) }}
                                                    <div class="input-group-append">
                                                        <button type="button"
                                                            class="btn btn-outline-primary open-photo">{{ __('Add Photo') }}</button>
                                                    </div>
                                                </div>
                                            @else
                                                {{ Form::label($row->name, $row->label) }}@if ($row->required) *
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
                                                }
                                            @endphp
                                            {{ Form::label($row->name, $row->label) }}@if ($row->required) *
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
                                                }
                                            @endphp
                                            {{ Form::label($row->name, $row->label) }}
                                            @if ($row->required) *
                                            @endif
                                            {{ Form::number($row->name, isset($row->value) ? $row->value : null, $attr) }}
                                        </div>
                                    @elseif($row->type == 'textarea')

                                        <div class="form-group {{ $col }}">
                                            @php
                                                $attr = ['class' => 'form-control text-area-height'];
                                                if ($row->required) {
                                                    $attr['required'] = 'required';
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
                                                $attr = ['class' => 'form-control'];
                                                if ($row->required) {
                                                    $attr['required'] = 'required';
                                                }
                                                if (isset($row->maxlength)) {
                                                    $attr['max'] = $row->maxlength;
                                                }
                                                if (isset($row->placeholder)) {
                                                    $attr['placeholder'] = $row->placeholder;
                                                }
                                                $value = isset($row->value) ? $row->value : '';
                                                if ($row->subtype == 'datetime-local') {
                                                    $row->subtype = 'text';
                                                    $attr['class'] = $attr['class'] . ' date_time';
                                                }
                                            @endphp
                                            {{ Form::label($row->name, $row->label) }}@if ($row->required) *
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
                                            {{ Form::label($row->name, $row->label) }}@if ($row->required) * @endif
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
                                @if (!isset($form_value) && $form->payment_status == 1)

                                    <div class="col-md-12 ">
                                        <strong class="d-block">{{ __('Payment') }}
                                            ({{ $form->currency_symbol }}{{ $form->amount }})</strong>

                                        <div id="card-element" class="form-control">
                                            <!-- a Stripe Element will be inserted here. -->
                                        </div>
                                        <span id="card-errors" class="payment-errors"
                                            style="color: red; font-size: 22px; "></span>
                                        <br>
                                    </div>
                                @endif
                            </div>
                            @if (isset($form_value))
                                <div class="cap">
                                    @if (setting('captcha') == 'hcaptcha')
                                        {!! HCaptcha::renderJs() !!}
                                        {!! HCaptcha::display() !!}
                                    @endif
                                    @if (setting('captcha') == 'recaptcha')
                                        {!! NoCaptcha::renderJs() !!}
                                        {!! NoCaptcha::display() !!}
                                    @endif
                                </div>

                                <div class="form-actions pb-0 mt-3">
                                    {{ Form::hidden('form_value_id', isset($form_value) ? $form_value->id : '') }}
                                    {{ Form::submit(__('Submit'), ['id' => 'save-form', 'class' => 'btn btn-primary mr-1 float-right']) }}
                                </div>
                            @else
                            <div class="cap">

                                @if (setting('captcha') == 'hcaptcha')
                                    {!! HCaptcha::renderJs() !!}
                                    {!! HCaptcha::display() !!}
                                @endif
                                @if (setting('captcha') == 'recaptcha')
                                    {!! NoCaptcha::renderJs() !!}
                                    {!! NoCaptcha::display() !!}
                                @endif
                            </div>

                                <div class="form-actions pb-0 mt-3">
                                    {{ Form::hidden('form_value_id', '') }}
                                    {{ Form::submit(__('Submit'), ['id' => 'save-form', 'class' => 'btn btn-primary mr-1 float-right']) }}
                                </div>
                            @endif
                        @endif
                        {{ Form::close() }}
                </div>
            </div>
        </div>
    </div>
