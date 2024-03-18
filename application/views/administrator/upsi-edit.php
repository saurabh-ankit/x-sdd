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
                                   <?php echo form_open('administrator/update_upsi/'.$upsi['id']); ?>

                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Nature of UPSI</label>
                                       <div class="col-sm-10">
                                           <input type="text" name="nature_of_upsi" class="form-control"
                                               value="<?php echo $upsi['nature_of_upsi']; ?>">
                                       </div>
                                   </div>
                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Purpose</label>
                                       <div class="col-sm-10">
                                           <input type="text" name="purpose" class="form-control"
                                               value="<?php echo $upsi['purpose']; ?>">
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Date of Sharing</label>
                                       <div class="col-sm-10">
                                           <input type="date" name="date_of_sharing" class="form-control"
                                               value="<?php echo date('Y-m-d', strtotime($upsi['date_of_sharing'])); ?>">
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Time of Sharing (mail_time)</label>
                                       <div class="col-sm-10">
                                           <input type="time" name="mail_time" class="form-control"
                                               value="<?php echo date('H:i', strtotime($upsi['mail_time'])); ?>">
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Shared By</label>
                                       <div class="col-sm-10">
                                           <input type="text" name="created_by" class="form-control"
                                               value="<?php echo $upsi['created_by']; ?>">
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Period of UPSI From</label>
                                       <div class="col-sm-10">
                                           <input type="date" name="period_of_upsi_from" class="form-control"
                                               value="<?php echo date('Y-m-d', strtotime($upsi['period_of_upsi_from'])); ?>">
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Period of UPSI To</label>
                                       <div class="col-sm-10">
                                           <input type="date" name="period_of_upsi_to" class="form-control"
                                               value="<?php echo date('Y-m-d', strtotime($upsi['period_of_upsi_to'])); ?>">
                                       </div>
                                   </div>
                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">System Entry Date</label>
                                       <div class="col-sm-10">
                                           <input type="date" name="system_entry_date" class="form-control"
                                               value="<?php echo date('Y-m-d'); ?>">
                                       </div>
                                   </div>

                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">System Entry Time</label>
                                       <div class="col-sm-10">
                                           <input type="time" name="system_entry_time" class="form-control"
                                               value="<?php echo date('H:i'); ?>">
                                       </div>
                                   </div>
                                   <div class="form-group row">
                                       <label class="col-sm-2 col-form-label">Recipients (Multiple Email Addresses,
                                           comma-separated)</label>
                                       <div class="col-sm-10">
                                           <div id="recipient-container">
                                               <?php 
                                            // Explode the recipients string into an array
                                            $recipients = explode(',', $upsi['recipients']);
                                            // Loop through each recipient
                                            foreach ($recipients as $recipient) {
                                                // Display an input field for each recipient with a Remove button
                                                echo '<div class="form-group row recipient-input">';
                                                echo '<div class="col-sm-10">';
                                                echo '<input type="text" name="recipients[]" class="form-control" value="' . trim($recipient) . '">';
                                                echo '</div>';
                                                echo '<div class="col-sm-2">';
                                                echo '<button type="button" class="remove-recipient btn btn-danger">Remove</button>';
                                                echo '</div>';
                                                echo '</div>';
                                            }
                                            ?>
                                           </div>
                                           <button type="button" id="add-recipient" class="btn btn-success">Add
                                               Recipient</button>
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

           <script>
document.addEventListener('DOMContentLoaded', function() {
    // Add recipient
    document.getElementById('add-recipient').addEventListener('click', function() {
        var recipientContainer = document.getElementById('recipient-container');
        var recipientInput = document.createElement('div');
        recipientInput.classList.add('form-group', 'row', 'recipient-input');
        recipientInput.innerHTML = '<div class="col-sm-10">' +
            '<input type="text" name="recipients[]" class="form-control">' +
            '</div>' +
            '<div class="col-sm-2">' +
            '<button type="button" class="remove-recipient btn btn-danger">Remove</button>' +
            '</div>';
        recipientContainer.appendChild(recipientInput);
    });

    // Remove recipient
    document.getElementById('recipient-container').addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-recipient')) {
            e.target.closest('.recipient-input').remove();
        }
    });
});
           </script>