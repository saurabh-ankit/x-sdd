     <link rel="stylesheet" type="text/css"
         href="<?php echo base_url(); ?>admintemplate/bower_components/datatables.net-bs4/css/dataTables.bootstrap4.min.css">
     <link rel="stylesheet" type="text/css"
         href="<?php echo base_url(); ?>admintemplate/assets/pages/data-table/css/buttons.dataTables.min.css">
     <link rel="stylesheet" type="text/css"
         href="<?php echo base_url(); ?>admintemplate/bower_components/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css">
     <link rel="stylesheet" type="text/css"
         href="<?php echo base_url(); ?>admintemplate/bower_components/ekko-lightbox/dist/ekko-lightbox.css">
     <link rel="stylesheet" type="text/css"
         href="<?php echo base_url(); ?>admintemplate/bower_components/lightbox2/dist/css/lightbox.css">

     <script type="text/javascript">
$(document).ready(function() {
    $(".delete").click(function(e) {
        alert('as');
        $this = $(this);
        e.preventDefault();
        var url = $(this).attr("href");
        $.get(url, function(r) {
            if (r.success) {
                $this.closest("tr").remove();
            }
        })
    });
});
$(document).ready(function() {
    $(".enable").click(function(e) {
        alert('as');
        $this = $(this);
        e.preventDefault();
        var url = $(this).attr("href");
        $.get(url, function(r) {
            if (r.success) {
                $this.closest("tr").remove();
            }
        })
    });
});

$(document).ready(function() {
    $(".disable").click(function(e) {
        alert('as');
        $this = $(this);
        e.preventDefault();
        var url = $(this).attr("href");
        $.get(url, function(r) {
            if (r.success) {
                $this.closest("tr").remove();
            }
        })
    });
});
     </script>
     <!-- Page-header end -->
     <!-- Page-body start -->
     <div class="page-body">
         <!-- DOM/Jquery table start -->

         <div class="card">
             <div class="card-block">
                 <div class="page-header-title">
                     <h4>List UPSI</h4>
                 </div>
                 <div class="page-header-breadcrumb">
                     <ul class="breadcrumb-title">
                         <li class="breadcrumb-item">
                             <a href="<?php echo site_url();?>administrator">
                                 <i class="icofont icofont-home"></i>
                             </a>
                         </li>
                         <li class="breadcrumb-item"><a href="<?php echo site_url();?>administrator/add/blog">Add
                                 UPSI</a>
                         </li>
                         <li class="breadcrumb-item"><a
                                 href="<?php echo site_url();?>administrator/blogs/list-blog">List UPSI</a>
                         </li>
                     </ul>
                 </div>
                 <div class="table-responsive dt-responsive">
                     <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                         <thead>
                             <tr>
                                 <th>Id</th>
                                 <th>Nature of UPSI</th>
                                 <th>Date of Sharing</th>
                                 <th>Time of Sharing</th>
                                 <th>Shared By</th>
                                 <th>Department</th>
                                 <th>Recipient</th>
                                 <th>Purpose</th>
                                 <th>Period of UPSI from</th>
                                 <th>Period of UPSI to</th>
                                 <th>Action</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php foreach($upsi as $key) : ?>
                             <tr>
                                 <td><?php echo $key['id']; ?></td>
                                 <td><?php echo $key['nature_of_upsi']; ?></td>
                                 <td><?php echo $key['date_of_sharing']; ?></td>
                                 <td><?php echo $key['mail_time']; ?></td>
                                 <td>
                                     <?php 
                                    $created_by_email = $key['created_by']; // Get the email address from $key['created_by']
                                    $created_by_name = ''; // Initialize variable to store creator's name
                                    
                                    // Query the database to get the creator's name based on the email address
                                    $creator_query = $this->db->get_where('recipients', array('email_address' => $created_by_email));

                                    // Check if the query returned a result
                                    if ($creator_query->num_rows() > 0) {
                                        // Fetch the creator's name from the query result
                                        $creator_data = $creator_query->row_array();
                                        $created_by_name = $creator_data['recipient_name'];
                                    }

                                    // Output creator's name
                                    echo $created_by_name;
                                    ?>
                                 </td>
                                 <td><?php //echo $key['department']; ?></td>
                                 <td>
                                     <?php 
                                $recipients = explode(',', $key['recipients']); // Split recipients into an array
                                foreach ($recipients as $email) {
                                    // Query the database to get the recipient's name based on the email address
                                    $recipient_name = ''; // Initialize variable to store recipient's name
                                    // Perform the database query to fetch recipient's name based on email address
                                    $recipient_query = $this->db->get_where('recipients', array('email_address' => $email));
                                    // Check if the query returned a result
                                    if ($recipient_query->num_rows() > 0) {
                                        // Fetch the recipient's name from the query result
                                        $recipient_data = $recipient_query->row_array();
                                        $recipient_name = $recipient_data['recipient_name'];
                                    }
                                    // Output recipient's name
                                    echo $recipient_name . '<br>';
                                }
                                ?>
                                 </td>

                                 <td style="white-space: pre-wrap;"><?php echo $key['purpose']; ?></td>
                                 <td><?php echo $key['period_of_upsi_from']; ?></td>
                                 <td><?php echo $key['period_of_upsi_to']; ?></td>
                                 <td>
                                     <!-- Add an Edit button linking to your edit action/controller method -->
                                     <a href="<?php echo base_url('administrator/upsi/edit_upsi/' . $key['id']); ?>"
                                         class="label label-inverse-info">Edit</a>
                                 </td>


                             </tr>
                             <?php endforeach; ?>

                             <!-- <div class="paginate-link">
                                    <?php //echo $this->pagination->create_links(); ?>
                                </div>  -->

                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
         <!-- DOM/Jquery table end -->
     </div>