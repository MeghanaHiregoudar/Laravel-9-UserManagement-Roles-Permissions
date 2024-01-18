$(function () {

    var token = $('meta[name="csrf-token"]').attr('content'); 
    
    var role_permissions = ['role-edit', 'role-delete','role-view']; // Specify the required permissions
    $('#roles_list_table').DataTable({
        processing: true,
        serverSide: true,
        paging: true,
        lengthChange: false,
        searching: true,
        info: true,
        autoWidth: false,                
        responsive: true,
        dom:  "<'row'<'col-sm-12 col-md-6'B><'col-sm-12 col-md-6'f>>" +
			  "<'row'<'col-sm-12'tr>>" +
			  "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        ajax:$("#roles_list_url").val(),
        columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'name', name: 'name'},
            {data: 'permission', name: 'permission'},          
            getActionColumn(role_permissions) 
        ]
    });

    // check all permission once clicked on "checkPermissionAll" checkbox
    $("#checkPermissionAll").click(function(){
        if($(this).is(':checked')){
            // check all the checkbox
            $("input[type=checkbox]").prop('checked', true);
        } else {
            // uncheck all the checkbox
            $("input[type=checkbox]").prop('checked', false);
        }
    });

    $(document).on('click','#delete_role_btn',function(e) {
        e.preventDefault();
        var role_id = $(this).val();
        var userCount = $(this).data('usercount');
        if (userCount > 0) {
            var delete_warning = "Role assigned to users. Do you want to delete ?";
            var title = "Are you sure ?";
        } else {
            title = "";
            delete_warning = $("#are-you-sure-you-want-to-delete").val() +" ?";
        }
        
        Swal.fire({
            title: title,
            text: delete_warning,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: "Yes",
            cancelButtonText: "Cancel",
        }).then((willDelete) => {
            if (willDelete.isConfirmed) {
                $.ajax({
                    url:$("#role_delete_url").val(),
                    method:"POST",
                    data : {
                        role_id:role_id,
                        _token:token
                    },    
                    dataType:'json',            
                    success:function(response){
                        if(response.status == 0) {
                            toastr.error(response.msg);
                        } else {
                            toastr.success(response.msg);
                            $('#roles_list_table').DataTable().ajax.reload();
                        }
                        
                    }
                });
            }
        });	
    });

}); //end

// check all the permission checkbox of particular group
function checkPermissionByGroup(className,checkThisId)
{
    const group_checkbox_id =  $("#"+checkThisId.id);  
    const permissionCheckbox = $('.'+className+' input');
    if(group_checkbox_id.is(':checked')){
        // if checked, add checked all checkboxes of that group
        permissionCheckbox.prop('checked', true);
    } else {
        // if group checkbox is unchecked
        permissionCheckbox.prop('checked', false);
    }  

    implementAllChecked(); 
}

// To check weather all permissions are checked of particular group
function checkSinglePermission(groupClassName, groupCheckboxID, countTotalPermission)
{
    const permissionClassCheckbox = $('.'+groupClassName+ ' input');
    const groupIDCheckBox = $("#"+groupCheckboxID);

    if($('.'+groupClassName+ ' input:checked').length == countTotalPermission){
    // if all checkboxes of that group is checked
        groupIDCheckBox.prop('checked', true);
    } else {
        // if group checkbox is unchecked
        groupIDCheckBox.prop('checked', false);
    }

    implementAllChecked();
}

// if all checkbos are checked then All Permissions checkbox should be checked
function implementAllChecked() {
    const countPermissions = $("#all_permissions").val();   
    const countPermissionGroups = $("#permission_groups").val(); 
    // console.log(parseInt(countPermissions) + parseInt(countPermissionGroups));
    
    if($('.checkbox_count:checked').length >= (parseInt(countPermissions) + parseInt(countPermissionGroups))){
        $("#checkPermissionAll").prop('checked', true);
    }else{
        $("#checkPermissionAll").prop('checked', false);
    }    
}   