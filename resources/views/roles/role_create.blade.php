@extends('layouts.layout')
@section('title','Role')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Role Create</h1>
            </div><!-- /.col -->
             <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{ __('lables.home') }}</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('roles_list')}}">Role List</a></li>
                    <li class="breadcrumb-item active">Role Create</li> 
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
    <!-- /.content-header -->

<!-- Main content -->
<section class="content">
    <div class="container-fluid">      
        <div class="row">
            <!-- left column -->
            <div class="col-md-12">
                <!-- jquery validation -->
                <div class="card main-card ">
                    <!-- /.card-header -->
                    <!-- form start -->
                    <form id="circle-form" class="p-4" method="POST" action="{{route('role_store')}}">
                    @csrf
                    <div class="card-body p-0">

                        <div class="form-group mb-4">
                            <label for="validationCustom01" class="fw-600">Role Name <span class="text-red fs-14 ml-1">*</span></label>                                                                        
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="Enter role name" value="{{ old('name')}}" required autocomplete="off"/>
                            @error('name')
                                <span class="alert text-danger pl-0 pb-0 fs-14 app_slug_err mb-0 error_msg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group mb-4">
                            <div class="form-check">
                                <input type="checkbox" class="form-check-input" id="checkPermissionAll" value="1">
                                <label class="form-check-label" for="checkPermissionAll"><b>All permissions</b></label>
                            </div>
                            <hr>      
                            @php $i = 1; @endphp
                            @foreach($permission_groups as $groups)                                  
                                <div class="form-check mt-3">
                                    <input type="checkbox" class="form-check-input" id="{{ $i }}group_management_checkbox" value="{{$groups->group_name}}" onclick="checkPermissionByGroup('permission_{{ $i }}_management_checkbox',this)">
                                    <label class="form-check-label" for="{{ $i }}group_management_checkbox"><b>{{ucwords(str_replace('_', ' ', $groups->group_name))." Section"}}</b></label>        
                                </div>    
                                @php 
                                    $permissions = App\Models\User::getpermissionsByGroupName($groups->group_name);
                                @endphp  
                                <div class="row permission_{{ $i }}_management_checkbox">
                                    @foreach($permissions as $permission)
                                        <div class="col-md-3">
                                            <div class="form-check">
                                                <input type="checkbox" class="form-check-input" id="checkPermission{{ $permission->id }}" name="permissions[]" value="{{$permission->name}}">
                                                <label class="form-check-label" for="checkPermission{{ $permission->id }}">{{$permission->name}}</label>
                                            </div>
                                        </div>
                                    @endforeach                                           
                                </div>    
                                <hr> 
                                @php $i++; @endphp                     
                            @endforeach        
                        </div>
                       
           
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer bg-transparent pl-0">
                        <button type="submit" class="btn theme-btn btn-dark">{{ __('lables.submit') }}</button> 
                        <a href="{{route('roles_list')}}" class="btn theme-btn btn-gray ml-1">{{ __('lables.back') }}</a> 
                    </div>
                </form>
            </div>
                <!-- /.card -->
            </div>
            <!--/.col (left) -->
            <!-- right column -->
            <div class="col-md-6">
            </div>
            <!--/.col (right) -->
        </div>
        <!-- /.row -->
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->

@endsection

@section('script')
<!-- Custome javascript/jQuery functions -->
<script src="{{asset('assets/custome/roles.js')}}"></script>
@endsection
