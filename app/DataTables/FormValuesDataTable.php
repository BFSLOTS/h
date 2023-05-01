<?php

namespace App\DataTables;

use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Html\Editor\Editor;
use App\Category;
use App\Form;
use Illuminate\Http\Request;
use App\Models\FormValue;
use App\Models\UserForm;
use App\QuestionAnalytic;

class FormValuesDataTable extends DataTable
{

    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addIndexColumn('DT_RowIndex')
            ->addColumn('user', function (FormValue $formValue) {
                $tu = '';
                if ($formValue->User) {
                    $tu = $formValue->User->name;
                }
                return $tu;
            })
            ->editColumn('created_at', function (FormValue $formValue) {
                return $formValue->created_at->toDateTimeString();
            })
            ->editColumn('amount', function (FormValue $formValue) {
                return $formValue->currency_symbol.$formValue->amount;
            })
            ->addColumn('action', function (FormValue $formValue) {
                return view('form_value.action', compact('formValue'));
            })
            ->rawColumns(['action']);
    }

    public function query(FormValue $model, Request $request)
    {
        $usr = \Auth::user();
        if ($usr->type != 'Admin') {
            $role_id = $usr->roles->first()->id;

            $form_values =  $model->newQuery()->select(['form_values.*', 'forms.title'])
                ->join('forms', 'forms.id', '=', 'form_values.form_id')
                ->leftJoin('users', 'users.id', 'form_values.user_id')
                ->whereIn('form_values.form_id', function ($query) use ($role_id) {
                    $query->select('form_id')->from('user_forms')->where('role_id', $role_id);
                });
        } else {
            $form_values = FormValue::select(['form_values.*', 'forms.title'])->join('forms', 'forms.id', '=', 'form_values.form_id')->leftJoin('users', 'users.id', 'form_values.user_id');
        }
        if ($request->start_date && $request->end_date) {
            $form_values->whereBetween('form_values.created_at', [$request->start_date, $request->end_date]);
        }
        if ($request->form) {
            $form_values->where('form_values.form_id', '=', $request->form);
        }
        return $form_values;
    }

    public function html()
    {
        return $this->builder()
            ->setTableId('forms-table')
            ->addIndex()
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(3)
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
            ['name' => 'id', 'title' => 'no', 'data' => "DT_RowIndex"],
            Column::make('title')->name('forms.title'),
            Column::make('user')->title(__('User')),
            Column::make('amount')->title(__('Amount')),
            Column::make('transaction_id')->title(__('Transaction Id')),
            Column::make('payment_type')->title(__('Payment Type')),
            Column::make('created_at'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-end'),
        ];
    }

    protected function filename()
    {
        return 'FormValues_' . date('YmdHis');
    }
}
