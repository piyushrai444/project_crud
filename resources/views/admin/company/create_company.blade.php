@extends('layouts.app')
@section('title'){{$title}} @endsection

@php
    $edit = isset($company)? $company :null;
    $path = $edit ? route('company.update', [$company->id]) : route('company.store');
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
  <h2>@if(Request::is('company/*/edit')) Update @else Add New @endif Company</h2>
  <form action= "{{ $path }}" method="post" enctype="multipart/form-data" class="form-horizontal form-element">
                @csrf
                
                <div class="form-group">
                    <label for="email">Name:</label>
                    <input type="text" name="name" value="{{ $edit ? $company->name : old('name') }}" class="form-control"  placeholder="Enter Name Here" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email:</label>
                    <input name="email" class="form-control" value="{{ $edit ? $company->email : old('email') }}"  placeholder="Enter Email" required="required">
                </div>
                <div class="form-group">
                    <label for="email">Website:</label>
                    <input name="website" class="form-control" value="{{ $edit ? $company->website : old('website') }}"  placeholder="Enter Website">
                </div>

                <div class="form-group">
                    <label for="email">Logo:</label>
                    <input name="company_logo" type="file" class="form-control" value="{{ $edit ? $company->logo : old('logo') }}">
                </div>

                <div class="box-footer">
                  <a type="button" style="float: right;" class="btn btn-default" href="{{route('employee.index')}}">Cancel</a>

                  <button type="submit" style="float: right;" class="btn btn-info pull-right">@if(Request::is('company/*/edit')) Update @else Create @endif Company</button>
                </div>
                <!-- /.box-footer -->
                @if($edit)
                {{ method_field('put') }}
                @endif
                </form>
        
</div>
@endsection
