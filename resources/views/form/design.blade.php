@extends('layouts.main')
@section('title', __('Form'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Design Forms') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('forms.index') }}">{{ __('Form') }}</a></li>
            <li class="breadcrumb-item"> {{ __('Design') }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        <div class="main-content" style="min-height: 517px;">
            <section class="section">
                <div class="section-body">
                    {{ Form::model($form, ['route' => ['forms.design.update', $form->id], 'method' => 'PUT', 'id' => 'design-form']) }}
                    <div class="row">
                        <div class="col-xl-12 order-xl-1">
                            <div class="card">
                                <div class="card-header">
                                    <h5>{{ __('Design Form') }}</h5>
                                </div>
                                <div class="card-body">
                                    <div class=" row">
                                        <div class="col-lg-12">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    @php
                                                        $array = json_decode($form->json);
                                                    @endphp
                                                    <ul id="tabs" class="nav nav-tabs mb-3 ui-tabs-nav ui-helper-reset ui-helper-clearfix ui-widget-header ui-corner-all ">
                                                        @if (!empty($form->json))
                                                            @foreach ($array as $key => $data)
                                                                <li class="nav-item ui-state-default ui-corner-top">
                                                                    <a href="#page-{{ $key + 1 }}" class="nav-link">{{ __('Page') . ($key + 1) }}</a>
                                                                </li>
                                                            @endforeach
                                                        @else
                                                            <li><a href="#page-1" >{{ __('Page') }}1</a></li>
                                                        @endif
                                                        <li id="add-page-tab"><a href="#new-page" class="nav-link">+
                                                                {{ __('Page') }}</a>
                                                        </li>
                                                    </ul>
                                                    @if (!empty($form->json))

                                                        @foreach ($array as $key => $data)
                                                            <div id="page-{{ $key + 1 }}" class="build-wrap">
                                                            </div>
                                                        @endforeach
                                                    @else
                                                        <div id="page-1" class="build-wrap"></div>
                                                    @endif

                                                    <div id="new-page"></div>
                                                    <input type="hidden" name="json" value="{{ $form->json }}">
                                                    <br>
                                                    <div class="action-buttons">
                                                        <button id="showData" class="d-none"
                                                            type="button">{{ __('Show Data') }}</button>
                                                        <button id="clearFields" class="d-none"
                                                            type="button">{{ __('Clear All Fields') }}</button>
                                                        <button id="getData" class="d-none"
                                                            type="button">{{ __('Get Data') }}</button>
                                                        <button id="getXML" class="d-none"
                                                            type="button">{{ __('Get XML Data') }}</button>
                                                        <button id="getJSON" class="btn btn-primary"
                                                            type="button">{{ __('Update') }}</button>
                                                        <button id="getJSONs" class="d-none"
                                                            onClick="javascript:history.go(-1)"
                                                            type="button">{{ __('Back') }}</button>
                                                        <button id="getJS" class="d-none"
                                                            type="button">{{ __('Get JS Data') }}</button>
                                                        <button id="setData" class="d-none"
                                                            type="button">{{ __('Set Data') }}</button>
                                                        <button id="addField" class="d-none"
                                                            type="button">{{ __('Add Field') }}</button>
                                                        <button id="removeField" class="d-none"
                                                            type="button">{{ __('Remove Field') }}</button>
                                                        <button id="testSubmit" class="d-none"
                                                            type="submit">{{ __('Test Submit') }}</button>
                                                        <button id="resetDemo" class="d-none"
                                                            type="button">{{ __('Reset Demo') }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{ Form::close() }}
                </div>
            </section>
        </div>
    </div>

@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/jqueryform/css/demo.css') }}">
    <link href="{{ asset('vendor/jqueryform/css/jquery.rateyo.min.css') }}" rel="stylesheet" />
    {{-- <link href="https://code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="{{asset('assets/css/jquery-ui.css')}}">
@endpush
@push('script')
    <script>
        var lang = '{{ app()->getLocale() }}';
        var lang_other = '{{ __('Other') }}';
        var lang_other_placeholder = '{{ __('Enter Please') }}';
        var lang_Page = '{{ __('Page') }}';
        var lang_Custom_Autocomplete = '{{ __('Custom Autocomplete') }}';
    </script>
    <script src="{{ asset('vendor/jqueryform/js/vendor.js') }}"></script>
    <script src="{{ asset('vendor/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <script src="{{ asset('vendor/jqueryform/js/form-builder.min.js') }}"></script>
    <script src="{{ asset('vendor/jqueryform/js/form-render.min.js') }}"></script>
    <script src="{{ asset('vendor/jqueryform/js/demoFirst.js') }}"></script>
    <script src="{{ asset('vendor/jqueryform/js/jquery.rateyo.min.js') }}"></script>
@endpush
