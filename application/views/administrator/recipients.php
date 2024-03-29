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
     </script>



     <div class="page-header">
         <div class="page-header-title">
             <h4>List Users</h4>
         </div>
         <div class="page-header-breadcrumb">
             <ul class="breadcrumb-title">
                 <li class="breadcrumb-item">
                     <a href="index-2.html">
                         <i class="icofont icofont-home"></i>
                     </a>
                 </li>
                 <li class="breadcrumb-item"><a href="#!">Recipients</a>
                 </li>
                 <li class="breadcrumb-item"><a href="#!">List Recipients</a>
                 </li>
             </ul>
         </div>
     </div>

     <!-- Page-header end -->
     <!-- Page-body start -->
     <div class="page-body">
         <!-- DOM/Jquery table start -->

         <div class="card">
             <div class="card-block">
                 <div class="table-responsive dt-responsive">
                     <table id="dom-jqry" class="table table-striped table-bordered nowrap">
                         <thead>
                             <tr>
                                 <th>Id</th>
                                 <th>Recipient Name</th>
                                 <th>Capacity</th>
                                 <th>Identifier Number</th>
                                 <th>Email Address</th>
                                 <th>Entity Type</th>
                                 <th>Organisation</th>
                                 <th>Action</th>
                             </tr>
                         </thead>
                         <tbody>
                             <?php foreach($recipients as $post) : ?>
                             <tr>
                                 <td><?php echo $post['id']; ?></td>
                                 <td><a href="edit-blog.php?id=14"><?php echo $post['recipient_name']; ?></a></td>
                                 <td><?php echo $post['capacity']; ?></td>
                                 <td><?php echo $post['identifier_number']; ?></td>
                                 <td><?php echo $post['email_address']; ?></td>
                                 <td><?php echo $post['entity_type']; ?></td>
                                 <td><?php echo $post['Organisation']; ?></td>

                                 <td>

                                     <a class="label label-inverse-info"
                                         href='<?php echo base_url(); ?>administrator/recipients/edit_recipients/<?php echo $post['id']; ?>'>Edit</a>
                                     <a class="label label-inverse-danger delete"
                                         href='<?php echo base_url(); ?>administrator/recipients/delete_recipient/<?php echo $post['id']; ?>'>Delete</a>
                                 </td>
                             </tr>
                             <?php endforeach; ?>

                             <!-- <div class="paginate-link">
                                    <?php echo $this->pagination->create_links(); ?>
                                </div>  -->

                         </tbody>
                     </table>
                 </div>
             </div>
         </div>
         <!-- DOM/Jquery table end -->
     </div>