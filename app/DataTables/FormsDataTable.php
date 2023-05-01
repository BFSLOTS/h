<?php

namespace App\DataTables;


use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use App\Category;
use App\Models\User;
use App\Models\Form;
use App\Models\FormValue;
use Hashids\Hashids;

class FormsDataTable extends DataTable
{
    public function dataTable($query)
    {

        return datatables()
            ->eloquent($query)

            ->addColumn('status', function (Form $form) {
                $st = '';
                if ($form->is_active == 1) {
                    $st = '<span class="custom-badge rounded-pill rounded-pill bg-success ">' . __("Active") . '</span>';
                } else {
                    $st = '<span class="custom-badge rounded-pill rounded-pill bg-success ">' . __("In Active") . '</span>';
                }
                return $st;
            })
            ->addColumn('action', function (Form $form) {
                $hashids = new Hashids();
                return view('form.action', compact('form', 'hashids'));
            })
            ->rawColumns(['status', 'location', 'action']);
    }

    public function query(Form $model)
    {
        $usr = \Auth::user();
        if ($usr->type != 'Admin') {
            $role_id = $usr->roles->first()->id;

            return $model->newQuery()->whereIn('id', function ($query) use ($role_id) {
                $query->select('form_id')->from('user_forms')->where('role_id', $role_id);
            });
        } else {
            return $model->newQuery();
        }
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('forms-table')
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
                        window.location = '" . route('forms.create') . "';

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
            Column::make('title')->title(__('Title')),
            Column::make('status')->title(__('Status')),
            Column::computed('action')->title(__('Action'))
                ->exportable(false)
                ->printable(false)
                ->addClass('text-end'),
        ];
    }

    protected function filename()
    {
        return 'Forms_' . date('YmdHis');
    }
}
