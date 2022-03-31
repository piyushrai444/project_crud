@extends('layouts.app')
@section('title'){{$title}} @endsection

@php
    $edit = isset($employee)? $employee :null;
    $path = $edit ? route('employee.update', [$employee->id]) : route('employee.store');
@endphp

@section('content')
<div class="container">
@if (session('status'))
   <div class="alert alert-success" role="alert">
      {{ session('status') }}
   </div>
   @endif
   @if (session('error'))
   <div class="alert alert-denger" role="alert">
      {{ session('error') }}
   </div>
   @endif
   @if ($errors->any())
   <div class="alert alert-danger">
      <ul>
         @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
         @endforeach
      </ul>
   </div>
   @endif
  <h2>@if(Request::is('employee/*/edit')) Update @else Add New @endif Employee</h2>
  <form action= "{{ $path }}" method="post" enctype="multipart/form-data" class="form-horizontal form-element">
                @csrf
                
                <div class="form-group">
                    <label for="email">First Name:</label>
                    <input type="text" name="first_name" value="{{ $edit ? $employee->first_name : old('first_name') }}" class="form-control"  placeholder="Enter First Name Here" required>
                </div>
                <div class="form-group">
                    <label for="email">Last Name:</label>
                    <input type="text" name="last_name" value="{{ $edit ? $employee->last_name : old('last_name') }}" class="form-control"  placeholder="Enter Last Name Here" required>
                </div>
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input name="email" class="form-control" value="{{ $edit ? $employee->email : old('email') }}"  placeholder="Enter Email" required="required">
                </div>
                <div class="form-group">
                    <label for="email">Phone:</label>
                    <input name="phone" class="form-control" value="{{ $edit ? $employee->phone : old('phone') }}"  placeholder="Enter Phone">
                </div>
                        
                <div class="form-group">
                    <label for="email">Select Company:</label>
                    <select id="agent_name" class="form-control" name="company_id" data-placeholder="Select Company"
                                style="width: 100%;">
                        <option value="" disable>Select Company</option>
                        @foreach($company as $a)
                        <option value="{{$a->id}}" @if(isset($employee->company_id)){{ $employee->company_id == $a->id ? 'selected' : '' }} @endif>{{$a->name}} </option>
                        @endforeach
                        </select>
                </div>

                <div class="box-footer">
                <a type="submit" style="float: right;" href="{{route('employee.index')}}" class="btn btn-default">Cancel</a>
                    <button type="submit" style="float: right;" class="btn btn-info pull-right">@if(Request::is('employee/*/edit')) Update @else Create @endif Employee</button>
                </div>
                <!-- /.box-footer -->
                @if($edit)
                {{ method_field('put') }}
                @endif
                </form>
        
</div>


@endsection
