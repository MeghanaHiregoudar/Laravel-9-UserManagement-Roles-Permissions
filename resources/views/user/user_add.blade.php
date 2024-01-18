@extends('layouts.layout')
@section('title',__('titles.user'))
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('lables.user-create') }}</h1>
            </div><!-- /.col -->
             <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{ __('lables.home') }}</a></li>
                    <li class="breadcrumb-item active"><a href="{{route('user')}}">{{ __('lables.user-list') }}</a></li>
                    <li class="breadcrumb-item active">{{__('lables.user-create')}}</li> 
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
                    <form id="circle-form" class="p-4" method="POST" action="{{route('user_store')}}">
                    @csrf
                    <div class="card-body p-0">

                        <div class="form-group mb-4">
                            <label for="exampleInputEmail1">{{ __('lables.name') }}<span class="text-red fs-14 ml-1">*</span> </label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" id="name" placeholder="{{ __('placeholders.enter-name') }}" value="{{ old('name')}}">
                            @error('name')
                                <span class="alert text-danger pl-0 pb-0 fs-14 app_slug_err mb-0 error_msg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        
                        <div class="form-group">
                            <label for="exampleInputPassword1">{{ __('lables.email-id') }}<span class="text-red fs-14 ml-1">*</span> </label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="{{ __('placeholders.enter-email') }}" value="{{ old('email')}}">
                            @error('email')
                                <span class="alert text-danger pl-0 pb-0 fs-14 app_slug_err mb-0 error_msg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group mb-4">
                            <label for="exampleInputEmail1">Mobile Number<span class="text-red fs-14 ml-1">*</span> </label>
                            <input type="text" name="mobile_no" class="form-control @error('mobile_no') is-invalid @enderror only_number" id="mobile_no" placeholder="Enter mobile number" value="{{ old('mobile_no')}}"  maxlength="10">
                            @error('mobile_no')
                                <span class="alert text-danger pl-0 pb-0 fs-14 app_slug_err mb-0 error_msg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>


                        <div class="form-group mb-4">
                            <label for="exampleInputEmail1">Username<span class="text-red fs-14 ml-1">*</span> </label>
                            <input type="text" name="user_name" class="form-control @error('name') is-invalid @enderror alphabets_numbers_underscore" id="user_name" placeholder="Enter username" value="{{ old('user_name')}}">
                            @error('user_name')
                                <span class="alert text-danger pl-0 pb-0 fs-14 app_slug_err mb-0 error_msg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputPassword1">{{ __('lables.password') }}<span class="text-red fs-14 ml-1">*</span> </label>
                            <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" id="password" placeholder="{{ __('placeholders.enter-password') }}">
                            <button type="button" class="btn p-0 border-0 shadow-none" style="position: relative;left: 97%;top: -35px;"><i class="fa fa-eye togglePasswordEye float-right" data-key="password"></i></button>
                            @error('password')
                                <span class="alert text-danger pl-0 pb-0 fs-14 app_slug_err mb-0 error_msg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">{{ __('lables.confirm-password') }}<span class="text-red fs-14 ml-1">*</span> </label>
                            <input type="password" name="password_confirmation" id="password_confirmation" class="form-control @error('password_confirmation') is-invalid @enderror" placeholder="{{ __('placeholders.enter-confirm-password') }}">
                            <button type="button" class="btn p-0 border-0 shadow-none" style="position: relative;left: 97%;top: -35px;"><i class="fa fa-eye togglePasswordEye float-right" data-key="password_confirmation"></i></button>
                            @error('password_confirmation')
                                <span class="alert text-danger pl-0 pb-0 fs-14 app_slug_err mb-0 error_msg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">{{ __('lables.role') }}<span class="text-red fs-14 ml-1">*</span> </label>
                            <select name="roles" id="roles" class="js-states form-control @error('master_ce_id') is-invalid @enderror"  data-placeholder="select role" data-dropdown-css-class="select2-green" style="width: 100%;" required>
                            <option value="">Select role</option>
                                @foreach ($roles as $role)
                                        <option value="{{$role->id}}" {{ ($role->id == old('roles')) ? 'selected' : '' }}>{{ $role->name }}</option>
                                @endforeach
                            </select>
                            @error('roles')
                                <span class="alert text-danger pl-0 pb-0 fs-14 app_slug_err mb-0 error_msg" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div> 
          
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer bg-transparent pl-0">
                        <button type="submit" class="btn theme-btn btn-dark">{{ __('lables.submit') }}</button> 
                        <a href="{{route('user')}}" class="btn theme-btn btn-gray ml-1">{{ __('lables.back') }}</a> 
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
<script type="text/javascript">
   
</script>
@endsection