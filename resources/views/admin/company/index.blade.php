@extends('layouts.app')

@section('content')

<div class="container">
  <h2>Companies Table</h2>
  <a type="button" style="float: right;" class="btn btn-warning" href="{{ route('company.create') }}">Create Company</a>
           
  <table class="table">
    <thead>
      <tr>
        <th>Company</th>
        <th>Email</th>
        <th>Website</th>
        <th>Logo</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
    @foreach($company as $c)
        <tr>
            <td>{{$c->name}}</td>
            <td>{{$c->email}}</td>
            <td>{{$c->website}}</td>
            <td><img style="hight: 60px;width: 100px;height: 100px;" src="{{isset($c->logo) ? asset('storage/' . $c->logo) :  asset('150x100.png') }}" alt="image"></td>
            <td>
              <div class="btn-group">
                <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown">Action</button>
                <ul class="dropdown-menu">
                  <a class="dropdown-item" href="{{ route('company.edit', $c->id) }}"><i class="fa fa-pencil" aria-hidden="true"></i>Edit</a>

                  <form method="post" action="{{ route('company.destroy', $c->id) }}">
                      <input name="_method" type="hidden" value="DELETE">
                      <input name="id" type="hidden" value="{{$c->id}}">
                      @csrf
                      <button class="dropdown-item" onclick="return confirm('Are you sure you want to delete?');" type="submit"><i class="fa fa-trash-o"></i>Delete</button>
                  </form>
                </ul>
              </div>
            </td>
        </tr>
        @endforeach
    </tbody>
  </table>
  {{ $company->appends(request()->except('page'))->links() }}
</div>
@endsection
