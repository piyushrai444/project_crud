@extends('layouts.app')

@section('content')

<div class="container">
  <h2>Employees Table</h2>
  <a type="button" style="float: right;" class="btn btn-warning" href="{{ route('employee.create') }}">Create Employee</a>
           
  <table class="table">
    <thead>
      <tr>
        <th>Company</th>
        <th>Firstname</th>
        <th>Lastname</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    @foreach($employee as $c)
        <tr>
            <td>{{isset($c->company->name) ?  $c->company->name : "N/A"}}</td>
            <td>{{$c->first_name}}</td>
            <td>{{$c->last_name}}</td>
            <td>{{$c->email}}</td>
            <td>{{$c->phone}}</td>
            <td>
                <div class="dropdown">
                    <button class="btn btn-outline btn-secondary dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Action</button>
                    <div class="dropdown-menu" x-placement="bottom-start" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(0px, 44px, 0px);">
                        <a class="dropdown-item" href="{{ route('employee.edit', $c->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>
                        <form method="post" action="{{ route('employee.destroy', $c->id) }}">
                            <input name="_method" type="hidden" value="DELETE">
                            <input name="id" type="hidden" value="{{$c->id}}">
                            @csrf
                            <button class="dropdown-item" onclick="return confirm('Are you sure you want to delete?');" type="submit"><i class="fa fa-trash-o"></i>Delete</button>
                        </form>
                    </div>
                </div>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
  {{ $employee->appends(request()->except('page'))->links() }}
</div>
@endsection
