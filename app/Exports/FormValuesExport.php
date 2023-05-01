<?php

namespace App\Exports;

use App\Models\Form;
use App\Models\FormValue;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromView;

class FormValuesExport implements FromView
{
    public function __construct(Request $request)
    {
        $this->request = $request;
    }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function view(): View
    {
        $form_values = FormValue::where('form_id', $this->request->form_id);
        if ($this->request->start_date && $this->request->end_date) {
            $form_values->whereBetween('form_values.created_at', [$this->request->start_date, $this->request->end_date]);
        }
        $form_values = $form_values->get();
        return view('export.formvalue', [
            'formvalues' => $form_values
        ]);
    }
}
