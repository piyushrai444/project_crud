<?php

namespace App\Repositories\Company;

use Illuminate\Support\Str;
use App\Repositories\BaseRepository;
use App\Models\Company;
use Illuminate\Support\Facades\Auth;


class CompanyRepository extends BaseRepository
{
  public function store($request)
  {
    try {
      if ($request->hasfile('company_logo')) :
        // dd(config('filesystems.public_storage'));
        $fileName = time().'.'.$request->company_logo->getClientOriginalName();  
        
        $path = $request->file('company_logo')->storeAs('public',$fileName);
        // \Storage::disk('public')->putFile('company_logo',$fileName);
        $request->request->add(['logo' => $fileName]);
      endif;
      Company::insert($request->except('_token','company_logo'));
    } catch (\Throwable $th) {
      dd($th);
    }
    return true;
  }

  public function update($request, $id)
  {
    try {
      if ($request->hasfile('company_logo')) :
        $request->request->add(['logo' => $this->handleSingleFileUpload($request->company_logo, config('filesystems.public_storage'))]);
      endif;
        Company::find($id)->update($request->except('_method', '_token','company_logo'));
    } catch (\Throwable $th) {
      dd($th);
    }
    return true;
  }

  

}
