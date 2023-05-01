<?php

namespace App\DataTables;

use App\Models\User;
use App\Models\Role;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;



class UsersDataTable extends DataTable
{

    public function dataTable($query)
    {
        return datatables()
        ->eloquent($query)
        ->addIndexColumn()
            ->addColumn('role', function (User $user) {
                $out = '';
                $out = '<label class="custom-badge rounded-pill rounded-pill bg-primary">' . $user->type . '</label>';
                return $out;
            })
            ->addColumn('action', function (User $user) {
                return view('users.action', compact('user'));
            })

            ->rawColumns(['role', 'action']);
    }

    public function query(User $model)
    {
        return $model->newQuery()->where('id', '!=', 1)->orderBy('id', 'ASC');
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('users-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->language([
                "paginate" => [
                    "next" => '<i class="ti ti-chevron-right"></i>',
                    "previous" => '<i class="ti ti-chevron-left"></i>'
                ]
            ])
            ->parameters([
                "dom" =>  "
                                <'row'<'col-sm-12'><'col-sm-9 'B><'col-sm-3'f>>
                                <'row'<'col-sm-12'tr>>
                                <'row mt-3 '<'col-sm-5'i><'col-sm-7'p>>
                                ",

                'buttons'   => [
                    ['extend' => 'create', 'className' => 'btn btn-primary btn-sm no-corner add_user', 'action' => " function ( e, dt, node, config ) {}"],
                    ['extend' => 'export', 'className' => 'btn btn-primary btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-primary btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-primary btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-primary btn-sm no-corner',],
                    ['extend' => 'pageLength', 'className' => 'btn btn-primary btn-sm no-corner',],
                ],

                "scrollX" => true
            ])
            ->language([
                'buttons' => [
                    'create' => __('Create'),
                    'export' => __('Export'),
                    'print' => __('Print'),
                    'reset' => __('Reset'),
                    'reload' => __('Reload'),
                    'excel' => __('Excel'),
                    'csv' => __('CSV'),
                    'pageLength' => __('Show %d rows'),
                ]
            ]);
    }

    protected function getColumns()
    {
        return [
            Column::make('No')->title(__('No'))->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('name')->title(__('Name')),
            Column::make('role')->title(__('Role')),
            Column::make('email')->title(__('Email')),
            Column::computed('action')->title(__('Action'))

                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),
        ];
    }

    protected function filename()
    {
        return 'Users_' . date('YmdHis');
    }
}
