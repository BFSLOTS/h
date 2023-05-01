<?php

namespace App\Http\Controllers;

use App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;
use App\Role;
use Image;
use URL;
use Auth;
use PragmaRX\Countries\Package\Countries;
use Illuminate\Support\Collection;
use App\Google2fa as TwoFactor;
use Google2FA;
use Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $country;

    public function __construct(Countries $country)
    {
        if (setting('email_verification')) {
            $this->middleware(['verified']);
        }
        $this->middleware(['auth', 'web']);
        $this->countries = $country->all()->sortBy('name.common')->pluck('name.common');
    }

    public function index()
    {
        if (!setting('2fa')) {
            $user = auth()->user();
            $role = $user->roles->first();
            $countries = $this->countries;
            return view('profile.index', [
                'user' => $user,
                'role' => $role,
                'countries' => $countries,
            ]);
        }
        return $this->activeTwoFactor();
    }

    private function activeTwoFactor()
    {
        $user = Auth::user();
        $google2fa_url = "";
        $secret_key = "";
        if ($user->loginSecurity()->exists()) {
            $google2fa = (new \PragmaRX\Google2FAQRCode\Google2FA());
            $google2fa_url = $google2fa->getQRCodeInline(
                @setting('app_name'),
                $user->name,
                $user->loginSecurity->google2fa_secret
            );
            $secret_key = $user->loginSecurity->google2fa_secret;
        }
        $user = auth()->user();
        $role = $user->roles->first();
        $countries = $this->countries;
        $data = array(
            'user' => $user,
            'secret' => $secret_key,
            'google2fa_url' => $google2fa_url,
            'countries' => $countries
        );
        return view('profile.index', [
            'user' => $user,
            'role' => $role,
            'secret' => $secret_key,
            'google2fa_url' => $google2fa_url,
            'countries' => $countries
        ]);
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $this->validate($request, [
            'fullname' => 'required|regex:/^[A-Za-z0-9_.,() ]+$/|max:255',
            'address' => 'nullable|regex:/^[A-Za-z0-9_.,() ]+$/|string',
            'country' => 'nullable|string',
            'phone' => 'nullable|string',
        ], [
            'fullname.regex' =>  __('Invalid Entry! The fullname only letter and numbers are allowed'),
            'address.regex' =>  __('Invalid Entry! The address only letter and numbers are allowed'),
        ]);
        $user->name = $request->fullname;
        $user->address = $request->address;
        $user->country = $request->country;
        $user->phone = $request->phone;
        $user->save();

        return redirect()->back()->with('success',  __('Account details Updated Successfully'));
    }

    public function updateAvatar(Request $request, $id)
    {
        $disk = Storage::disk();
        $user = User::find($id);
        $this->validate($request, [
            'avatar' => 'required|',
        ]);
        $image = $request->avatar;
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imagename = time() . '.' . 'png';
        $imagepath = "uploads/avatar/" . $imagename;
        $disk->put($imagepath, base64_decode($image));
        $user->avatar = $imagepath;
        if ($user->save()) {
            return __("Avatar Updated Successfully");
        }
        return __("Avatar Updated Failed");
    }

    public function updateLogin(Request $request, $id)
    {
        $user = User::find($id);
        $this->validate($request, [
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:5|confirmed',
            'password_confirmation' => 'same:password',
        ], [
            'regex' =>  __('Invalid Entry! The username only letter and numbers are allowed'),
        ]);

        $user->email = $request->email;
        if (!is_null($request->password)) {
            $user->password = bcrypt($request->password);
        }
        $user->save();
        return redirect()->back()->with('success',  __('Login details Updated Successfully'));
    }

    private function generateCode()
    {
        $google2fa = app('pragmarx.google2fa');
        $generated = $google2fa->getQRCodeInline(
            config('app.name'),
            auth()->user()->name,
            auth()->user()->google2fa->google2fa_secret
        );
        return $generated;
    }

    public function activate()
    {
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $google2fa = $google2fa->generateSecretKey();
        TwoFactor::create([
            'user_id' => $user->id,
            'google2fa_enable' => 0,
            'google2fa_secret' => $google2fa
        ]);
        return redirect()->back()->with('success',  __('2-Factor Activated'));
    }

    public function profileStatus()
    {
        $user = User::find(Auth::user()->id);
        // dd($user);
        $user->active_status = 0;
        $user->save();
        auth()->logout();
        return redirect()->route('home');
    }
    
    public function enable(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
        ]);
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        $verified = $google2fa->verifyKey($user->google2fa->google2fa_secret, $request->code);
        if ($verified) {
            $user->google2fa->google2fa_enable = 1;
            $user->google2fa->save();
            return redirect()->back()->with('success',  __('2-Factor Enabled'));
        }
        return redirect()->back()->with('fail',  __('Verification Code is Invalid'));
    }

    public function disable(Request $request)
    {
        $this->validate($request, [
            'code' => 'required',
            'password' => 'required',
        ]);
        $user = Auth::user();
        $google2fa = app('pragmarx.google2fa');
        if (Hash::check($request->password, $user->password)) {
            $verified = $google2fa->verifyKey($user->google2fa->google2fa_secret, $request->code);
            if ($verified) {
                $user->google2fa->delete();
                return redirect()->back()->with('success',  __('2-Factor Disabled'));
            }
            return redirect()->back()->with('fail',  __('Verification Code is Invalid'));
        } else {
            return redirect()->back()->with('fail',  __('Invalid Password! Check Password and try again'));
        }
    }

    public function verify()
    {
        return redirect(URL()->previous());
    }

    public function instruction()
    {
        return view('google2fa.instruction');
    }

}
