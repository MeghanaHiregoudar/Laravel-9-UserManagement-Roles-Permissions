@extends('layouts.layout')
@section('title',__('titles.user'))
@section('content')

<!-- Content Header (Page header) -->
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">{{ __('lables.user-list') }}</h1>
            </div><!-- /.col -->
             <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{ __('lables.home') }}</a></li>
                    <li class="breadcrumb-item active">{{ __('lables.user-list') }}</li> 
                </ol>
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.container-fluid -->
</div>
    <!-- /.content-header -->

<!-- Main content -->
<section class="content position-relative">
    <div class="container-fluid">
        @if(auth()->user()->can('user-create'))
        <div class="bottom_btn_set">
            <a href="{{route('user_create')}}" class="text-white"> <button type="button" class="btn btn-dark plus_btn float-right rounded-lawyer" data-toggle="modal" data-target="#create_app"><i class="fas fa-plus"></i></button></a>
        </div>
        @endif
        <div class="row">
            <div class="col-lg-12 col-md-12">
                <div class="card border-none bg-transparent box-showd-none">
                    <!-- /.card-header -->                  
                    <div class="card-body">    
                        <table id="user_list_table" class="table table-bordered table-striped bg-white">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ __('lables.name') }}</th>                                    
                                    <th>{{ __('lables.email-id') }}</th>
                                    <th>Username</th>
                                    <th>{{ __('lables.role') }}</th>                                    
                                    <th>{{ __('lables.status') }}</th>
                                    <th>{{ __('lables.action') }}</th>
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
</section>
<!-- /.content -->

@endsection

@section('script')
<!-- Custome javascript/jQuery functions -->
<script type="text/javascript">
   $(function () {
    var token = $('meta[name="csrf-token"]').attr('content'); 
        $('#user_management').css("background-color", "#14808233");
        $('#user_list_table').DataTable({
            processing: true,
            serverSide: true,
            paging: true,
            lengthChange: false,
            searching: true,
            info: true,
            autoWidth: false,                
            responsive: true,
            // dom: "Bfrtip",
            dom:  "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
                "<'row'<'col-sm-12'tr>>" +
                "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
            "order": [[ 0, "asc" ]],
            ajax: "{{ route('user_list') }}",
            // "buttons": ["copy", "csv", "excel", "pdf", "print"],
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'name', name: 'name',searchable: true}, 
                {data: 'email', name: 'email'},
                {data: 'user_name', name: 'user_name'},
                {data: 'role', name: 'role'},
                {data: 'status', name: 'status'},
                @if(Auth::user()->hasAnyPermission(['user-edit','user-status','user-delete']))
                    {data: 'action', name: 'action', orderable: false, searchable: false},
                @endif
            ]
        });

        
        $(document).on('click','.delete_user_btn',function(){
            var id = $(this).val();
            // var token = $('meta[name="csrf-token"]').attr('content'); 
            Swal.fire({
                title: "{{__('lables.are-you-sure-you-want-to-delete')}}?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: "{{__('lables.yes')}}",
                cancelButtonText : "{{__('lables.cancel')}}",
            }).then((willDelete) => {
                if (willDelete.isConfirmed) { 
                    $.ajax({
                        url:"{{route('user_delete')}}",
                        method:"POST",
                        data : {
                            id:id,
                            _token:token
                        },      
                        dataType:'json',           
                        success:function(response){
                            if(response.status == 0) {
                                toastr.error(response.msg);
                            } else {
                                toastr.success(response.msg);
                                $('#user_list_table').DataTable().ajax.reload();
                            }
                        }
                    });
                }
            });            
        });

      
        
    });
</script>
@endsection