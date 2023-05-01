<?php

namespace App\Http\Controllers;

use App\Facades\UtilityFacades;
use App\Mail\TestMail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Str;

class SettingsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'web',  'permission:manage-setting']);
    }

    public function index()
    {
        return view('settings.main-setting');
    }

    public function appNameUpdate(Request $request)
    {

        $this->validate($request, [
            'app_name' => 'required|min:4',
            'app_logo' => 'image|max:2048|mimes:png',
            'favicon_logo' => 'image|max:2048|mimes:png',
            'app_dark_logo' =>'image|max:2048|mimes:png',

            'app_small_logo' => 'image|max:2048|mimes:png',
        ], [
            'app_name.regex' =>  __('Invalid Entry! The app name only letters and numbers are allowed'),
        ]);
        $app_logo = UtilityFacades::getsettings('app_logo');
        $app_dark_logo = UtilityFacades::getsettings('app_dark_logo');
        
        $app_small_logo = UtilityFacades::getsettings('app_small_logo');
        $favicon_logo = UtilityFacades::getsettings('favicon_logo');

        $data = [
            'app_name' => $request->app_name
        ];
        if ($request->app_logo) {

            $app_logo = 'app-logo' . '.' . 'png';
            $logoPath = "uploads/appLogo";
            $image = request()->file('app_logo')->storeAs(
                $logoPath,
                $app_logo,
            );
            $data['app_logo'] = $image;
        }
        if ($request->app_dark_logo) {

            $app_dark_logo = 'app-dark-logo' . '.' . 'png';
            $logoPath = "uploads/appLogo";
            $image = request()->file('app_dark_logo')->storeAs(
                $logoPath,
                $app_dark_logo,
            );
            $data['app_dark_logo'] = $image;
        }
        if ($request->app_small_logo) {

            $app_small_logo = 'app-small-logo' . '.' . 'png';
            $logoPath = "uploads/appLogo";
            $image = request()->file('app_small_logo')->storeAs(
                $logoPath,
                $app_small_logo,
            );
            $data['app_small_logo'] = $image;
        }
        if ($request->favicon_logo) {

            $favicon_logo = 'app-favicon-logo' . '.' . 'png';
            $logoPath = "uploads/appLogo";
            $image = request()->file('favicon_logo')->storeAs(
                $logoPath,
                $favicon_logo,
            );
            $data['favicon_logo'] = $image;
        }


        $arrEnv = [
            'APP_NAME' => $request->app_name,
        ];
        UtilityFacades::setEnvironmentValue($arrEnv);
        $this->updateSettings($data);
        return redirect()->back()->with('success',  __('App Setting changed successfully'));
    }
    public function appLogoUpdate(Request $request)
    {
        $disk = Storage::disk('');
        $this->validate($request, [
            'app_logo' => 'required|image|max:2048|mimes:jpeg,bmp,png,jpg',
        ]);
        $dark_logo = $request->file('app_logo');
        $app_dark_logo = 'app-logo' . '.' . 'png';
        $logoPath = "uploads/appLogo";
        $data = request()->file('app_logo')->storeAs(
            $logoPath,
            $app_dark_logo,
        );
        $dark_logo_url =  $disk->url($data);
        $data = [
            'app_logo' => $dark_logo_url,
        ];
        $this->updateSettings($data);
        return redirect()->back()->with('success',  __('App-logo changed successfully'));
    }

    public function appThemeUpdate(Request $request)
    {
        $this->validate($request, [
            'app_theme' => 'required',
        ]);
        $data = [
            'app_theme' => $request->app_theme,
            'app_sidebar' => $request->app_sidebar,
            'app_navbar' => $request->app_navbar,
        ];
        $this->updateSettings($data);
        return redirect()->back()->with('success',  __('App-theme changed successfully'));
    }

    public function pusherSettingUpdate(Request $request)
    {
        $this->validate($request, [
            'pusher_id' => 'required|regex:/^[0-9]+$/',
            'pusher_key' => 'required|regex:/^[A-Za-z0-9_.,()]+$/',
            'pusher_secret' => 'required|regex:/^[A-Za-z0-9_.,()]+$/',
            'pusher_cluster' => 'required|regex:/^[A-Za-z0-9_.,()]+$/',
        ], [
            'pusher_id.regex' =>  __('Invalid Entry! The pusher id only letters, underscore and numbers are allowed'),
            'pusher_key.regex' =>  __('Invalid Entry! The pusher key only letters, underscore and numbers are allowed'),
            'pusher_secret.regex' =>  __('Invalid Entry! The pusher secret only letters, underscore and numbers are allowed'),
            'pusher_cluster.regex' =>  __('Invalid Entry! The pusher cluster only letters, underscore and numbers are allowed'),
        ]);
        $data = [
            'pusher_id' => $request->pusher_id,
            'pusher_key' => $request->pusher_key,
            'pusher_secret' => $request->pusher_secret,
            'pusher_cluster' => $request->pusher_cluster,
            'pusher_status' => ($request->pusher_status == 'on') ? 1 : 0,
        ];
        $arrEnv = [
            'PUSHER_APP_ID' => $request->pusher_id,
            'PUSHER_APP_KEY' => $request->pusher_key,
            'PUSHER_APP_SECRET' => $request->pusher_secret,
            'PUSHER_APP_CLUSTER' => $request->pusher_cluster,
        ];
        UtilityFacades::setEnvironmentValue($arrEnv);
        $this->updateSettings($data);
        return redirect()->back()->with('success',  __('Pusher API Keys Updated Successfully'));
    }
    public function testMail()
    {
        return view('settings.test-mail');
    }
    public function wasabiSettingUpdate(Request $request)
    {
        if ($request->settingtype == 's3') {

            $this->validate($request, [
                's3_key' => 'required',
                's3_secret' => 'required',
                's3_region' => 'required',
                's3_bucket' => 'required',
                's3_url' => 'required',
                's3_endpoint' => 'required',
            ], [
                's3_key.regex' =>  __('Invalid Entry! The s3 key only letters, underscore and numbers are allowed'),
                's3_secret.regex' =>  __('Invalid Entry! The s3 secret only letters, underscore and numbers are allowed'),
            ]);
        }
        $s3 = [
            'AWS_ACCESS_KEY_ID' => $request->s3_key,
            'AWS_SECRET_ACCESS_KEY' => $request->s3_secret,
            'AWS_DEFAULT_REGION' => $request->s3_region,
            'AWS_BUCKET' => $request->s3_bucket,
            'AWS_URL' => $request->s3_url,
            'AWS_ENDPOINT' => $request->s3_endpoint,
            'FILESYSTEM_DRIVER' => $request->settingtype,

        ];
        UtilityFacades::setEnvironmentValue($s3);

        $this->updateSettings($request->all());

        return redirect()->back()->with('success',  __('S3 API Keys Updated Successfully'));
    }

    public function emailSettingUpdate(Request $request)
    {
        $this->validate($request, [
            'mail_mailer' => 'required',
            'mail_host' => 'required',
            'mail_port' => 'required',
            'mail_username' => 'required|email',
            'mail_password' => 'required',
            'mail_encryption' => 'required',
            'mail_from_address' => 'required',
            'mail_from_name' => 'required',
        ], [
            'mail_mailer.regex' => 'Required Entry! The Mail Mailer Not allow empty',
            'mail_host.regex' => 'Required Entry! The Mail Host Not allow empty',
            'mail_port.regex' => 'Required Entry! The Mail Port Not allow empty',
            'mail_username.regex' => 'Required Entry! The Username Mailer Not allow empty',
            'mail_password.regex' => 'Required Entry! The Password Mailer Not allow empty',
            'mail_encryption.regex' => 'Invalid Entry! The Mail encryption Mailer Not allow empty',
            'mail_from_address.regex' => 'Invalid Entry! The Mail From Address Not allow empty',
            'mail_from_name.regex' => 'Invalid Entry! The From name Not allow empty',
        ]);
        $data = [
            'mail_mailer' => $request->mail_mailer,
            'mail_host' => $request->mail_host,
            'mail_port' => $request->mail_port,
            'mail_username' => $request->mail_username,
            'mail_password' => $request->mail_password,
            'mail_encryption' => $request->mail_encryption,
            'mail_from_address' => $request->mail_from_address,
            'mail_from_name' => $request->mail_from_name,
        ];
        $arrEnv = [
            'MAIL_MAILER' => $request->mail_mailer,
            'MAIL_HOST' => $request->mail_host,
            'MAIL_PORT' => $request->mail_port,
            'MAIL_USERNAME' => $request->mail_username,
            'MAIL_PASSWORD' => $request->mail_password,
            'MAIL_ENCRYPTION' => $request->mail_encryption,
            'MAIL_FROM_ADDRESS' => $request->mail_from_address,
            'MAIL_FROM_NAME' => $request->mail_from_name,
        ];
        UtilityFacades::setEnvironmentValue($arrEnv);
        $this->updateSettings($data);
        return redirect()->back()->with('success',  __('Email Setting Updated Successfully'));
    }
    public function captchaSettingUpdate(Request $request)
    {
        if ($request->captcha == 'hcaptcha') {
            $this->validate($request, [
                'hcaptcha_key' => 'required',
                'hcaptcha_secret' => 'required',
            ], [
                'hcaptcha_sitekey.regex' =>  __('Invalid Entry! The hcaptcha key only letters, underscore and numbers are allowed'),
                'hcaptcha_secret.regex' =>  __('Invalid Entry! The hcaptcha secret only letters, underscore and numbers are allowed'),
            ]);
        }
        if ($request->captcha == 'recaptcha') {

            $this->validate($request, [
                'recaptcha_key' => 'required',
                'recaptcha_secret' => 'required',
            ], [
                'recaptcha_sitekey.regex' =>  __('Invalid Entry! The hcaptcha key only letters, underscore and numbers are allowed'),
                'recaptcha_secret.regex' =>  __('Invalid Entry! The hcaptcha secret only letters, underscore and numbers are allowed'),
            ]);
        }
        $data = [
            'CAPTCHASETTING' => (isset($request->captchasetting) ? 1 : 0),
            'CAPTCHA_SECRET' => $request->recaptcha_secret,
            'CAPTCHA_SITEKEY' => $request->recaptcha_key,
            'HCAPTCHA_SECRET' => $request->hcaptcha_secret,
            'HCAPTCHA_SITEKEY' => $request->hcaptcha_key,
        ];

        UtilityFacades::setEnvironmentValue($data);

        $input =  $request->all();
        if (isset($request->captchasetting)) {

            $input['captchasetting'] = 1;
        } else {
            $input['captchasetting'] = 0;
        }

        $this->updateSettings($input);

        return redirect()->back()->with('success',  __('Captcha settings Updated Successfully'));
    }

    public function socialSettingUpdate(Request $request)
    {
        // $this->validate($request, [
        //     'socialsetting' => 'required|min:1'
        // ]);

        $googlestatus = 'off';
        $facebookstatus = 'off';
        $githubstatus = 'off';
        $linkedinstatus = 'off';

        if ($request->socialsetting) {


            if (in_array('google', $request->get('socialsetting'))) {
                $this->validate($request, [
                    'google_client_id' => 'required',
                    'google_client_secret' => 'required',
                    'google_redirect' => 'required',
                ], [
                    'google_client_id.regex' => 'Invalid Entry! The google key only letters, underscore and numbers are allowed',
                    'google_client_secret.regex' => 'Invalid Entry! The google secret only letters, underscore and numbers are allowed',
                    'google_redirect.regex' => 'Invalid Entry! The google redirect only letters, underscore and numbers are allowed',
                ]);
                $data = [
                    'GOOGLE_CLIENT_ID' => $request->google_client_id,
                    'GOOGLE_CLIENT_SECRET' => $request->google_client_secret,
                    'GOOGLE_REDIRECT' => $request->google_redirect,
                    'GOOGLESETTING' => (!empty($request->googlesetting)) ? 'on' : 'off',
                ];
                $googlestatus = 'on';
            }
            if (in_array('facebook', $request->get('socialsetting'))) {
                $this->validate($request, [
                    'facebook_client_id' => 'required',
                    'facebook_client_secret' => 'required',
                    'facebook_redirect' => 'required',
                ], [
                    'facebook_client_id.regex' => 'Invalid Entry! The facebook key only letters, underscore and numbers are allowed',
                    'facebook_client_secret.regex' => 'Invalid Entry! The facebook secret only letters, underscore and numbers are allowed',
                    'facebook_redirect.regex' => 'Invalid Entry! The facebook redirect only letters, underscore and numbers are allowed',
                ]);
                $data = [
                    'FACEBOOK_CLIENT_ID' => $request->facebook_client_id,
                    'FACEBOOK_CLIENT_SECRET' => $request->facebook_client_secret,
                    'FACEBOOK_REDIRECT' => $request->facebook_redirect,
                    'FACEBOOKSETTING' => (!empty($request->facebooksetting)) ? 'on' : 'off',
                ];
                $facebookstatus = 'on';
            }
            if (in_array('github', $request->get('socialsetting'))) {
                $this->validate($request, [
                    'github_client_id' => 'required',
                    'github_client_secret' => 'required',
                    'github_redirect' => 'required',
                ], [
                    'github_client_id.regex' => 'Invalid Entry! The github key only letters, underscore and numbers are allowed',
                    'github_client_secret.regex' => 'Invalid Entry! The github secret only letters, underscore and numbers are allowed',
                    'github_redirect.regex' => 'Invalid Entry! The github redirect only letters, underscore and numbers are allowed',
                ]);
                $data = [
                    'GITHUB_CLIENT_ID' => $request->github_client_id,
                    'GITHUB_CLIENT_SECRET' => $request->github_client_secret,
                    'GITHUB_REDIRECT' => $request->github_redirect,
                    'GITHUBSETTING' => (!empty($request->githubsetting)) ? 'on' : 'off',
                ];
                $githubstatus = 'on';
            }
            if (in_array('linkedin', $request->get('socialsetting'))) {

                $this->validate($request, [

                    'linkedin_client_id' => 'required',
                    'linkedin_client_secret' => 'required',
                    'linkedin_redirect' => 'required',
                ], [
                    'linkedin_client_id.regex' => 'Invalid Entry! The linkedin key only letters, underscore and numbers are allowed',
                    'linkedin_client_secret.regex' => 'Invalid Entry! The linkedin secret only letters, underscore and numbers are allowed',
                    'linkedin_redirect.regex' => 'Invalid Entry! The linkedin redirect only letters, underscore and numbers are allowed',
                ]);
                $data = [
                    'LINKEDIN_CLIENT_ID' => $request->linkedin_client_id,
                    'LINKEDIN_CLIENT_SECRET' => $request->linkedin_client_secret,
                    'LINKEDIN_REDIRECT' => $request->linkedin_redirect,
                    'LINKEDINSETTING' => (!empty($request->linkedinsetting)) ? 'on' : 'off',
                ];
                $linkedinstatus = 'on';
            }



            $data = [
                'GOOGLE_CLIENT_ID' => $request->google_client_id,
                'GOOGLE_CLIENT_SECRET' => $request->google_client_secret,
                'GOOGLE_REDIRECT' => $request->google_redirect,
                'FACEBOOK_CLIENT_ID' => $request->facebook_client_id,
                'FACEBOOK_CLIENT_SECRET' => $request->facebook_client_secret,
                'FACEBOOK_REDIRECT' => $request->facebook_redirect,
                'GITHUB_CLIENT_ID' => $request->github_client_id,
                'GITHUB_CLIENT_SECRET' => $request->github_client_secret,
                'GITHUB_REDIRECT' => $request->github_redirect,
                'LINKEDIN_CLIENT_ID' => $request->linkedin_client_id,
                'LINKEDIN_CLIENT_SECRET' => $request->linkedin_client_secret,
                'LINKEDIN_REDIRECT' => $request->linkedin_redirect,
                'GOOGLESETTING' => (in_array('google', $request->get('socialsetting'))) ? 'on' : 'off',
                'FACEBOOKSETTING' => (in_array('facebook', $request->get('socialsetting'))) ? 'on' : 'off',
                'GITHUBSETTING' => (in_array('github', $request->get('socialsetting'))) ? 'on' : 'off',
                'LINKEDINSETTING' => (in_array('linkedin', $request->get('socialsetting'))) ? 'on' : 'off',
            ];
            // dd($data);
        } else {
            $data = [
                'GOOGLESETTING' => 'off',
                'FACEBOOKSETTING' => 'off',
                'GITHUBSETTING' => 'off',
                'LINKEDINSETTING' => 'off',
            ];
        }


        foreach ($data as $key => $value) {
            UtilityFacades::setEnvironmentValue([$key => $value]);
        }


        return redirect()->back()->with('success', __('Social Setting Updated Successfully'));
    }

    public function authSettingsUpdate(Request $request)
    {
        $data = [
            'rtl' => ($request->rtl_setting == 'on') ? '1' : '0',
            '2fa' => ($request->two_factor_auth == 'on') ? 1 : 0,
            'gtag' => $request->gtag,
            'default_language' => $request->default_language,
            'email_verification' => ($request->email_verification == 'on') ? 1 : 0,
            'color' => ($request->color)? $request->color: UtilityFacades::getsettings('color') ,
            'dark_mode'=>$request->dark_mode
        ];
        $this->updateSettings($data);
        return redirect()->back()->with('success',  __('General Settings Updated Successfully'));
    }

    public function paymentSettingUpdate(Request $request)
    {

        $this->validate($request, [
            'paymentsetting' => 'required|min:1'
        ]);

        $stripestatus = 'off';
        $paypalstatus = 'off';
        $razorpaystatus = 'off';
        $Offlinestatus = 'off';


        if (in_array('stripe', $request->get('paymentsetting'))) {

            $this->validate($request, [
                'stripe_key' => 'required',
                'stripe_secret' => 'required',

            ], [
                'stripe_key.regex' => 'Invalid Entry! The stripe key only letters, underscore and numbers are allowed',
                'stripe_secret.regex' => 'Invalid Entry! The stripe secret only letters, underscore and numbers are allowed',

            ]);
            $data = [
                'STRIPE_KEY' => $request->stripe_key,
                'STRIPE_SECRET' => $request->stripe_secret,
                'STRIPESETTING' => (in_array('stripe', $request->get('paymentsetting'))) ? 'on' : 'off',
            ];
            $stripestatus = 'on';
        }

        if (in_array('paypal', $request->paymentsetting)) {

            $this->validate($request, [
                'client_id' => 'required',
                'client_secret' => 'required',

            ], [
                'client_id.regex' => 'Invalid Entry! The stripe key only letters, underscore and numbers are allowed',
                'client_secret.regex' => 'Invalid Entry! The stripe secret only letters, underscore and numbers are allowed',

            ]);
            $data = [
                'PAYPAL_SANDBOX_CLIENT_ID' => $request->client_id,
                'PAYPAL_SANDBOX_CLIENT_SECRET' => $request->client_secret,
                'PAYPALSETTING' => (in_array('paypal', $request->get('paymentsetting'))) ? 'on' : 'off',
            ];
            $paypalstatus = 'on';
        }

        if (in_array('razorpay', $request->paymentsetting)) {

            $this->validate($request, [

                'razorpay_key' => 'required',
                'razorpay_secret' => 'required',
            ], [
                'razorpay_key.regex' => 'Invalid Entry! The stripe secret only letters, underscore and numbers are allowed',
                'razorpay_secret.regex' => 'Invalid Entry! The stripe secret only letters, underscore and numbers are allowed',
            ]);
            $data = [
                'RAZORPAY_KEY' => $request->razorpay_key,
                'RAZORPAY_SECRET' =>  $request->razorpay_secret,
                'RAZORPAYSETTING' => (in_array('razorpay', $request->get('paymentsetting'))) ? 'on' : 'off',
            ];
            $razorpaystatus = 'on';
        }

        if (in_array('offline', $request->paymentsetting)) {

            $this->validate($request, [

                'payment_mode' => 'required',
            ], [
                'payment_mode.regex' => 'Invalid Entry! The payment mode only letters, underscore and numbers are allowed',
                'payment_details.regex' => 'Invalid Entry! The payment details only letters, underscore and numbers are allowed',
            ]);
            $data = [
                'PAYMENT_MODE' => $request->payment_mode,
                'PAYMENT_DETAILS' =>  $request->payment_details,
                'OFFLINESETTING' => (in_array('offline', $request->get('paymentsetting'))) ? 'on' : 'off',
            ];
            $Offlinestatus = 'on';
        }


        $data = [
            'STRIPE_KEY' => $request->stripe_key,
            'STRIPE_SECRET' => $request->stripe_secret,
            'PAYPAL_SANDBOX_CLIENT_ID' => $request->client_id,
            'PAYPAL_SANDBOX_CLIENT_SECRET' => $request->client_secret,
            'RAZORPAY_KEY' => $request->razorpay_key,
            'RAZORPAY_SECRET' =>  $request->razorpay_secret,
            'PAYMENT_MODE' => $request->payment_mode,
            'PAYMENT_DETAILS' =>  $request->payment_details,
            'STRIPESETTING' => (in_array('stripe', $request->get('paymentsetting'))) ? 'on' : 'off',
            'PAYPALSETTING' => (in_array('paypal', $request->get('paymentsetting'))) ? 'on' : 'off',
            'RAZORPAYSETTING' => (in_array('razorpay', $request->get('paymentsetting'))) ? 'on' : 'off',
            'OFFLINESETTING' => (in_array('offline', $request->get('paymentsetting'))) ? 'on' : 'off',

        ];
        foreach ($data as $key => $value) {
            UtilityFacades::setEnvironmentValue([$key => $value]);
        }

        return redirect()->back()->with('success', __('Payment Setting Updated Successfully'));
    }


    private function updateSettings($input)
    {
        foreach ($input as $key => $value) {
            setting([$key => $value])->save();
        }
    }

    public function backupFiles()
    {
        Artisan::call('backup:run', ['--only-files' => true]);
        $output = Artisan::output();
        if (Str::contains($output, 'Backup completed!')) {
            return redirect()->back()->with('success',  __('Application Files Backed-up successgully'));
        } else {
            return redirect()->back()->with('error',  __('Application Files Backed-up failed'));
        }
    }

    public function backupDb()
    {
        Artisan::call('backup:run', ['--only-db' => true]);
        $output = Artisan::output();
        if (Str::contains($output, 'Backup completed!')) {
            return redirect()->back()->with('success',  __('Application Database Backed-up successgully'));
        } else {
            return redirect()->back()->with('error',  __('Application Database Backed-up failed'));
        }
    }

    private function getBackups()
    {
        $path = storage_path('app/app-backups');
        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
        $files = File::allFiles($path);
        $backups = collect([]);
        foreach ($files as $dt) {
            $backups->push([
                'filename' => pathinfo($dt->getFilename(), PATHINFO_FILENAME),
                'extension' => pathinfo($dt->getFilename(), PATHINFO_EXTENSION),
                'path' => $dt->getPath(),
                'size' => $dt->getSize(),
                'time' => $dt->getMTime(),
            ]);
        }
        return $backups;
    }

    public function downloadBackup($name, $ext)
    {
        $path = storage_path('app/app-backups');
        $file = $path . '/' . $name . '.' . $ext;
        $status = Storage::disk('backup')->download($name . '.' . $ext, $name . '.' . $ext);
        return $status;
    }
    public function deleteBackup($name, $ext)
    {
        $path = storage_path('app/app-backups');
        $file = $path . '/' . $name . '.' . $ext;
        $status = File::delete($file);
        if ($status) {
            return redirect()->back()->with('success',  __('Backup deleted successfully'));
        } else {
            return redirect()->back()->with('error',  __('Ops! an error occured, Try Again'));
        }
    }

    function loadsetting($type)
    {
        // $t =  ucfirst(str_replace('-', ' ', $type));
        return view('settings.main-setting');
    }

    public function testSendMail(Request $request)
    {
        $validator = \Validator::make($request->all(), ['email' => 'required|email']);
        if ($validator->fails()) {
            $messages = $validator->getMessageBag();
            return redirect()->back()->with('error', $messages->first());
        }
        try {
            Mail::to($request->email)->send(new TestMail());
        } catch (\Exception $e) {
            $smtp_error = __('E-Mail has been not sent due to SMTP configuration');
            return redirect()->back()->with('error', $smtp_error);
        }
        return redirect()->back()->with('success', __('Email send Successfully.'));
    }
}
