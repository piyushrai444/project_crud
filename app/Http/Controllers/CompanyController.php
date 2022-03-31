<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Http\Requests\Company\CreateCompanyRequest;
use App\Http\Requests\Company\UpdateCompanyRequest;
use App\Repositories\Company\CompanyRepository;
use DB;

class CompanyController extends Controller
{
    public function __construct(CompanyRepository $CompanyRepository)
    {
        $this->CompanyRepository = $CompanyRepository;
    }


    public function index(){
        $company = Company::orderBy('updated_at','DESC')->paginate(10);
        return view('admin.company.index', [
            'title' => 'All Companies',
            'company'=>$company,
        ]);
    }

    public function create()
    {
        try{
            return view('admin.company.create_company', [
                'title' => 'Create New Company',
            ]);
        }catch(\Exception $e) {
            return redirect()->back()->with('error', 'error:'.$e->getMessage());   
        }
    }

    public function store(CreateCompanyRequest $request)
    {
        DB::beginTransaction();
        try{
            $response = $this->CompanyRepository->store($request);
            DB::commit();
            return redirect()->route('company.index')->with('status', 'Company Created');
        }catch(\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'error:'.$e->getMessage());   
        }
    }

    public function edit($id)
    {
        try{
            $company = Company::find($id);
            return view('admin.company.create_company', [
                'title' => 'Edit Company',
                'company' => $company,
            ]);
        }catch(\Exception $e) {
            return redirect()->back()->with('error', 'error:'.$e->getMessage());   
        }
    }

    public function update(UpdateCompanyRequest $request, $id)
    {
        try{
            $response = $this->CompanyRepository->update($request, $id);
            return redirect()->route('company.index')->with('status', 'Company Updated');
        }catch(\Exception $e) {
            return redirect()->back()->with('error', 'error:'.$e->getMessage());   
        }
    }

    public function destroy(Request $request)
    {   
        try{
            $company = Company::find($request->id);
            $company->delete();
            return redirect()->route('company.index')->with('status', 'Company Deleted');
        }catch(\Exception $e) {
            return redirect()->back()->with('error', 'error:'.$e->getMessage());   
        }
    }
}
