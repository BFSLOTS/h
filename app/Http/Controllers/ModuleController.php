<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use App\DataTables\ModuleDataTable;
use Spatie\Permission\Models\Permission;
use Auth;
use DB;

class ModuleController extends Controller
{
    public function index(ModuleDataTable $dataTable)
    {
        return $dataTable->render('module.index');
    }

    public function create()
    {
        return view('module.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|regex:/^[a-zA-Z0-9\-_\.]+$/|min:4|unique:permissions',
        ], [
            'regex' => 'Invalid Entry! Only letters,underscores,hypens and numbers are allowed',
        ]);
        $this->module =  module::create([
            'name' => str_replace(' ', '-', strtolower($request->name)),
        ]);
        $module_name  = str_replace(' ', '-', strtolower($request->name));
        if (!empty($_POST['permissions'])) {
            foreach ($_POST['permissions'] as $check) {
                if ($check == 'M') {
                    $data[] = ['name' => 'manage-' . $module_name, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                } else if ($check == 'C') {
                    $data[] = ['name' => 'create-' . $module_name, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                } else if ($check == 'E') {
                    $data[] = ['name' => 'edit-' . $module_name, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                } else if ($check == 'D') {
                    $data[] = ['name' => 'delete-' . $module_name, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                } else if ($check == 'S') {
                    $data[] = ['name' => 'show-' . $module_name, 'guard_name' => 'web', 'created_at' => new \DateTime()];
                }
            }
        }
        Permission::insert($data);
        return redirect()->route('module.index')->with('success',  __('Module Created Successfully'));
    }

    public function edit($id)
    {
        $this->module = module::findOrfail($id);
        return view('module.edit')->with('module', $this->module);
    }

    public function update(Request $request, $id)
    {
        $modules = Module::find($id);
        $this->validate($request, [
            'name' => 'required|regex:/^[a-zA-Z0-9\-_\.]+$/|min:4|unique:modules,name,' . $modules->id,
        ], [
            'regex' =>  __('Invalid Entry! Only letters,underscores,hypens and numbers are allowed'),
        ]);

        $modules->name = str_replace(' ', '-', strtolower($request->name));
        $permissions = DB::table('permissions')
            ->where('name', 'like', '%' . $request->old_name . '%')
            ->get();
        $module_name  = str_replace(' ', '-', strtolower($request->name));
        foreach ($permissions as $permission) {
            $update_permission = permission::find($permission->id);
            if ($permission->name == 'manage-' . $request->old_name) {

                $update_permission->name = 'manage-' . $module_name;
            }
            if ($permission->name == 'create-' . $request->old_name) {

                $update_permission->name = 'create-' . $module_name;
            }
            if ($permission->name == 'edit-' . $request->old_name) {

                $update_permission->name = 'edit-' . $module_name;
            }
            if ($permission->name == 'delete-' . $request->old_name) {

                $update_permission->name = 'delete-' . $module_name;
            }
            if ($permission->name == 'show-' . $request->old_name) {

                $update_permission->name = 'show-' . $module_name;
            }
            $update_permission->save();
        }
        $modules->save();
        return redirect()->route('module.index')->with('success',  __('Module Updated Sucessfully'));
    }

    public function destroy($id)
    {
        $this->module = module::find($id);
        $users = DB::table('permissions')
            ->where('name', 'like', '%' . $this->module->name . '%')
            ->get();
        foreach ($users as $user) {
            $permission = permission::find($user->id);

            $permission->delete();
        }
        $this->module->delete();
        return redirect()->route('module.index')->with('success',  __('Module Deleted Successfully'));
    }
}
