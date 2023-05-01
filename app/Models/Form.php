<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;
    public $fillable = [
        'title', 'json', 'html', 'logo','success_msg','thanks_msg','email','amount','currency_symbol','currency_name','payment_status','payment_type'
    ];

    public function getFormArray()
    {
        return json_decode($this->json);
    }
    public function Roles()
    {
        return $this->belongsToMany('Spatie\Permission\Models\Role', 'user_forms', 'form_id', 'role_id');
    }
    public function assignFormRoles($role_ids)
    {
        $roles = $this->Roles->pluck('name', 'id')->toArray();
        if ($role_ids) {
            foreach ($role_ids as $id) {
                if (!array_key_exists($id, $roles)) {
                    UserForm::create(['form_id' => $this->id, 'role_id' => $id]);
                } else {
                    unset($roles[$id]);
                }
            }
        }
        if ($roles) {
            foreach ($roles as $id => $name) {
                UserForm::where(['form_id' => $this->id, 'role_id' => $id])->delete();
            }
        }
    }
}
