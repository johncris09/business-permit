
$(document).ready(function() {
  
  $('form input').keyup(function(){
    $(this).val($(this).val().toUpperCase());
  });


  var alert_class = "";
  var table = $('#business-permit-table').DataTable({
    "scrollY": 450,
    "scrollX": true,
    deferRender: true,
    ajax: {
      url: BASE_URL + 'business_permit/get_all_business_permit',
      type: 'POST',
    },
    columns: [{
      data: 'id',
        render: function(data, type, row, meta) {
          return meta.row + meta.settings._iDisplayStart + 1;
        }
      }, 
      { data: 'sp_no'  }, 
      { data: 'classification'  }, 
      { data: 'business' }, 
      { data: 'owner' }, 
      { data: 'address' },   
      {
        data: 'id',
        render: function(data, type, row, meta) { 
          return '\
            <button type="button" class="btn btn-sm btn-icon btn-warning" data-business-permit-id="'+row.id+'" id="edit-business-permit-btn" ><i class="fa fa-pencil-alt"></i> <span class="sr-only">Edit</span></button>\
            <button type="button" class="btn btn-sm btn-icon btn-danger" data-business-permit-id="'+row.id+'" id="delete-business-permit-btn"><i class="fa fa-trash-alt"></i> <span class="sr-only">Delete</span></button>\
            <button type="button" class="btn btn-sm btn-icon btn-primary" data-business-permit-id="'+row.id+'" id="print-business-permit-btn"><i class="fa fa-print"></i> <span class="sr-only">Print</span></button>\
          '
        }
      }, 

    ], 
      
  });
  var buttons = new $.fn.dataTable.Buttons(table, {
    buttons: [{
      extend: 'excel',
      text: '<i class="fas fa-file-excel"></i>',
    }, {
      extend: 'print',
      text: '<i class="fas fa-print"></i>',
      autoPrint: false,
    }, {
      extend: 'colvis',
      collectionLayout: 'fixed columns',
      collectionTitle: 'Column visibility control'
    }],
  }).container().appendTo($('#buttons'));
  $('.dt-button').removeClass("dt-button");
  $('.dt-buttons>   button').addClass("btn btn-primary");
  
  $('.toggle-password').on('click', function(){
    var input = $('input[name="password"]');
    if (input.attr("type") === "password") {
      input.attr("type", "text");
      $('button.toggle-password').html(' <i class="fa fa-eye-slash"></i> Hide')
    } else {
      input.attr("type", "password");
      $('button.toggle-password').html(' <i class="fa fa-eye"></i> Show')
    }
  })
   
  

  $('#create-new-business-permit-form').on('submit', function(e){
    e.preventDefault();

    $.ajax({
      url: BASE_URL + "business_permit/insert",
      method: "POST",
      data: $("#create-new-business-permit-form").serialize(),
      dataType: "json",
      success: function (data) {

        if(!data.response){ 
            Swal.fire({
                title: data.message,
                icon: "error",
                showCancelButton: true, 
            })
        }else{ 
            Swal.fire({
                title: data.message,
                icon: "success",
                showCancelButton: true, 
            }).then(function(result) {
                $("#create-new-business-permit-form")[0].reset()
                $('select[name="classification"]').focus()

                // get the latest sp no
                $.ajax({
                  url: BASE_URL + "business_permit/get_latest_sp_no",
                  method: "post",
                  dataType: "json",
                  success: function (data) {  
                    console.info(data) 
                    $('#sp_no').html(data)
                    $('input[name="sp_no"]').val(data)
                  }, 
                });


                table.ajax.reload();
                
            });
        }  
      },
      error: function (xhr, status, error) {
          console.info(xhr.responseText);
      }
    });
  })
  
  $(document).on('click','#edit-business-permit-btn', function(){ 
    
    // show modal
    $('#edit-business-permit-modal').modal('show')

    var business_permit_id = $(this).data('businessPermitId') 


    $.ajax({
      url: BASE_URL + "business_permit/get_business_permit/" + business_permit_id,
      method: "POST",
      dataType: "json",
      success: function (data) {  
        $('#update-business-permit-form input[name="id"]').val(data.id)  
        $('#update-business-permit-form select[name="classification"]').val(data.classification) 
        $('#update-business-permit-form input[name="business"]').val(data.business)
        $('#update-business-permit-form input[name="owner"]').val(data.owner) 
        $('#update-business-permit-form select[name="address"]').val(data.address) 
      },
      error: function (xhr, status, error) {
          console.info(xhr.responseText);
      }
    });
  })
   
  
  $('#update-business-permit-form').on('submit', function(e){
    e.preventDefault();

    
    var business_permit_id = $('input[name="id"]').val(); 

    $.ajax({
      url: BASE_URL + "business_permit/update/" + business_permit_id,
      method: "POST",
      data: $("#update-business-permit-form").serialize(),
      dataType: "json",
      success: function (data) {  
        if(!data.response){ 
            Swal.fire({
                title: data.message,
                icon: "error",
                showCancelButton: true, 
            })
        }else{ 
            Swal.fire({
                title: data.message,
                icon: "success",
                showCancelButton: true, 
            }).then(function(result) {
                table.ajax.reload(); 
      
                $('#edit-business-permit-modal').modal('toggle');
            });
        }  
      },
      error: function (xhr, status, error) {
          console.info(xhr.responseText);
      }
    });
  })
  

  // Delete  
  $(document).on('click','#delete-business-permit-btn', function(e){
    e.preventDefault();
    var business_permit_id = $(this).data('businessPermitId') 

    Swal.fire({
        title: "Are you sure?",
        text: "You won\"t be able to revert this!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Yes, delete it!"
    }).then(function(result) {
        if (result.value) { 
          $.ajax({
            url: BASE_URL + "business_permit/delete/" + business_permit_id,
            method: "post",
            dataType: "json",
            success: function (data) {  
              if(!data.response){ 
                Swal.fire({
                  title: data.message,
                  icon: "error",
                  showCancelButton: true, 
                })
              }else{ 
                Swal.fire({
                  title: 'Deleted!',
                  text: "Your file has been deleted.",
                  icon: "success",
                  showCancelButton: true, 
                  confirmButtonText: "Ok"
                })
                table.ajax.reload()
              }  
            },
            error: function (xhr, status, error) { 
                console.info(xhr.responseText);
            }
        });

            
        }
    }); 
  })



  $(document).on('click','#print-business-permit-btn', function(){ 
     

    var business_permit_id = $(this).data('businessPermitId')  

    window.open(BASE_URL + "business_permit/view/" + business_permit_id , "_blank", "toolbar=yes,scrollbars=yes,resizable=yes,top=150,left=300,width=600,height=505");

 
  })
   
  
    
});  