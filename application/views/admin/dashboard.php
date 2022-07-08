
<!DOCTYPE html>
<html lang="en">
  <head> 
    <?php $this->view('layout/meta') ?>
	  <?php $this->view('layout/css') ?>  
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/datatable/css/buttons.dataTables.min.css">
     
  </head>
  <body>
    <!-- .app -->
    <div class="app has-fullwidth">
      <!--[if lt IE 10]>
      <div class="page-message" role="alert">You are using an <strong>outdated</strong> browser. Please <a class="alert-link" href="http://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</div>
      <![endif]-->
      <!-- .app-header -->
      <!-- .app-header -->
      <header class="app-header app-header-dark">
        <!-- .navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary py-lg-0">
          <!-- .container -->
          <div class="container">
            <!-- .navbar-brand -->
            <a class="navbar-brand" href="dashboard">Business <span class="text-warning">Permit</span> </a> <!-- /.navbar-brand -->
            <button class="hamburger hamburger-squeeze d-flex d-lg-none" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation"><span class="hamburger-box"><span class="hamburger-inner"></span></span></button> <!-- .navbar-collapse -->
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
              <!-- .navbar-nav -->
              <ul class="navbar-nav mr-auto mt-3 mt-lg-3">
                <!-- Dashboard -->
                <li class="nav-item">
                  <a class="nav-link mb-2" href="dashboard">Dashboard <span class="sr-only">(current)</span></a>
                </li><!-- /Dashboard -->  
              </ul>  
            </div><!-- /.navbar-collapse -->
          </div><!-- /.container -->
        </nav><!-- /.navbar -->
      </header><!-- /.app-header -->
      <!-- /.app-header -->
      <!-- .app-main -->
       
      <!-- .app-main -->
      <main class="app-main">
        <div class="wrapper">
          <div class="page">
            <div class="page-inner">
              <header class="page-title-bar">
                <h1 class="page-title"> <?php echo $page_title; ?> </h1>
              </header>
              
              <div class="page-section">  
                <div class="card card-fluid">
                  <div class="card-header">
                    <div class="d-flex align-items-center">
                      <h3 class="mr-auto p-3"><?php echo $page_title; ?> <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#create-new-user-modal"> <i class="fa fa-plus-circle"></i> Add New</button> </h3>
                      <div class="btn-group" role="group">
                        <div id="buttons"></div>   
                      </div>
                    </div>
                  </div>
                  <div class="card-body">  
                    
                    <!-- Create New Entry Modal -->
                    <div class="modal fade" id="create-new-user-modal" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-md  ">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Add New</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form id="create-new-business-permit-form" target="_blank">
                            <div class="modal-body">  
                              <small class=" text-danger">Note: * is requered</small> 
                              <fieldset> 
                                <div class="text-right">
                                  <label for="sp_no">SP #: <u><span id="sp_no" class="font-weight-bold h4 text-danger"><?php echo $sp_no; ?></span></u></label> 
                                  <input type="hidden" class="form-control" value="<?php echo $sp_no ?>" id="sp_no" name="sp_no" placeholder="SP #" required>
                                </div>


                                <div class="form-group"> 
                                  <label for="classification">Business Classification <span class="text-danger">*</span></label> 
                                  <select class="custom-select d-block w-100"  id="classification" name="classification" required>
                                    <option value=""> Choose... </option> 
                                    <?php 
                                      foreach($this->config->item('classification') as  $val){
                                        echo '
                                        <option value="'.$val.'">'.$val.'</option>
                                        '; 
                                      }
                                    ?>
                                  </select>
                                </div>  
                                <div class="form-group">
                                  <label for="business">Business <span class="text-danger">*</span></label> 
                                  <input type="text" class="form-control" id="business" name="business" placeholder="Business" required>
                                </div>
                                <div class="form-group">
                                  <label for="owner">Owner <span class="text-danger">*</span></label> 
                                  <input type="text" class="form-control" id="owner" name="owner" placeholder="Lastname, Firstname Middlename Suffix" required>
                                </div> 
                                <div class="form-group"> 
                                  <label for="address">Business Address <span class="text-danger">*</span></label> 
                                  <select class="custom-select d-block w-100"  id="address" name="address" required>
                                    <option value=""> Choose... </option> 
                                    <?php 
                                      foreach($this->config->item('barangay') as  $val){
                                        echo '
                                          <option value="'.$val.'">'.$val.'</option>
                                        '; 
                                      }
                                    ?>
                                  </select>
                                </div>  
                              </fieldset> 
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">Save changes</button>
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </form>
                        </div> 
                      </div>
                    </div> 

                    
                    <!-- Edit Entry -->
                    <div class="modal fade" id="edit-business-permit-modal" tabindex="-1" role="dialog" aria-hidden="true">
                      <div class="modal-dialog modal-dialog-centered modal-md  ">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title">Edit Business Permit</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <form id="update-business-permit-form">
                            <div class="modal-body">  
                              <small class=" text-danger">Note: * is requered</small>
                              <fieldset> 
                                <input type="hidden" name="id">
                                <div class="form-group"> 
                                  <label for="classification">Business Classification <span class="text-danger">*</span></label> 
                                  <select class="custom-select d-block w-100"  id="classification" name="classification" required>
                                    <option value=""> Choose... </option> 
                                    <?php 
                                      foreach($this->config->item('classification') as  $val){
                                        echo '
                                        <option value="'.$val.'">'.$val.'</option>
                                        '; 
                                      }
                                    ?>
                                  </select>
                                </div>  
                                <div class="form-group">
                                  <label for="business">Business <span class="text-danger">*</span></label> 
                                  <input type="text" class="form-control" id="business" name="business" placeholder="Business" required>
                                </div>
                                <div class="form-group">
                                  <label for="owner">Owner <span class="text-danger">*</span></label> 
                                  <input type="text" class="form-control" id="owner" name="owner" placeholder="Lastname, Firstname Middlename Suffix" required>
                                </div> 
                                <div class="form-group"> 
                                  <label for="address">Business Address <span class="text-danger">*</span></label> 
                                  <select class="custom-select d-block w-100"  id="address" name="address" required>
                                    <option value=""> Choose... </option> 
                                    <?php 
                                      foreach($this->config->item('barangay') as  $val){
                                        echo '
                                          <option value="'.$val.'">'.$val.'</option>
                                        '; 
                                      }
                                    ?>
                                  </select>
                                </div>  
                              </fieldset> 
                            </div>
                            <div class="modal-footer">
                              <button type="submit" class="btn btn-primary">Save changes</button>
                              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                          </form>
                        </div> 
                      </div>
                    </div>  
                    <table id="business-permit-table" class="table table-striped " width="100%"> 
                      <thead> 
                        <tr>
                          <th>#</th>
                          <th>SP #</th> 
                          <th>BUSINESS PERMIT CLASSIFICATION</th> 
                           <th>BUSINESS</th>
                           <th>OWNER</th>
                           <th>BUSINESS ADDRESS</th>
                           <th>Year</th>
                           <th>Action&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        </tr>
                      </thead>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div><!-- /.app -->
    
	<?php $this->view('layout/js') ?>  
  <script src="<?php  echo base_url(); ?>assets/vendor/datatable/js/jquery.dataTables.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/datatable/js/dataTables.bootstrap5.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/datatable/js/dataTables.buttons.min.js"> </script>
  <script src="<?php echo base_url(); ?>assets/vendor/datatable/js/jszip.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/datatable/js/pdfmake.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/datatable/js/vfs_fonts.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/datatable/js/buttons.print.min.js"></script>
  <script src="<?php echo base_url(); ?>assets/vendor/datatable/js/buttons.html5.min.js"></script> 
  <script src="<?php echo base_url(); ?>assets/vendor/datatable/js/buttons.colVis.min.js"></script>
  <script src="<?php echo base_url() ?>assets/javascript/sweetalert.js"></script>
  <script src="<?php echo base_url() ?>assets/javascript/business_permit.js"></script>  
  <script>
    // prevent f12 and right click event
    $(document).keydown(function (event) {
        if (event.keyCode == 123) { // Prevent F12
            return false;
        } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I        
            return false;
        }
    });

    $(document).bind("contextmenu",function(e){
        return false;
    });
  </script>  
  
  
  </body>
</html>