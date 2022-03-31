<?php

namespace App\Repositories\Employee;

use Illuminate\Support\Str;
use App\Repositories\BaseRepository;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;


class EmployeeRepository extends BaseRepository
{
  public function store($request)
  {
    try {
      Employee::insert($request->except('_token'));
    } catch (\Throwable $th) {
      dd($th);
    }
    return true;
  }

  public function update($request, $id)
  {
    try {
      Employee::find($id)->update($request->except('_method', '_token'));
    } catch (\Throwable $th) {
      dd($th);
    }
    return true;
  }

  

}
