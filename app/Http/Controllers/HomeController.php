<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormValue;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', '2fa']);
    }

    public function index()
    {
        if (!file_exists(storage_path() . "/installed")) {
            header('location:install');
            die;
        } else {

            $usr = \Auth::user();
            $roles = Role::findByName($usr->type);

            $role_id = $roles->id;
            if ($usr->type == 'Admin') {
                $user = User::count();
                $form = Form::count();
                $submitted_form = FormValue::count();
            } else {
                $user = User::count();
                $form = Form::whereIn('id', function ($query) use ($role_id) {
                    $query->select('form_id')->from('user_forms')->where('role_id', $role_id);;
                })->count();

                $submitted_form = FormValue::select(['form_values.*', 'forms.title'])
                    ->join('forms', 'forms.id', '=', 'form_values.form_id')
                    ->leftJoin('users', 'users.id', 'form_values.user_id')
                    ->whereIn('form_values.form_id', function ($query) use ($role_id) {
                        $query->select('form_id')->from('user_forms')->where('role_id', $role_id);
                    })->count();
            }
            return view('dashboard/home', compact('user', 'form', 'submitted_form'));
        }
    }
    public function formchart(Request $request)
    {
        $arrLable = [];
        $arrValue = [];
        for ($i = 0; $i < 30; $i++) {
            $arrLable[] = date("d M", strtotime('-' . $i . ' days'));
            $arrValue[date("d-m", strtotime('-' . $i . ' days'))] = 0;
        }
        $arrLable = array_reverse($arrLable);
        $arrValue = array_reverse($arrValue);
        $usr = \Auth::user();
        $roles = Role::findByName($usr->type);
        $role_id = $roles->id;
        $t = FormValue::select(DB::raw('DATE_FORMAT(created_at,"%d-%m") AS user_month,COUNT(id) AS usr_cnt'))
            ->whereDate('created_at', '>', Carbon::now()->subDays(365)->toDateString())
            ->whereDate('created_at', '<=', Carbon::now()->toDateString())
            ->whereIn('form_values.form_id', function ($query) use ($role_id) {
                $query->select('form_id')->from('user_forms')->where('role_id', $role_id);
            })
            ->groupBy(DB::raw('DATE_FORMAT(created_at,"%d-%m") '))
            ->get()
            ->pluck('usr_cnt', 'user_month')
            ->toArray();
        foreach ($t as $key => $val) {
            $arrValue[$key] = $val;
        }
        $arrValue = array_values($arrValue);

        return response()->json(['lable' => $arrLable, 'value' => $arrValue], 200);
    }
}
