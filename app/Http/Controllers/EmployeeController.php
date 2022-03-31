<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Company;
use App\Http\Requests\Employee\CreateEmployeeRequest;
use App\Http\Requests\Employee\UpdateEmployeeRequest;
use App\Repositories\Employee\EmployeeRepository;
use DB;

class EmployeeController extends Controller
{
    public function __construct(EmployeeRepository $EmployeeRepository)
    {
        $this->EmployeeRepository = $EmployeeRepository;
    }


    public function index(){
        $employee = Employee::orderBy('updated_at','DESC')->paginate(10);
        return view('admin.employee.index', [
            'title' => 'All Employees',
            'employee'=>$employee,
        ]);
    }

    public function create()
    {
        try{
            $company = Company::all();
            return view('admin.employee.create_employee', [
                'title' => 'Create New Employee',
                'company'=> $company,
            ]);
        }catch(\Exception $e) {
            return redirect()->back()->with('error', 'error:'.$e->getMessage());   
        }
    }

    public function store(CreateEmployeeRequest $request)
    {
        DB::beginTransaction();
        try{
            $response = $this->EmployeeRepository->store($request);
            DB::commit();
            return redirect()->route('employee.index')->with('status', 'Employee Created');
        }catch(\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'error:'.$e->getMessage());   
        }
    }

    public function edit($id)
    {
        try{
            $company = Company::all();
            $employee = Employee::find($id);
            return view('admin.employee.create_employee', [
                'title' => 'Edit Employee',
                'employee' => $employee,
                'company'=> $company,
            ]);
        }catch(\Exception $e) {
            return redirect()->back()->with('error', 'error:'.$e->getMessage());   
        }
    }

    public function update(UpdateEmployeeRequest $request, $id)
    {
        try{
            $response = $this->EmployeeRepository->update($request, $id);
            return redirect()->route('employee.index')->with('status', 'Employee Updated');
        }catch(\Exception $e) {
            return redirect()->back()->with('error', 'error:'.$e->getMessage());   
        }
    }

    public function destroy(Request $request)
    {   
        try{
            $Employee = Employee::find($request->id);
            $Employee->delete();
            return redirect()->route('employee.index')->with('status', 'Employee Deleted');
        }catch(\Exception $e) {
            return redirect()->back()->with('error', 'error:'.$e->getMessage());   
        }
    }
}
