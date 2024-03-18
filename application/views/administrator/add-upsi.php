           <div class="page-header">
               <div class="page-header-title">
                   <h4><?php echo $title; ?></h4>
               </div>
               <div class="page-header-breadcrumb">
                   <ul class="breadcrumb-title">
                       <li class="breadcrumb-item">
                           <a href="index-2.html">
                               <i class="icofont icofont-home"></i>
                           </a>
                       </li>
                       <?php //print_r($viewBlogComments); ?>
                       <li class="breadcrumb-item"><a href="<?php echo site_url();?>administrator/add/blog">Add
                               Blogs</a>
                       </li>
                       <li class="breadcrumb-item"><a href="<?php echo site_url();?>administrator/blogs/list-blog">List
                               Blogs</a>
                       </li>
                   </ul>
               </div>
           </div>

           <!-- Page body start -->
           <div class="page-body">
               <div class="row">
                   <div class="col-sm-12">
                       <!-- Basic Form Inputs card start -->
                       <div class="card">
                           <div class="card-block">
                               <?php echo form_open_multipart('administrator/add_upsi'); ?>
                               <div class="form-group col-sm-6">
                                   <label>Upload Data</label><br>
                                   <input type="file" class="form-control" name="userfile" size="20">
                               </div>
                               <div class="form-group col-sm-6" style="display: none">
                                   <label>Upload Data</label><br>
                                   <input type="text" value="12" class="form-control" name="test" size="20">
                               </div>
                               <button type="submit" class="btn btn-primary">Submit</button>
                               <?php echo form_close(); ?>
                           </div>
                       </div>

                       <!-- Basic Form Inputs card end -->
                   </div>
               </div>
           </div>
           <!-- Page body end -->
           </div>
           </div>