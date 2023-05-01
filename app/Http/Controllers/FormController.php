<?php

namespace App\Http\Controllers;

use App\DataTables\FormsDataTable;
use App\Mail\FormSubmitEmail;
use App\Mail\Thanksmail;
use App\Models\Form;
use App\Models\FormValue;
use App\Models\Order;
use App\Models\UserForm;
use App\Rules\CommaSeparatedEmails;
use Exception;
use Illuminate\Http\Request;
use Hashids\Hashids;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Stripe\Charge;
use Stripe\Stripe as StripeStripe;

use Mail;
use Stripe\Customer;

class FormController extends Controller
{
    public function index(FormsDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-form')) {
            return $dataTable->render('form.index');
        } else {
            return redirect()->back()->with('failed', __('Permission Denied.'));
        }
    }

    public function create()
    {
        if (\Auth::user()->can('create-form')) {
            $roles = Role::where('name', '!=', 'Super Admin')->orwhere('name', Auth::user()->type)->pluck('name', 'id');
            $payment_type = [];
            $payment_type['']= 'Select Payment';

            if(env('STRIPESETTING') == 'on') {
                $payment_type['stripe'] = 'stripe';
            }
            if( env('PAYPALSETTING') == 'on') {
                $payment_type['paypal'] = 'paypal';
            }
            if(env('RAZORPAYSETTING') == 'on') {
                $payment_type['razorpay'] = 'razorpay';
            }

            return view('form.create', compact('roles','payment_type'));
        } else {
            return response()->json(['failed' => __('Permission Denied.')], 401);
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create-form')) {
            $rules = [
                'title' => 'required',
            ];
            $validator = \Validator::make($request->all(), $rules);
            $request->validate([
                'email' => ['nullable', new CommaSeparatedEmails],
            ]);
            $validator = \Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('failed', $messages->first());
            }
            $filename = '';
            if (request()->file('form_logo')) {
                $allowedfileExtension = ['jpeg', 'jpg', 'png'];
                $file = $request->file('form_logo');
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $filename = $file->store('form_logo');
                } else {
                    return redirect()->route('forms.index')->with('failed', __('File type not valid'));
                }
            }
            if (isset($request->email) and !empty($request->email)) {
                $emails = implode(',', $request->email);
            }




            $form = Form::create([
                'title' => $request->title,
                'logo' => $filename,
                'email' => $emails,
                'json' => '',
                'html' => '',
                'success_msg' => $request->success_msg,
                'thanks_msg' => $request->thanks_msg,
                'payment_status' => ($request->payment == 'on') ? '1' : '0',
                'amount' => ($request->amount) ? $request->amount : 0,
                'currency_symbol' => $request->currency_symbol,
                'currency_name' => $request->currency_name,
                'payment_type' => $request->payment_type,

            ]);
            $form->assignFormRoles($request->roles);

            return redirect()->route('forms.index')->with('success', __('Form successfully created!'));
        } else {
            return redirect()->back()->with('failed', __('Permission Denied.'));
        }
    }

    public function edit($id)
    {
        $usr = \Auth::user();
        $user_role = $usr->roles->first()->id;
        $formallowededit = UserForm::where('role_id', $user_role)->where('form_id', $id)->count();
        if (\Auth::user()->can('edit-form') && $usr->type == 'Admin') {
            $form = Form::find($id);
            $form_roles = $form->Roles->pluck('id')->toArray();
            $roles = Role::where('name', '!=', 'Super Admin')->pluck('name', 'id');

            $payment_type = [];
            // $payment_type['']= 'Select Payment';

            if(env('STRIPESETTING') == 'on') {
                $payment_type['stripe'] = 'stripe';
            }
            if( env('PAYPALSETTING') == 'on') {
                $payment_type['paypal'] = 'paypal';
            }
            if(env('RAZORPAYSETTING') == 'on') {
                $payment_type['razorpay'] = 'razorpay';
            }

            return view('form.edit', compact('form', 'form_roles', 'roles', 'payment_type'));
        } else {
            if (\Auth::user()->can('edit-form') && $formallowededit > 0) {

                $form = Form::find($id);
                $form_roles = $form->Roles->pluck('id')->toArray();
                $roles = Role::pluck('name', 'id');
                return view('form.edit', compact('form', 'form_roles', 'roles'));
            } else {
                return redirect()->back()->with('failed', __('Permission Denied.'));
            }
        }
    }

    public function update(Request $request, Form $form)
    {
        if (\Auth::user()->can('edit-form')) {

            $rules = [
                'title' => 'required',
            ];
            $validator = \Validator::make($request->all(), $rules);
            $request->validate([
                'email' => ['nullable', new CommaSeparatedEmails],
            ]);

            if ($validator->fails()) {
                $messages = $validator->getMessageBag();
                return redirect()->back()->with('failed', $messages->first());
            }
            $filename = $form->logo;
            $emails = $form->logo;
            if (request()->file('form_logo')) {
                $allowedfileExtension = ['jpeg', 'jpg', 'png'];
                $file = $request->file('form_logo');
                $extension = $file->getClientOriginalExtension();
                $check = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $filename = $file->store('form_logo');
                } else {
                    return redirect()->route('forms.index')->with('failed', __('File type not valid'));
                }
            }


            if (isset($request->email) and !empty($request->email)) {
                $emails = implode(',', $request->email);
            }
            $form->title = $request->title;
            $form->success_msg = $request->success_msg;
            $form->thanks_msg = $request->thanks_msg;
            $form->logo = $filename;
            $form->email = $emails;
            $form->payment_status = ($request->payment == 'on') ? '1' : '0';
            $form->amount = $request->amount;
            $form->currency_symbol = $request->currency_symbol;
            $form->currency_name = $request->currency_name;
            $form->payment_type = $request->payment_type;
            $form->save();
            $form->assignFormRoles($request->roles);

            return redirect()->route('forms.index')->with('success', __('Form successfully updated!'));
        } else {
            return redirect()->back()->with('failed', __('Permission Denied.'));
        }
    }

    public function destroy(Form $form)
    {
        if (\Auth::user()->can('delete-form')) {
            $form->delete();
            return redirect()->back()->with('success', __('Form successfully deleted!'));
        } else {
            return redirect()->back()->with('failed', __('Permission Denied.'));
        }
    }

    public function design($id)
    {
        if (\Auth::user()->can('design-form')) {
            $form = Form::find($id);
            if ($form) {
                return view('form.design', compact('form'));
            } else {
                return redirect()->back()->with('failed', __('Form not found'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permission Denied.'));
        }
    }


    // public function designtest($id)
    // {
    //     if (\Auth::user()->can('design-form')) {
    //         $form = Form::find($id);
    //         if ($form) {
    //             return view('form.test_design', compact('form'));
    //         } else {
    //             return redirect()->back()->with('failed', __('Form not found'));
    //         }
    //     } else {
    //         return redirect()->back()->with('failed', __('Permission Denied.'));
    //     }
    // }

    public function designUpdate(Request $request, $id)
    {
        // dd($request->all());
        if (\Auth::user()->can('design-form')) {
            $form = Form::find($id);
            if ($form) {
                $form->json = $request->json;
                $form->save();

                return redirect()->route('forms.index')->with('success', __('Form successfully updated!'));
            } else {
                return redirect()->back()->with('failed', __('Form not found'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permission Denied.'));
        }
    }

    public function fill($id)
    {
        if (\Auth::user()->can('fill-form')) {
            $form = Form::find($id);
            $user = \Auth::user();
            $form_value = null;
            if ($form) {

                $array = $form->getFormArray();
                return view('form.fill', compact('form', 'form_value', 'array'));
            } else {
                return redirect()->back()->with('failed', __('Form not found'));
            }
        } else {
            return redirect()->back()->with('failed', __('Permission Denied.'));
        }
    }

    public function publicFill($id)
    {
        $hashids = new Hashids('', 20);
        $id = $hashids->decodeHex($id);
        if ($id) {
            $form = Form::find($id);
            $form_value = null;
            if ($form) {
                $array = $form->getFormArray();
                return view('form.public_fill', compact('form', 'form_value', 'array'));
            } else {
                return redirect()->back()->with('failed', __('Form not found'));
            }
        } else {
            abort(404);
        }
    }

    public function fillStore(Request $request, $id)
    {
        $form = Form::find($id);
        if (env('CAPTCHASETTING')) { // issue
            if (env('captcha', $form->created_by) == 'hcaptcha') {
                if (empty($_POST['h-captcha-response'])) {
                    if (isset($request->ajax)) {
                        return response()->json(['is_success' => false, 'message' => __('Please check Hcaptch')], 200);
                    } else {
                        return redirect()->back()->with('failed', __('Please check Hcaptch'));
                    }
                }
            }
            if (env('captcha', $form->created_by) == 'recaptcha') {
                if (empty($_POST['g-recaptcha-response'])) {
                    if (isset($request->ajax)) {
                        return response()->json(['is_success' => false, 'message' => __('Please check Recaptch')], 200);
                    } else {
                        return redirect()->back()->with('failed', __('Please check Recaptch'));
                    }
                }
            }
        }

        if ($form) {
            $questions = [];
            $client_emails = [];
            if ($request->form_value_id) {
                $form_value = FormValue::find($request->form_value_id);
                $array = json_decode($form_value->json);
            } else {
                $array = $form->getFormArray();
            }

            foreach ($array as &$rows) {
                foreach ($rows as &$row) {
                    if ($row->type == 'checkbox-group') {
                        foreach ($row->values as &$value) {
                            if (is_array($request->{$row->name}) && in_array($value->value, $request->{$row->name})) {
                                $value->selected = 1;
                            } else {
                                if (isset($value->selected)) {
                                    unset($value->selected);
                                }
                            }
                        }
                    } elseif ($row->type == 'file') {
                        if (isset($row->multiple)) {

                            if ($request->hasFile($row->name)) {
                                $values = [];
                                $allowedfileExtension = ['jpeg', 'jpg', 'png'];
                                $files = $request->file($row->name);
                                foreach ($files as $file) {
                                    $extension = $file->getClientOriginalExtension();
                                    $check = in_array($extension, $allowedfileExtension);
                                    if ($check) {
                                        $filename = $file->store('form_values/' . $form->id);
                                        $values[] = $filename;
                                    } else {
                                        if (isset($request->ajax)) {
                                            return response()->json(['is_success' => false, 'message' => __('Invalid File type, Please upload jpeg, jpg, png files')], 200);
                                        } else {
                                            return redirect()->back()->with('failed', __('Invalid File type, Please upload jpeg, jpg, png files'));
                                        }
                                    }
                                }
                                $row->value = $values;
                            }
                        } else {

                            if ($request->hasFile($row->name)) {
                                $values = '';
                                $allowedfileExtension = ['jpeg', 'jpg', 'png'];
                                $file = $request->file($row->name);
                                $extension = $file->getClientOriginalExtension();
                                $check = in_array($extension, $allowedfileExtension);
                                if ($check) {
                                    $filename = $file->store('form_values/' . $form->id);
                                    $values = $filename;
                                } else {
                                    if (isset($request->ajax)) {
                                        return response()->json(['is_success' => false, 'message' => __('Invalid File type, Please upload jpeg, jpg, png files')], 200);
                                    } else {
                                        return redirect()->back()->with('failed', __('Invalid File type, Please upload jpeg, jpg, png files'));
                                    }
                                }
                                $row->value = $values;
                            }
                        }
                    } elseif ($row->type == 'radio-group') {
                        foreach ($row->values as &$value) {
                            if ($value->value == $request->{$row->name}) {
                                $value->selected = 1;
                            } else {
                                if (isset($value->selected)) {
                                    unset($value->selected);
                                }
                            }
                        }
                    } elseif ($row->type == 'autocomplete') {
                        if (isset($row->multiple)) {
                            foreach ($row->values as &$value) {
                                if (is_array($request->{$row->name}) && in_array($value->value, $request->{$row->name})) {
                                    $value->selected = 1;
                                } else {
                                    if (isset($value->selected)) {
                                        unset($value->selected);
                                    }
                                }
                            }
                        } else {


                            foreach ($row->values as &$value) {
                                if ($value->value == $request->{$row->name}) {
                                    $value->selected = 1;
                                } else {
                                    if (isset($value->selected)) {
                                        unset($value->selected);
                                    }
                                }
                            }
                        }
                    } elseif ($row->type == 'select') {
                        // d($row
                        if (isset($row->multiple) & !empty($row->multiple)) {
                            foreach ($row->values as &$value) {

                                if (is_array($request->{$row->name}) && in_array($value->value, $request->{$row->name})) {
                                    $value->selected = 1;
                                } else {
                                    if (isset($value->selected)) {
                                        unset($value->selected);
                                    }
                                }
                            }
                        } else {


                            foreach ($row->values as &$value) {
                                if ($value->value == $request->{$row->name}) {
                                    $value->selected = 1;
                                } else {
                                    if (isset($value->selected)) {
                                        unset($value->selected);
                                    }
                                }
                            }
                        }
                    } elseif ($row->type == 'date') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'number') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'textarea') {
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'text') {
                        $client_email = '';

                        if ($row->subtype == 'email') {
                            if (isset($row->is_client_email) && $row->is_client_email) {

                                $client_emails[] = $request->{$row->name};
                            }
                        }
                        $row->value = $request->{$row->name};
                    } elseif ($row->type == 'starRating') {
                        $row->value = $request->{$row->name};
                    }
                }
            }

            if ($request->form_value_id) {
                $form_value->json = json_encode($array);
                $form_value->save();
                // dd($client_email);
            } else {
                if (\Auth::user()) {
                    $user_id = \Auth::user()->id;
                } else {
                    $user_id = NULL;
                }
                $data = [];
                if ($form->payment_status == 1) {
                    if ($form->payment_type == 'stripe') {
                        StripeStripe::setApiKey(env('STRIPE_SECRET', $form->created_by));
                        try {
                            // $customer = Customer::create([
                            //     'name' => 'Jenny Rosen',
                            //     'email' => 'jenyy@hotmail.co.us',
                            //     'address' => [
                            //         'line1' => '510 Townsend St',
                            //         'postal_code' => '98140',
                            //         'city' => 'San Francisco',
                            //         'state' => 'CA',
                            //         'country' => 'US',
                            //     ],
                            // ]);

                            // Customer::createSource(
                            //     $customer->id,
                            //     ['source' => $request->stripeToken]
                            // );

                            $charge = Charge::create([
                                // "customer" => $customer->id,
                                "amount" => $form->amount * 100,

                                "currency" => $form->currency_name,
                                "description" => "Payment from " . config('app.name'),
                                "source" => $request->input('stripeToken')
                            ]);
                        } catch (Exception $e) {
                            return response()->json(['status' => false, 'message' => $e->getMessage()], 200);
                        }
                        if ($charge) {
                            $data['transaction_id'] = $charge->id;
                            $data['currency_symbol'] = $form->currency_symbol;
                            $data['currency_name'] = $form->currency_name;
                            $data['amount'] = $form->amount;
                            $data['payment_type'] = 'Stripe';
                        }
                    } else if ($form->payment_type == 'razorpay') {
                        $data['transaction_id'] = $request->payment_id;
                        $data['currency_symbol'] = $form->currency_symbol;
                        $data['currency_name'] = $form->currency_name;
                        $data['amount'] = $form->amount;
                        $data['payment_type'] = 'Razorpay';
                    }else if ($form->payment_type == 'paypal') {
                        $data['transaction_id'] = $request->payment_id;
                        $data['currency_symbol'] = $form->currency_symbol;
                        $data['currency_name'] = $form->currency_name;
                        $data['amount'] = $form->amount;
                        $data['payment_type'] = 'Paypal';
                    }
                }


                $data['form_id'] = $form->id;
                $data['user_id'] = $user_id;
                $data['json'] = json_encode($array);
                $form_value = FormValue::create($data);
            }


            $emails = explode(',', $form->email);
            try {

                Mail::to($emails)->send(new FormSubmitEmail($form_value));
            } catch (\Exception $e) {
            }
            foreach ($client_emails as $client_email) {
                try {
                    Mail::to($client_email)->send(new Thanksmail($form_value));
                } catch (\Exception $e) {
                }
            }
            $success_msg = strip_tags($form->success_msg);


            if (isset($request->ajax)) {
                return response()->json(['is_success' => true, 'message' => __($success_msg), 'redirect' => route('edit.form.values', $form_value->id)], 200);
            } else {
                return redirect()->back()->with('success', __($success_msg));
            }
        } else {
            if (isset($request->ajax)) {
                return response()->json(['is_success' => false, 'message' => __('Form not found')], 200);
            } else {
                return redirect()->back()->with('failed', __('Form not found'));
            }
        }
    }
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $fileName = $request->upload->store('editor');

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = Storage::url($fileName);
            $msg = 'Image uploaded successfully';
            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";

            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
    public function duplicate(Request $request)
    {

        if (\Auth::user()->can('duplicate-form')) {
            $form = Form::find($request->form_id);
            if ($form) {

                $newform = Form::create([
                    'title' => $form->title . ' (copy)',
                    'logo' => $form->logo,
                    'email' => $form->email,
                    'success_msg' => $form->success_msg,
                    'thanks_msg' => $form->thanks_msg,
                    'json' => $form->json,
                    'html' => $form->html,
                    'payment_status' => $form->payment_status ,
                    'amount' => $form->amount,
                    'currency_symbol' => $form->currency_symbol,
                    'currency_name' => $form->currency_name,
                    'payment_type' => $form->payment_type,
                    'created_by' => $form->created_by,
                    'is_active' => $form->is_active,
                ]);


                return redirect()->back()->with('success', __('Form successfully duplicate!'));
            } else {
                return redirect()->back()->with('error', __('Form not found'));
            }
        } else {
            return redirect()->back()->with('error', __('Permission Denied.'));
        }
    }
    public function ckupload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('images'), $fileName);

            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('images/' . $fileName);

            $msg = __('Image uploaded successfully');

            $response = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $response;
        }
    }
}
