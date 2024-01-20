@extends('layouts.layout')
@section('title','Role')
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Role list</h1>
            </div><!-- /.col -->
             <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{ __('lables.home') }}</a></li>
                    <li class="breadcrumb-item active">Role list</li> 
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
    <!-- /.content-header -->

<!-- Main content -->
<section class="content position-relative">
    <div class="container-fluid">
        @if(auth()->user()->can('role-create'))
        <div class="bottom_btn_set">
            <a href="{{route('role_create')}}" class="text-white"> <button type="button" class="btn btn-dark plus_btn float-right rounded-lawyer" data-toggle="modal" data-target="#create_app"><i class="fas fa-plus"></i></button></a>
        </div>
        @endif
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card border-none bg-transparent box-showd-none">
                    <!-- /.card-header -->                  
                    <div class="card-body">    
                        <input type="hidden" value="{{route('roles_list_data')}}" id="roles_list_url">  
                        <input type="hidden" value="{{route('role_delete')}}" id="role_delete_url">
                        <table id="roles_list_table" class="table table-bordered table-striped bg-white">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="15%">Role-name</th>
                                    <th width="60%">Permissions</th>     
                                    <th width="10%">Action</th>   
                                </tr>
                            </thead>
                            <tbody>
                                
                            </tbody>
                        </table>
                    </div>
                    <!-- /.card-body -->
                </div>

            </div>
        </div>
    </div><!-- /.container-fluid -->
    <input type="hidden" id="are-you-sure-you-want-to-delete" value="{{__('lables.are-you-sure-you-want-to-delete')}}">
</section>
<!-- /.content -->

@endsection

@section('script')
<!-- Custome javascript/jQuery functions -->
<script src="{{asset('assets/custome/roles.js')}}"></script>
@endsection
