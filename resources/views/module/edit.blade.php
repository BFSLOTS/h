@extends('layouts.main')
@section('title', __('Module'))
@section('breadcrumb')
<div class="col-md-12">
    <div class="page-header-title">
        <h4 class="m-b-10">{{ __('Module') }}</h4>
    </div>
    <ul class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
        <li class="breadcrumb-item"><a href="{{ route('module.index') }}">{{ __('Module') }}</a></li>
        <li class="breadcrumb-item"> {{ __('Edit') }} </li>
    </ul>
</div>
@endsection
@section('content')
<div class="row">
                <form class="form-horizontal" method="POST" action="{{ route('module.update', $module->id) }}">
                    @csrf
                    @method('PUT')
                    <div class="row">
                        <div class="col-xl-12 order-xl-1">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="heading-small text-muted mb-4">{{ __('Edit Module') }}</h6>
                                    <div class="pl-lg-4">
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <div class="form-group">
                                                    <label for="name" class="form-label">{{ __('Name of Module') }}</label>
                                                    <input type="text" value="{{ $module->name }}" name="name"
                                                        class="form-control" id="password"
                                                        placeholder="{{ __('Name of Module') }}">
                                                    @if ($errors->has('module'))
                                                        <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $errors->first('module') }}</strong>
                                                        </span>
                                                    @endif
                                                    <input type="hidden" value="{{ $module->name }}" name="old_name"
                                                        class="form-control" id="password">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class=" mt-4 ">
                                        <button type="submit"
                                            class="btn btn-primary col-md-2 float-right ">{{ __('Update Module') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
@endsection
