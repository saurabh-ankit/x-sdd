   <link rel="stylesheet" type="text/css"
       href="<?php echo base_url(); ?>admintemplate/bower_components/switchery/dist/switchery.min.css">
   <link rel="stylesheet" type="text/css"
       href="<?php echo base_url(); ?>admintemplate/assets/pages/advance-elements/css/bootstrap-datetimepicker.css">
   <!-- Date-range picker css  -->
   <link rel="stylesheet" type="text/css"
       href="<?php echo base_url(); ?>admintemplate/bower_components/bootstrap-daterangepicker/daterangepicker.css" />
   <!-- Date-Dropper css -->
   <link rel="stylesheet" type="text/css"
       href="<?php echo base_url(); ?>admintemplate/bower_components/datedropper/datedropper.min.css" />
   <link rel="stylesheet" type="text/css"
       href="<?php echo base_url(); ?>admintemplate/bower_components/switchery/dist/switchery.min.css" />


   <div class="page-header">
       <div class="page-header-title">
           <h4>Recipient</h4>
       </div>
       <div class="page-header-breadcrumb">
           <ul class="breadcrumb-title">
               <li class="breadcrumb-item">
                   <a href="index-2.html">
                       <i class="icofont icofont-home"></i>
                   </a>
               </li>
               <li class="breadcrumb-item"><a href="#!">Recipient</a>
               </li>
               <li class="breadcrumb-item"><a href="#!">Add Recipient</a>
               </li>
           </ul>
       </div>
   </div>
   <!-- Page header end -->
   <!-- Page body start -->
   <div class="page-body">
       <div class="row">
           <div class="col-sm-12">
               <!-- Basic Form Inputs card start -->
               <div class="card">
                   <div class="card-header">
                       <h5>Add User</h5>
                       <div class="card-header-right">
                           <i class="icofont icofont-rounded-down"></i>
                           <i class="icofont icofont-refresh"></i>
                           <i class="icofont icofont-close-circled"></i>
                       </div>
                   </div>
                   <div class="card-block">
                       <div class="col-sm-8">
                           <div class="validation_errors_alert">

                           </div>
                       </div>
                       <div class="col-sm-8">
                           <?php echo form_open_multipart('administrator/add_user'); ?>

                           <div class="form-group row">
                               <label class="col-sm-2 col-form-label">Recipient Name</label>
                               <div class="col-sm-10">
                                   <input type="text" name="recipient_name" class="form-control"
                                       placeholder="Recipient Name">
                               </div>
                           </div>
                           <div class="form-group row">
                               <label class="col-sm-2 col-form-label">capacity</label>
                               <div class="col-sm-10">
                                   <input type="text" name="capacity" class="form-control" placeholder="capacity"
                                       autocomplete="off">
                               </div>
                           </div>
                           <div class="form-group row">
                               <label class="col-sm-2 col-form-label">Identifier Number</label>
                               <div class="col-sm-10">
                                   <input type="text" name="identifier_number" class="form-control"
                                       placeholder="Identifier Number" autocomplete="off">
                               </div>
                           </div>
                           <div class="form-group row">
                               <label class="col-sm-2 col-form-label">Email</label>
                               <div class="col-sm-10">
                                   <input type="text" name="email_address" class="form-control" placeholder="Email"
                                       autocomplete="off">
                               </div>
                           </div>
                           <div class="form-group row">
                               <label class="col-sm-2 col-form-label">Entity Type</label>
                               <div class="col-sm-10">
                                   <select name="entity_type" class="form-control">
                                       <option value="individual">Individual</option>
                                       <option value="company">Company</option>
                                       <option value="others">Others</option>
                                   </select>
                               </div>
                           </div>
                           <div class="form-group row">
                               <label class="col-sm-2 col-form-label">Organisation</label>
                               <div class="col-sm-10">
                                   <input type="text" name="organisation" class="form-control"
                                       placeholder="Organisation" autocomplete="off">
                               </div>
                           </div>

                           <div class="form-group row">
                               <label class="col-sm-2 col-form-label"></label>
                               <div class="col-sm-10">
                                   <button type="submit" name="submit" class="btn btn-primary">Add</button>
                               </div>
                           </div>
                           </form>
                       </div>

                   </div>
               </div>
           </div>
           <!-- Basic Form Inputs card end -->


           <script type="text/javascript"
               src="<?php echo base_url(); ?>admintemplate/bower_components/switchery/dist/switchery.min.js"></script>
           <!-- Custom js -->
           <script type="text/javascript"
               src="<?php echo base_url(); ?>admintemplate/assets/pages/advance-elements/swithces.js"></script>
           <script type="text/javascript"
               src="<?php echo base_url(); ?>admintemplate/assets/pages/advance-elements/moment-with-locales.min.js">
           </script>
           <script type="text/javascript"
               src="<?php echo base_url(); ?>admintemplate/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js">
           </script>
           <script type="text/javascript"
               src="<?php echo base_url(); ?>admintemplate/assets/pages/advance-elements/bootstrap-datetimepicker.min.js">
           </script>
           <!-- Date-range picker js -->
           <script type="text/javascript"
               src="<?php echo base_url(); ?>admintemplate/bower_components/bootstrap-daterangepicker/daterangepicker.js">
           </script>
           <!-- Date-dropper js -->
           <script type="text/javascript"
               src="<?php echo base_url(); ?>admintemplate/bower_components/datedropper/datedropper.min.js"></script>


           <!-- ck editor -->
           <script src="<?php echo base_url(); ?>admintemplate/bower_components/ckeditor/ckeditor.js"></script>
           <!-- echart js -->

           <script src="<?php echo base_url(); ?>admintemplate/assets/pages/user-profile.js"></script>