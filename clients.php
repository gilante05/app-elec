<?php include('includes/header.php'); ?>
<link rel="stylesheet" type="text/css" href="vendor/datatables/jquery.dataTables4.css">
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Clients</li>
        </ol>
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header"><i class="fa fa-table"></i> Liste des Clients</div>
        <div class="card-body">
            <div class="top-panel">
                <a href="new_client.php" class="btn btn-primary">Nouveau Client</a>
            </div>
            <div class="table-responsive">
                <!-- Table here-->
                <table class="table table-bordered" id="clientsTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Nom & Prénoms</th>
                            <!--<th>Prénoms</th>-->
                            <th>Sexe</th>
                            <th>Quartier</th>
                            <th>Niveau</th>
                            <th>E-mail</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table> <!-- End of table -->
            </div>
        </div>
    </div>
</div>
<script src="vendor/jquery/jquery.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="vendor/datatables/jquery.dataTables4.js"></script>
<script type="text/javascript" language="javascript" src="js/sweetalert2.all.min.js"></script>
<script type="text/javascript">
  var table = $('#clientsTable');
  function delete_client() {
    $(document).delegate(".btn-delete-client", "click", function() {
        var codeCli = $(this).attr('id');
        Swal.fire({
          icon: 'warning',
            title: 'Voulez-vous vraiement supprimer le client '+codeCli+' ?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Oui',
            cancelButtonText: 'Non'

        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          // Ajax config
          $.ajax({
                type: "POST", //we are using GET method to get data from server side
                url: 'models/delete_client.php', // get the route value
                data: {code:codeCli}, //set data
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    
                },
                success: function (response) {//once the request successfully process to the server side it will return result here
                    // Reload lists of customers
                    $(table).DataTable().ajax.reload();
                    Swal.fire('Success.', response, 'success');
                    
                }
            }); 
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    });
  });
}

  $(document).ready(function () {
    var mainurl = "models/get_clients.php";
    $(table).DataTable({
          "bProcessing": true,
          "serverSide": true,
          "ajax":{
              url :mainurl, // json
              type: "get",  // type of method
              error: function(){  
                  //echo 'error';
              }
            }
    });
    
    delete_client();
  });
</script>

<?php include('includes/footer.php'); ?>          