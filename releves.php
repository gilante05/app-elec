<?php 
    session_start(); 
	if(!(isset($_SESSION['is_connected']) && $_SESSION['is_connected'] == 'connected' ))
	{
		header('location:login.php');
		die();
	}
?> 
<!-- insérer header ici -->
<?php include('includes/header.php'); ?>
<!-- contenu va ici -->
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Relevés</li>
        </ol>
      <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> Liste des relevés
            </div>
            <div class="card-body">
                <a href="new_releve.php" class="btn btn-primary"> Nouveau</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="relevesTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Compteur Elec</th>
                                <th>Valeur Elec </th>
                                <th>Compteur Eau</th>
                                <th>Valeur Eau</th>
                                <th>Date de relevé</th>
                                <th>Date de présentation</th>
                                <th>Date de limite de paiement</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal action paiement ici -->
<div class="modal" id="edit-paie">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h4 class="modal-title">Edit Employee</h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <form action="update.php" id="edit-form">
                        <input class="form-control" type="hidden" name="id">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input class="form-control" type="text" name="email">
                        </div>
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input class="form-control" type="text" name="first_name">
                        </div>
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input class="form-control" type="text" name="last_name">
                        </div>
                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea class="form-control" type="text" name="address" rows="3"></textarea>
                        </div>
                        <button type="button" class="btn btn-primary" id="btnUpdateSubmit">Update</button>
                        <button type="button" class="btn btn-danger float-right" data-dismiss="modal">Close</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

<!-- Fin modal -->
<script src="vendor/jquery/jquery.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="vendor/datatables/jquery.dataTables4.js"></script>
<script type="text/javascript" language="javascript" src="js/sweetalert2.all.min.js"></script>
<script type="text/javascript">
  function delete_releve() {
    $(document).delegate(".btn-delete-client", "click", function() {
        var releve = $(this).attr('id');
        Swal.fire({
          icon: 'warning',
            title: 'Are you sure you want to delete this record '+releve+'?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          // Ajax config
          $.ajax({
                type: "POST", //we are using GET method to get data from server side
                url: 'models/delete_releve.php', // get the route value
                data: {code:releve}, //set data
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    
                },
                success: function (response) {//once the request successfully process to the server side it will return result here
                    // Reload lists of employees
                    table.draw();

                    Swal.fire('Success.', response, 'success')
                }
            }); 
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    });
  });
}

  $(document).ready(function () {
    var mainurl = "models/get_releves.php";
    var table = $('#relevesTable').DataTable({
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
    
    delete_releve();
  });
</script>
<!-- footer -->
<?php include('includes/footer.php'); ?>
