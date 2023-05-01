@extends('layouts.main')
@section('title', __('Permission'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Roles Permissions') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">{{ __('Roles') }}</a></li>
            <li class="breadcrumb-item">@yield('title')</li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">
        @can('role-create')
            <h2 class="section-title"><a href="#" class="btn btn-primary" id="add_user">{{ __('Add Role') }}</a>
            </h2>
        @endcan
        <div class="row">
            <div class="col-md-12 mx-auto">
                <form class="form-horizontal" method="POST" action="{{ route('roles_permit', $role->id) }}">
                    @csrf
                    <div class="card">
                        <div class="card-header">
                            <h5>{{ __('All Permissions') }}</h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-flush permission-table">
                                <thead >
                                    <tr>
                                        <th>{{ __('Module') }}</th>
                                        <th>{{ __('Permissions') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="mb-2">
                                    @foreach ($allmodules as $row)
                                        <tr>
                                            <td> {{ __(ucfirst($row)) }}</td>
                                            <td>
                                                <div class="row">
                                                    <?php
                                                    $default_permissions = ['manage', 'create', 'edit', 'delete', 'view', 'impersonate', 'fill', 'design', 'show', 'download', 'duplicate'];
                                                    ?>
                                                    @foreach ($default_permissions as $permission)
                                                        @if (in_array($permission . '-' . $row, $allpermissions))
                                                            @php($key = array_search($permission . '-' . $row, $allpermissions))
                                                            <div class="col-3 form-check">
                                                                {{ Form::checkbox('permissions[]', $key, in_array($permission . '-' . $row, $permissions), ['class' => 'form-check-input','id' => 'permission_' . $key]) }}
                                                                {{ Form::label('permission_' . $key, ucfirst($permission), ['class' => 'form-check-label']) }}
                                                            </div>
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="float-right p-3">
                                <button type="submit"
                                    class="btn btn-primary float-right">{{ __('Update Permission') }}</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
