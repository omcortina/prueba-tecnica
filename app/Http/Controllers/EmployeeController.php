<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\EmployeeRol;
use App\Models\Rol;
use App\Models\Area;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    public function list()
    {
        $list = Employee::all();
        return view('employee.list', compact('list'));
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        
        $roles = Rol::all();
        $areas = Area::all();
        $data = $request->all();
        $message = "";
        $save_all = false;
        try {
            if($data){
                $model = new Employee;
                $model->fill($data);
                $data['sexo'] == 1 ? $model->sexo = "M" : $model->sexo = "F";
                if(isset($data['boletin'])){
                    $model->boletin = 1;
                }else{
                    $model->boletin = 0;
                }

                $save = $model->save();
                if($save){
                    foreach ($data['roles'] as $item) {
                        $employee_rol = new EmployeeRol;
                        $employee_rol->empleado_id = $model->id;
                        $employee_rol->rol_id = $item;
                        $save_employee_rol = $employee_rol->save();
                        if($save_employee_rol){
                            $save_all = true;
                        }else{
                            DB::rollback();
                            break;
                        }
                    }

                    if($save_all){
                        DB::commit();
                        $message = "Empleado guardado correctamente";
                        session()->flash('message_success_employee_create', $message);
                    }
                    return redirect("/");
                }else{
                    DB::rollback();
                }
            }
        } catch (\Throwable $th) {
            DB::rollback();
        }
        return view('employee.create', compact(['roles', 'areas']));
    }

    public function edit(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $roles = Rol::all();
            $areas = Area::all();
            $data = $request->all();
            $message = "";
            $update_all = false;
            $employee = Employee::find($id);
            if($data){
                DB::table('empleado_rol')->where('empleado_id', $employee->id)->delete();
                $employee->fill($data);
                $data['sexo'] == 1 ? $employee->sexo = "M" : $employee->sexo = "F";
                if(isset($data['boletin'])){
                    $employee->boletin = 1;
                }else{
                    $employee->boletin = 0;
                }

                $update = $employee->update();
                if($update){
                    foreach ($data['roles'] as $item) {
                        $employee_rol = new EmployeeRol;
                        $employee_rol->empleado_id = $employee->id;
                        $employee_rol->rol_id = $item;
                        $save_employee_rol = $employee_rol->save();
                        if($save_employee_rol){
                            $update_all = true;
                        }else{
                            DB::rollback();
                            break;
                        }
                    }

                    if($update_all){
                        DB::commit();
                        $message = "Empleado actualizado correctamente";
                        session()->flash('message_success_employee_edit', $message);
                    }
                    return redirect("/");
                }else{
                    DB::rollback();
                }
            }
        } catch (\Throwable $th) {
            DB::rollback();
        }
        return view('employee.edit', compact(['roles', 'areas', 'employee']));
    }

    public function delete($id)
    {
        $employee = Employee::find($id);
        $message = "Ocurrió un error";
        $error = true;
        if($employee){
            DB::table('empleado_rol')->where('empleado_id', $employee->id)->delete();
            $delete = $employee->delete();
            if($delete) {
                $message = "Empleado eliminado correctamente";
                $error = false;
            }
        }else{
            $message = "Este empleado no existe";
        }

        return response()->json([
            "message" => $message
        ]);
    }
}
