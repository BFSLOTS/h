<?php

namespace App\DataTables;

use App\Models\Module;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ModuleDataTable extends DataTable
{
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn()

            ->addColumn('action', function (module $module) {
                return view('module.action', compact('module'));
            })
            ->editColumn('created_at', function ($request) {
                return $request->created_at->format('d-m-Y');
            });
    }

    public function query(Module $model)
    {
        return $model->newQuery();
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('module-table')
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
                    ['extend' => 'create', 'className' => 'btn btn-primary btn-sm no-corner add_module', 'action' => " function ( e, dt, node, config ) {
                        window.location = '" . route('module.create') . "';

                   }"],
                    ['extend' => 'export', 'className' => 'btn btn-primary btn-sm no-corner',],
                    ['extend' => 'print', 'className' => 'btn btn-primary btn-sm no-corner',],
                    ['extend' => 'reset', 'className' => 'btn btn-primary btn-sm no-corner',],
                    ['extend' => 'reload', 'className' => 'btn btn-primary btn-sm no-corner',],
                    ['extend' => 'pageLength', 'className' => 'btn btn-primary btn-sm no-corner',],
                ],
                "scrollX" => true
            ])->language([
                'buttons'=>[
                    'create'=>__('Create'),
                    'export'=>__('Export'),
                    'print'=>__('Print'),
                    'reset'=>__('Reset'),
                    'reload'=>__('Reload'),
                    'excel'=>__('Excel'),
                    'csv'=>__('CSV'),
                    'pageLength'=>__('Show %d rows'),
                ]
            ]);
    }

    protected function getColumns()
    {
        return [
            Column::make('No')->title(__('No'))->data('DT_RowIndex')->name('DT_RowIndex')->searchable(false)->orderable(false),
            Column::make('created_at')->title(__('Created At')),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->width(120)
                ->addClass('text-center'),

        ];
    }

    protected function filename()
    {
        return 'Module_' . date('YmdHis');
    }
}
