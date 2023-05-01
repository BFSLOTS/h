@extends('layouts.main')
@section('title', __('Submitted Forms'))
@section('breadcrumb')
    <div class="col-md-12">
        <div class="page-header-title">
            <h4 class="m-b-10">{{ __('Submitted Forms of ' . ' ' . $forms_details->title) }}</h4>
        </div>
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Dashboard') }}</a></li>
            <li class="breadcrumb-item"> {{ __('Submitted Forms') }} </li>
        </ul>
    </div>
@endsection
@section('content')
    <div class="row">

        <div class="main-content">
            <section class="section">

                @if (!empty($forms_details->logo))
                    <div class="text-center gallery gallery-md">
                        <img id="app-dark-logo" class="gallery-item float-none"
                            src="{{ asset('storage/app/' . $forms_details->logo) }}" alt="form_logo">
                    </div>
                @endif
                <h2 class="text-center">{{ $forms_details->title }}</h2>
                <div class="section-body filter">
                    <div class="row">
                        <div class="col-md-12 mt-4">
                            <div class="card p-3">
                                <div class="card-body">
                                    @can('manage-submitted-form')
                                        <div class="form-group text-right row justify-content-end">
                                            <div class="col-lg-3 col-md-3 col-sm-12 d-flex ">
                                                <input type='text' class="form-control mr-1" id="pc-daterangepicker-1"
                                                    placeholder="Select Date Range" name="duration"
                                                    value="{{ __('Select Date Range') }}" />
                                                <input type="hidden" name="form_id" id="form_id"
                                                    value="{{ $forms_details->id }}">
                                                <button class="btn btn-primary btn-lg ml-2" style="margin-right: -17px;"
                                                    id="filter">{{ __('Filter') }}</button>
                                            </div>
                                        </div>
                                    @endcan
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="table-responsive py-4">
                                                {{ $dataTable->table(['width' => '100%']) }}
                                                {!! Form::open(['route' => ['mass.export.csv'], 'method' => 'post', 'id' => 'mass_export']) !!}
                                                {{ Form::hidden('form_id', $forms_details->id) }}
                                                {{ Form::hidden('start_date') }}
                                                {{ Form::hidden('end_date') }}
                                                {!! Form::close() !!}
                                                {!! Form::open(['route' => ['mass.export.xlsx'], 'method' => 'post', 'id' => 'mass_export_xlsx']) !!}
                                                {{ Form::hidden('form_id', $forms_details->id) }}
                                                {{ Form::hidden('start_date') }}
                                                {{ Form::hidden('end_date') }}
                                                {!! Form::close() !!}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-md-12" id="chart_div">
                                    <style>
                                        .pie-chart {
                                            width: 100%;
                                            height: 400px;
                                            margin: 0 auto;
                                            float: right;
                                        }

                                        .text-center {
                                            text-align: center;
                                        }

                                        @media (max-width: 991px) {
                                            .pie-chart {
                                                width: 100%;
                                            }
                                        }

                                    </style>
                                    <script src="{{ asset('assets/js/loader.js') }}"></script>
                                    <script src="{{ asset('vendor/js/jquery.min.js') }}"></script>

                                    <div class="row">
                                        @php($key = 1)
                                        @foreach ($chartData as $chart)
                                            <div class="col-lg-6  mb-3">
                                                @if ($chart['chart_type'] == 'bar')
                                                    <div id="chartDiv-{{ $key }}" class="pie-chart"></div>
                                                @endif
                                                @if ($chart['chart_type'] == 'pie')
                                                    <div id="chartDive-{{ $key }}" class="pie-chart"></div>
                                                @endif

                                            </div>
                                            <script type="text/javascript">
                                                function drawChart{{ $key }}() {
                                                    var data = new google.visualization.DataTable();
                                                    data.addColumn('string', 'Pizza');
                                                    data.addColumn('number', 'Populartiy');
                                                    data.addRows([
                                                        @foreach ($chart['options'] as $label => $count)
                                                            ['{{ $label }}', {{ $count }}],
                                                        @endforeach
                                                    ]);
                                                    var options = {
                                                        title: "{{ $chart['label'] }}",
                                                        sliceVisibilityThreshold: .0,
                                                    };
                                                    @if ($chart['chart_type'] == 'bar')
                                                        var chart = new google.visualization.ColumnChart(document.getElementById('chartDiv-{{ $key }}'));
                                                        chart.draw(data, options);
                                                    @endif
                                                    @if ($chart['chart_type'] == 'pie')
                                                        var chart = new google.visualization.PieChart(document.getElementById('chartDive-{{ $key }}'));
                                                        chart.draw(data, options);
                                                    @endif
                                                }
                                            </script>
                                            @php($key++)
                                        @endforeach
                                    </div>
                                    <script>
                                        window.onload = function() {
                                            google.load("visualization", "1.1", {
                                                packages: ["corechart"],
                                                callback: 'drawAllChart'
                                            });
                                        };

                                        function drawAllChart() {
                                            @php($key = 1)
                                            @foreach ($chartData as $chart)
                                                drawChart{{ $key }}();
                                                @php($key++)
                                            @endforeach
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </section>
        </div>
    </div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}" />
    <link rel="stylesheet" href="{{ asset('vendor/select2/dist/css/select2.min.css') }}">
    @include('layouts.includes.datatable_css')
@endpush
@push('script')
    <script>
        // minimum setup
        document.querySelector("#pc-daterangepicker-1").flatpickr({
            mode: "range"
        });
    </script>
    <script type="text/javascript" src="{{ asset('vendor/daterangepicker/daterangepicker.min.js') }}"></script>
    <script src="{{ asset('vendor/select2/dist/js/select2.full.min.js') }}"></script>
    @include('layouts.includes.datatable_js')
    <script>
        $(document).ready(function() {
            $('.custom_select').select2();
            $(document).on("click", "#filter", function() {
                getData();
            });
            $(document).on("click", ".buttons-csv", function() {
                $("#mass_export input[name='start_date']").val($("#start_date1").val());
                $("#mass_export input[name='end_date']").val($("#end_date1").val());
                $("#mass_export").submit();
            })
            $(document).on("click", ".buttons-excel", function() {
                $("#mass_export_xlsx input[name='start_date']").val($("#start_date1").val());
                $("#mass_export_xlsx input[name='end_date']").val($("#end_date1").val());
                $("#mass_export_xlsx").submit();
            })
            window.LaravelDataTables = null;

            function getData() {
                if (window.LaravelDataTables == null) {
                    window.LaravelDataTables = $("#forms-table").DataTable({
                        "serverSide": true,
                        "processing": true,
                        "ajax": {
                            "url": "{{ route('formvalues.index') }}",
                            "type": "GET",
                            "data": function(data) {
                                for (var i = 0, len = data.columns.length; i < len; i++) {
                                    if (!data.columns[i].search.value) delete data.columns[i].search;
                                    if (data.columns[i].searchable === true) delete data.columns[i]
                                        .searchable;
                                    if (data.columns[i].orderable === true) delete data.columns[i]
                                        .orderable;
                                    if (data.columns[i].data === data.columns[i].name) delete data
                                        .columns[i]
                                        .name;
                                }
                                var filter = $('#pc-daterangepicker-1').val();
                                var spilit = filter.split("to");
                                delete data.search.regex;
                                data.form = $("#form_id").val();
                                    data.start_date = spilit[0];
                                    data.end_date = spilit[1];
                                //  data.start_date = $("#start_date1").val();
                                //  data.end_date = $("#end_date1").val();
                            }
                        },
                        "columns": [{
                                "name": "id",
                                "data": "DT_RowIndex",
                                "title": "{{ __('No') }}",
                                "orderable": true,
                                "searchable": true
                            }, {
                                "data": "title",
                                "name": "forms.title",
                                "title": "{{ __('Title') }}",
                                "orderable": true,
                                "searchable": true
                            }, {
                                "data": "user",
                                "name": "user",
                                "title": "{{ __('User') }}",
                                "orderable": true,
                                "searchable": true
                            },
                            {
                                "data": "amount",
                                "name": "amount",
                                "title": "{{ __('Amount') }}",
                                "orderable": true,
                                "searchable": true
                            },
                            {
                                "data": "transaction_id",
                                "name": "transaction_id",
                                "title": "{{ __('Transaction ID') }}",
                                "orderable": true,
                                "searchable": true
                            },
                            {
                                "data": "payment_type",
                                "name": "payment_type",
                                "title": "{{ __('Payment Type') }}",
                                "orderable": true,
                                "searchable": true
                            },
                            {
                                "data": "created_at",
                                "name": "created_at",
                                "title": "{{ __('Created At') }}",
                                "orderable": true,
                                "searchable": true
                            }, {
                                "data": "action",
                                "name": "action",
                                "title": "{{ __('Action') }}",
                                "orderable": false,
                                "searchable": false,
                                "className": "text-right"
                            }
                        ],
                        "dom": "Bfrtip",
                        "order": [
                            [3, "desc"]
                        ],
                        "language": {
                            "paginate": {
                                "next": "<i class=\"ti ti-chevron-right\"><\/i>",
                                "previous": "<i class=\"ti ti-chevron-left\"><\/i>"
                            }
                        },
                        "language": {
                            "buttons": {
                                "export": "{{ __('Export') }}",
                                "print": "{{ __('Print') }}",
                                "reset": "{{ __('Reset') }}",
                                "reload": "{{ __('Reload') }}",
                                "excel": "{{ __('Excel') }}",
                                "csv": "{{ __('CSV') }}",
                                "pageLength": "{{ __('Show %d rows') }}"
                            }
                        },
                        "dom": "\n<'row'<'col-sm-12'><'col-sm-9 'B><'col-sm-3'f>>\n<'row'<'col-sm-12'tr>>\n<'row mt-3 '<'col-sm-5'i><'col-sm-7'p>>\n",
                        "buttons": [{
                            "extend": "export",
                            "className": "btn btn-primary btn-sm no-corner mass_export",
                        }, {
                            "extend": "print",
                            "className": "btn btn-primary btn-sm no-corner"
                        }, {
                            "extend": "reset",
                            "className": "btn btn-primary btn-sm no-corner"
                        }, {
                            "extend": "reload",
                            "className": "btn btn-primary btn-sm no-corner"
                        }, {
                            "extend": "pageLength",
                            "className": "btn btn-primary btn-sm no-corner"
                        }],
                        "scrollX": true
                    });
                } else {
                    window.LaravelDataTables.ajax.reload();
                }
            }
            getData();
            $(function() {
                function cb(start, end) {
                    $("#duration1").val(start.format('MMM D, YY hh:mm A') + ' - ' + end.format(
                        'MMM D, YY hh:mm A'));
                    $('input[name="start_date1"]').val(start.format('YYYY-MM-DD HH:mm:ss'));
                    $('input[name="due_date1"]').val(end.format('YYYY-MM-DD HH:mm:ss'));
                }
                $('#duration1').daterangepicker({
                    timePicker: true,
                    autoUpdateInput: false,
                    locale: {
                        format: 'MMM D, YY hh:mm A',
                        applyLabel: "{{ __('Apply') }}",
                        cancelLabel: "{{ __('Cancel') }}",
                        fromLabel: "{{ __('From') }}",
                        toLabel: "{{ __('To') }}",
                        daysOfWeek: [
                            "{{ __('Sun') }}",
                            "{{ __('Mon') }}",
                            "{{ __('Tue') }}",
                            "{{ __('Wed') }}",
                            "{{ __('Thu') }}",
                            "{{ __('Fri') }}",
                            "{{ __('Sat') }}"
                        ],
                        monthNames: [
                            "{{ __('January') }}",
                            "{{ __('February') }}",
                            "{{ __('March') }}",
                            "{{ __('April') }}",
                            "{{ __('May') }}",
                            "{{ __('June') }}",
                            "{{ __('July') }}",
                            "{{ __('August') }}",
                            "{{ __('September') }}",
                            "{{ __('October') }}",
                            "{{ __('November') }}",
                            "{{ __('December') }}"
                        ],
                    }
                }, cb);
            });
        });
    </script>
@endpush
