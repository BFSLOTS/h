<?php

namespace App\Facades;

use App\Models\Form;
use App\Models\Order;
use App\Models\RequestUser;
use App\Models\settings;
use Carbon\Carbon;
use App\Mail\ApproveMail;
use App\Models\FormValue;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class Utility
{

    public function settings()
    {
        $data = DB::table('settings');
        $data = $data->get();

        $settings = [
            "date_format" => "M j, Y",
            "time_format" => "g:i A",
        ];

        foreach ($data as $row) {
            $settings[$row->key] = $row->value;
        }

        return $settings;
    }

    public function date_format($date)
    {
        return Carbon::parse($date)->format($this->getsettings('date_format'));
    }
    public function time_format($time)
    {
        return Carbon::parse($time)->format($this->getsettings('time_format'));
    }
    public function date_time_format($date)
    {
        return Carbon::parse($date)->format($this->getsettings('date_format') . ' ' . $this->getsettings('time_format'));
    }

    public function setEnvironmentValue(array $values)
    {
        $envFile = app()->environmentFilePath();
        $str     = file_get_contents($envFile);
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $keyPosition       = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine           = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);
                // If key does not exist, add it
                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}='{$envValue}'\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}='{$envValue}'", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        $str .= "\n";
        if (!file_put_contents($envFile, $str)) {
            return false;
        }

        return true;
    }

    public function keysettings($key = '', $form_user_id = '')
    {
        $val = '';
        $created_by = '';
        if ($form_user_id) {
            $created_by = $form_user_id;
        }
        $setting = settings::select('value')->where('created_by', $created_by);

        $set =  $setting->where('key', $key)->first();

        $val = '';
        if (!empty($set->value)) {
            $val = $set->value;
        }
        return $val;
    }

    public function getValByName($key)
    {
        $setting = $this->settings();
        if (!isset($setting[$key]) || empty($setting[$key])) {
            $setting[$key] = '';
        }

        return $setting[$key];
    }

    public function languages()
    {
        $dir     = base_path() . '/resources/lang/';
        $glob    = glob($dir . "*", GLOB_ONLYDIR);
        $arrLang = array_map(
            function ($value) use ($dir) {
                return str_replace($dir, '', $value);
            },
            $glob
        );
        $arrLang = array_map(
            function ($value) use ($dir) {
                return preg_replace('/[0-9]+/', '', $value);
            },
            $arrLang
        );
        $arrLang = array_filter($arrLang);

        return $arrLang;
    }

    public static function delete_directory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (!self::delete_directory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        return rmdir($dir);
    }



    public function getsettings($value = '')
    {
        $val = '';

        $setting = settings::select('value');
        $set =  $setting->where('key', $value)->first();
        $val = '';
        if (!empty($set->value)) {
            $val = $set->value;
        }

        return $val;
    }



    public function dataChart($form_id)
    {

        $chartArray = [];
        $form_values = FormValue::select('forms.json as form_json', 'form_values.*')->where('form_id', $form_id)->join('forms', 'forms.id', '=', 'form_values.form_id');
        $form_values = $form_values->get();
        foreach ($form_values as $form_value) {

            $array1 = json_decode($form_value->form_json);
            foreach ($array1 as $rows1) {
                foreach ($rows1 as $row_key1 => $row1) {
                    if (isset($row1->is_enable_chart) && $row1->is_enable_chart) {

                        if (!isset($chartArray[$row1->name])) {
                            $options = [];
                            if ($row1->type == 'radio-group' || $row1->type == 'select' || $row1->type == 'checkbox-group') {
                                foreach ($row1->values as $value) {
                                    $options[$value->label] = 0;
                                }
                                if (isset($row1->value)) {
                                    $options['other'] = 0;
                                }
                            } elseif ($row1->type == 'starRating') {
                                $options = [
                                    '0' => 0, '0.5' => 0, '1' => 0, '1.5' => 0, '2' => 0, '2.5' => 0, '3' => 0, '3.5' => 0, '4' => 0, '4.5' => 0, '5' => 0,
                                ];
                            } elseif ($row1->type == 'date' || $row1->type == 'number') {
                                $options = [];
                            }
                            $tmp = [
                                'label' => $row1->label,
                                'options' => $options,
                                'chart_type' => $row1->chart_type
                            ];

                            $chartArray[$row1->name] = $tmp;
                        }
                    }
                }
            }

            $array = json_decode($form_value->json);
            foreach ($array as $rows) {
                foreach ($rows as $row_key => $row) {
                    if ($row->type == 'radio-group' || $row->type == 'select' || $row->type == 'checkbox-group'   || $row->type == 'starRating' || $row->type == 'date' || $row->type == 'number') {
                        if (!isset($chartArray[$row->name])) {
                            $options = [];
                            if ($row->type == 'radio-group' || $row->type == 'select' || $row->type == 'checkbox-group') {
                                foreach ($row->values as $value) {
                                    $options[$value->label] = 0;
                                }
                                if (isset($row->value)) {
                                    $options['other'] = 0;
                                }
                            } elseif ($row->type == 'starRating') {
                                $options = [
                                    '0' => 0, '0.5' => 0, '1' => 0, '1.5' => 0, '2' => 0, '2.5' => 0, '3' => 0, '3.5' => 0, '4' => 0, '4.5' => 0, '5' => 0,
                                ];
                            } elseif ($row->type == 'date' || $row->type == 'number') {
                                $options = [];
                            }
                            $tmp = [
                                'label' => $row->label,
                                'options' => $options,
                                'chart_type' => $chartArray
                            ];

                            $chartArray[$row->name] = $tmp;
                        }
                        if ($row->type == 'radio-group' || $row->type == 'select' || $row->type == 'checkbox-group') {

                            foreach ($row->values as $value) {
                                if (isset($value->selected)) {
                                    $chartArray[$row->name]['options'][$value->label]++;
                                }
                            }
                            if (isset($row->value)) {
                                if (!isset($chartArray[$row->name]['options']['other'])) {
                                    $chartArray[$row->name]['options']['other'] = 0;
                                }
                                $chartArray[$row->name]['options']['other']++;
                            }
                        }
                        if ($row->type == 'starRating') {
                            $chartArray[$row->name]['options'][$row->value]++;
                        }

                        if ($row->type == 'date' ||  $row->type == 'number') {
                            if (!isset($chartArray[$row->name]['options'][$row->value])) {
                                $chartArray[$row->name]['options'][$row->value] = 0;
                            }
                            $chartArray[$row->name]['options'][$row->value]++;
                        }
                    }
                }
            }
        }


        return $chartArray;
    }
}
