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
                               <div class="col-sm-8">
                                   <?php echo form_open('administrator/update_recipient/'.$recipient[0]['id']); ?>

                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Recipient Name</label>
                                       <div class="col-sm-10">
                                           <input type="text" name="recipient_name" class="form-control"
                                               value="<?php print_r($recipient[0]['recipient_name']); ?>">
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Capacity</label>
                                       <div class="col-sm-10">
                                           <input type="text" name="capacity" class="form-control"
                                               value="<?php echo $recipient[0]['capacity']; ?>">
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Identifier Number</label>
                                       <div class="col-sm-10">
                                           <input type="text" name="identifier_number" class="form-control"
                                               value="<?php echo $recipient[0]['identifier_number']; ?>">
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Email Address</label>
                                       <div class="col-sm-10">
                                           <input type="email" name="email_address" class="form-control"
                                               value="<?php echo $recipient[0]['email_address']; ?>">
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Entity Type</label>
                                       <div class="col-sm-10">
                                           <input type="text" name="entity_type" class="form-control"
                                               value="<?php echo $recipient[0]['entity_type']; ?>">
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Organisation</label>
                                       <div class="col-sm-10">
                                           <input type="text" name="organisation" class="form-control"
                                               value="<?php echo $recipient[0]['Organisation']; ?>">
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label"></label>
                                       <div class="col-sm-10">
                                           <button type="submit" name="submit" class="btn btn-primary">Update</button>
                                       </div>
                                   </div>
                                   </form>
                               </div>


                           </div>
                       </div>

                       <!-- Basic Form Inputs card end -->
                   </div>
               </div>
           </div>
           <!-- Page body end -->
           </div>
           </div>