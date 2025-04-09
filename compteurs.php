
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
<link rel="stylesheet" type="text/css" href="vendor/datatables/jquery.dataTables4.css">
<!-- contenu va ici -->
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
            </li>
            <li class="breadcrumb-item active">Compteurs</li>
        </ol>
      <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header">
                <i class="fa fa-table"></i> Liste des compteurs
            </div>
            <div class="card-body">
                <a href="new_compteur.php" class="btn btn-primary"> Nouveau compteur</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="compteursTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>N° Compteur</th>
                                <th> Ref Client</th>
                                <th>Type</th>
                                <th>Prix unitaire</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="vendor/jquery/jquery.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="vendor/datatables/jquery.dataTables4.js"></script>
<script type="text/javascript" language="javascript" src="js/sweetalert2.all.min.js"></script>
<script type="text/javascript">
  function delete_compteur() {
    $(document).delegate(".btn-delete-compteur", "click", function() {
        var compteur = $(this).attr('id');
        Swal.fire({
          icon: 'warning',
            title: 'Are you sure you want to delete this record '+compteur+'?',
            showDenyButton: false,
            showCancelButton: true,
            confirmButtonText: 'Yes'
        }).then((result) => {
          /* Read more about isConfirmed, isDenied below */
        if (result.isConfirmed) {
          // Ajax config
          $.ajax({
                type: "POST", //we are using GET method to get data from server side
                url: 'models/delete_compteur.php', // get the route value
                data: {code:compteur}, //set data
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
      var mainurl = "models/get_compteurs.php";
      var table = $('#compteursTable').DataTable({
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
      delete_compteur();
  });
</script>
<!-- footer -->
<?php include('includes/footer.php'); ?>