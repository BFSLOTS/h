<?php

use App\Http\Controllers\FormController;
use App\Http\Controllers\FormValueController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\SocialLoginController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/test-mail', [SettingsController::class, 'testMail'])->name('test.mail')->middleware(['auth','xss']);
Auth::routes();

Route::group(['middleware' => ['auth', 'xss']], function () {
    Route::resource('profile', '\App\Http\Controllers\ProfileController');
    Route::resource('users', '\App\Http\Controllers\UserController');
    Route::resource('permission', '\App\Http\Controllers\PermissionController');
    Route::resource('roles', '\App\Http\Controllers\RoleController');
    Route::resource('module', '\App\Http\Controllers\ModuleController');
    Route::resource('formvalues', '\App\Http\Controllers\FormValueController');
});
Route::resource('forms', '\App\Http\Controllers\FormController')->middleware(['auth','xss']);


Route::get('/', [HomeController::class, 'index'])->name('home')->middleware(['auth', 'xss']);
Route::post('/chart', [HomeController::class, 'formchart'])->name('get.chart.data')->middleware(['auth', 'xss',]);


Route::get('/invisible', function () {
    return view('invisible');
});
Route::post('/invisible', function (Request $request) {
    $request->validate([
        'g-recaptcha-response' => 'required|captcha'
    ]);

    return 'Data is valid';
});

Route::get('/form-values/{id}/download/pdf', ['as' => 'download.form.values.pdf', 'uses' => '\App\Http\Controllers\FormValueController@download_pdf'])->middleware(['auth', 'xss']);

Route::get('update-avatar/{id}', [
    'as' => 'update-avatar',
    'uses' => '\App\Http\Controllers\ProfileController@showAvatar'
])->middleware(['auth', 'xss']);

Route::get('design/{id}', [
    'as' => 'forms.design',
    'uses' => '\App\Http\Controllers\FormController@design'
])->middleware(['auth', 'xss']);
// Route::get('test_design/{id}', [
//     'as' => 'forms.design',
//     'uses' => '\App\Http\Controllers\FormController@designtest'
// ])->middleware(['auth', 'xss']);
Route::put('/forms/design/{id}', ['as' => 'forms.design.update', 'uses' => '\App\Http\Controllers\FormController@designUpdate'])->middleware(['auth', 'xss']);

Route::post('update-avatar/{id}', '\App\Http\Controllers\ProfileController@updateAvatar');

Route::post('update-profile-login/{id}', [
    'uses' => '\App\Http\Controllers\ProfileController@updateLogin',
    'as' => 'update-login',
]);
Route::get('account-status/{id}','\App\Http\Controllers\UserController@accountStatus')->name('account.status');
Route::get('profile-status','\App\Http\Controllers\ProfileController@profileStatus')->name('profile.status');

Route::get('/forms/fill/{id}', ['as' => 'forms.fill', 'uses' => '\App\Http\Controllers\FormController@fill'])->middleware(['auth', 'xss']);
Route::get('/forms/survey/{id}', ['as' => 'forms.survey', 'uses' => '\App\Http\Controllers\FormController@publicFill'])->middleware(['xss']);
Route::put('/forms/fill/{id}', ['as' => 'forms.fill.store', 'uses' => '\App\Http\Controllers\FormController@fillStore'])->middleware(['xss']);
Route::get('/form-values/{id}/edit', ['as' => 'edit.form.values', 'uses' => '\App\Http\Controllers\FormValueController@edit'])->middleware(['auth', 'xss']);
Route::get('/form-values/{id}/view', ['as' => 'view.form.values', 'uses' => '\App\Http\Controllers\FormValueController@showSubmitedForms'])->middleware(['auth', 'xss']);
Route::post('/form-duplicate', ['as' => 'forms.duplicate', 'uses' => '\App\Http\Controllers\FormController@duplicate'])->middleware(['auth', 'xss']);
Route::get('/form-values/{id}/download/csv2', ['as' => 'download.form.values.csv2', 'uses' => '\App\Http\Controllers\FormValueController@download_csv_2'])->middleware(['auth', 'xss']);

Route::post('/mass/export/xlsx', ['as' => 'mass.export.xlsx', 'uses' => '\App\Http\Controllers\FormValueController@export_xlsx'])->middleware(['auth', 'xss']);
Route::post('/mass/export/csv', ['as' => 'mass.export.csv', 'uses' => '\App\Http\Controllers\FormValueController@export'])->middleware(['auth', 'xss']);

Route::post('ckeditors/upload', [FormController::class, 'ckupload'])->name('ckeditors.upload')->middleware('auth');


Route::resource('role', '\App\Http\Controllers\RoleController');
Route::post('/role-permission/{id}', [
    'as' => 'roles_permit',
    'uses' => '\App\Http\Controllers\RoleController@assignPermission',
]);

Route::get('/settings', [SettingsController::class, 'index'])->name('settings')->middleware(['auth', 'xss']);

Route::post('settings/app-name/update', [
    'as' => 'settings/app-name/update',
    'uses' => '\App\Http\Controllers\SettingsController@appNameUpdate',
])->middleware(['auth', 'xss']);
Route::post('settings/app-logo/update', [
    'as' => 'settings/app-logo/update',
    'uses' => '\App\Http\Controllers\SettingsController@appLogoUpdate',
])->middleware(['auth', 'xss']);

Route::post('settings/pusher-setting/update', [
    'as' => 'settings/pusher-setting/update',
    'uses' => '\App\Http\Controllers\SettingsController@pusherSettingUpdate',
])->middleware(['auth', 'xss']);

Route::post('settings/wasabi-setting/update', [
    'as' => 'settings/wasabi-setting/update',
    'uses' => '\App\Http\Controllers\SettingsController@wasabiSettingUpdate',
])->middleware(['auth', 'xss']);
Route::post('settings/captcha-setting/update', [
    'as' => 'settings/captcha-setting/update',
    'uses' => '\App\Http\Controllers\SettingsController@captchaSettingUpdate',
])->middleware(['auth', 'xss']);
Route::post('settings/stripe-setting/update', [SettingsController::class, 'paymentSettingUpdate'])->name('settings/stripe-setting/update');
Route::post('settings/social-setting/update', [SettingsController::class, 'socialSettingUpdate'])->name('settings/social-setting/update');

Route::get('/redirect/{provider}', [SocialLoginController::class, 'redirect']);
Route::get('/callback/{provider}', [SocialLoginController::class, 'callback'])->name('social.callback');

Route::post('filter-chart/{id}', [FormValueController::class, 'getGraphData'])->name('filter_chart')->middleware(['auth','xss']);

Route::post('settings/email-setting/update', [
    'as' => 'settings/email-setting/update',
    'uses' => '\App\Http\Controllers\SettingsController@emailSettingUpdate',
])->middleware(['auth', 'xss']);

Route::post('settings/auth-settings/update', [
    'as' => 'settings/auth-settings/update',
    'uses' => '\App\Http\Controllers\SettingsController@authSettingsUpdate',
])->middleware(['auth', 'xss']);

Route::post('test-mail', '\App\Http\Controllers\SettingsController@testSendMail')->name('test.send.mail')->middleware(['auth', 'xss']);
Route::post('/verify-2fa', [
    'as' => 'verify-2fa',
    'uses' => '\App\Http\Controllers\ProfileController@verify'
]);

Route::post('/activate-2fa', [
    'uses' => '\App\Http\Controllers\ProfileController@activate',
    'as' => 'activate-2fa'
]);

Route::post('/enable-2fa', [
    'uses' => '\App\Http\Controllers\ProfileController@enable',
    'as' => 'enable-2fa'
]);

Route::post('/disable-2fa', [
    'uses' => '\App\Http\Controllers\ProfileController@disable',
    'as' => 'disable-2fa'
]);

Route::get('/2fa/instruction', [
    'uses' => '\App\Http\Controllers\ProfileController@instruction',
]);

Route::post('/2fa', function () {
    return redirect(URL()->previous());
})->name('2fa')->middleware('2fa');

Route::group(['prefix' => '2fa'], function () {
    Route::get('/', '\App\Http\Controllers\LoginSecurityController@show2faForm');
    Route::post('/generateSecret', '\App\Http\Controllers\LoginSecurityController@generate2faSecret')->name('generate2faSecret');
    Route::post('/enable2fa', '\App\Http\Controllers\LoginSecurityController@enable2fa')->name('enable2fa');
    Route::post('/disable2fa', '\App\Http\Controllers\LoginSecurityController@disable2fa')->name('disable2fa');

    Route::post('/2faVerify', function () {
        return redirect(URL()->previous());
    })->name('2faVerify')->middleware('2fa');
});

Route::get('/test_middleware', function () {
    return "2FA middleware work!";
})->middleware(['auth', '2fa']);

Route::any('(:any)/(:all?)', function ($first, $rest = '') {
    $page = $rest ? "{$first}/{$rest}" : $first;
    dd($page);
});

Route::get('setting/{id}', [
    'as' => 'setting',
    'uses' => '\App\Http\Controllers\SettingsController@loadsetting'
])->middleware(['auth', 'xss']);

Route::post('ckeditor/upload', '\App\Http\Controllers\FormController@upload')->name('ckeditor.upload');
Route::group(
    ['middleware' => ['auth', 'xss']],
    function () {
        Route::get('change-language/{lang}', '\App\Http\Controllers\LanguageController@changeLanquage')->name('change.language');
        Route::get('manage-language/{lang}', '\App\Http\Controllers\LanguageController@manageLanguage')->name('manage.language');
        Route::post('store-language-data/{lang}', '\App\Http\Controllers\LanguageController@storeLanguageData')->name('store.language.data');
        Route::get('create-language', '\App\Http\Controllers\LanguageController@createLanguage')->name('create.language');
        Route::post('store-language', '\App\Http\Controllers\LanguageController@storeLanguage')->name('store.language');
        Route::delete('/lang/{lang}', '\App\Http\Controllers\LanguageController@destroyLang')->name('lang.destroy');
    }
);
