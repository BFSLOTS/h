<?php

namespace App\Http\Controllers;

use App\DataTables\FormValuesDataTable;
use App\Exports\FormValuesExport;
use App\Facades\UtilityFacades;
use App\Models\Form;
use App\Models\FormValue;
use App\Models\UserForm;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Maatwebsite\Excel\Facades\Excel;

class FormValueController extends Controller
{

    public function index(FormValuesDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-submitted-form')) {
            $forms = Form::all();
            return $dataTable->render('form_value.index', compact('forms'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function showSubmitedForms($form_id, FormValuesDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-submitted-form')) {
            $forms = Form::all();
            $chartData = UtilityFacades::dataChart($form_id);
            $forms_details = Form::find($form_id);
            return $dataTable->render('form_value.view_submited_form', compact('forms','chartData', 'forms_details'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function show($id)
    {
        if (\Auth::user()->can('show-submitted-form')) {
            $form_value = FormValue::find($id);
            $array = json_decode($form_value->json);
            return view('form_value.view', compact('form_value', 'array'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function edit($id)
    {
        $usr = \Auth::user();
        $user_role = $usr->roles->first()->id;
        $form_value = FormValue::find($id);
        $formallowededit = UserForm::where('role_id', $user_role)->where('form_id', $form_value->form_id)->count();
        if (\Auth::user()->can('edit-submitted-form') && $usr->type == 'Admin') {


            $array = json_decode($form_value->json);
            $form = $form_value->Form;
            $frm = Form::find($form_value->form_id);
            return view('form.fill', compact('form', 'form_value', 'array'));
        } else {
            if (\Auth::user()->can('edit-submitted-form') && $formallowededit > 0) {
                $form_value = FormValue::find($id);
                $array = json_decode($form_value->json);
                $form = $form_value->Form;
                $frm = Form::find($form_value->form_id);
                return view('form.fill', compact('form', 'form_value', 'array'));
            } else {
                return redirect()->back()->with('error', __('Permission Denied.'));
            }
        }
    }

    public function destroy($id)
    {
        if (\Auth::user()->can('delete-submitted-form')) {
            FormValue::find($id)->delete();
            return redirect()->back()->with('success',  __('Form successfully deleted!'));
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }

    public function download_pdf($id)
    {
        $form_value = FormValue::where('id', $id )->first();
        if ($form_value) {
            $form_value->createPDF();
        } else {
            $form_value = FormValue::where('id', '=', $id)->first();
            if (!$form_value) {

                $id = Crypt::decryptString($id);
                $form_value = FormValue::find($id);
            }
            if ($form_value) {
                $form_value->createPDF();
            } else {
                return redirect()->route('home')->with('error', __('File is not exist.'));
            }
        }
    }


    public function export(Request $request)
    {
        $form = Form::find($request->form_id);
        return Excel::download(new FormValuesExport($request), $form->title . '.csv');
    }
    public function download_csv_2($id)
    {
        $form_value = FormValue::where('id', '=', $id)->first();
        if (!$form_value) {
            $id = Crypt::decryptString($id);
            $form_value = FormValue::find($id);
        }
        if ($form_value) {
            $form_value->createCSV2();
            return response()->download(storage_path('app/public/csv/Survey_' . $form_value->id . '.xlsx'))->deleteFileAfterSend(true);
        } else {
            return redirect()->route('home')->with('error', __('File is not exist.'));
        }
    }

    public function export_xlsx(Request $request)
    {
        $form = Form::find($request->form_id);
        // $year = Carbon::createFromFormat('m/Y', $request->month_val)->format('Y');
        // $month = Carbon::createFromFormat('m/Y', $request->month_val)->format('m');
        return Excel::download(new FormValuesExport($request), $form->title . '.xlsx');
    }
    public function getGraphData(Request $request, $id)
    {
        $form = Form::find($id);
        $chartData = UtilityFacades::dataChart($id);
        return view('form_value.chart', compact('chartData', 'id', 'form'));

    }
}
