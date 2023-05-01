@extends('layouts.main')
@section('title', __('Users'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Users List') }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item">{{ __('Users') }}</li>
        </ul>
    </div>
@endsection
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive py-5 pb-4  ">
                        <div class="container-fluid">
                            {{ $dataTable->table(['width' => '100%']) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('style')
    @include('layouts.includes.datatable_css')
@endpush
@push('script')
    @include('layouts.includes.datatable_js')
    {{ $dataTable->scripts() }}
    <script>
        $(function() {
            $('body').on('click', '.add_user', function() {
                var modal = $('#common_modal');
                $.ajax({
                    type: "GET",
                    url: '{{ route('users.create') }}',
                    data: {},
                    success: function(response) {
                        modal.find('.modal-title').html('{{ __('Create User') }}');
                        modal.find('.modal-body').html(response.html);
                        if (jQuery().select2) {
                            $(".roles").select2({
                                dropdownParent: $('#common_modal')
                            });
                        }
                        modal.modal('show');
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            });
            $('body').on('click', '#edit-user', function() {
                var action = $(this).data('action');
                var modal = $('#common_modal');
                $.get(action, function(response) {
                    modal.find('.modal-title').html('{{ __('Edit User') }}');
                    modal.find('.modal-body').html(response.html);
                    modal.modal('show');
                })
            });
        });
    </script>
@endpush
