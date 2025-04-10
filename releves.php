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
                <a href="new_releve.php" class="btn btn-primary"> Nouveau relevé</a>
                <div class="table-responsive">
                    <table class="table table-bordered" id="relevesTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Réf. Elec</th>
                                <th>Valeur Elec </th>
                                <th>Réf. Eau</th>
                                <th>Valeur Eau</th>
                                <th>Date relevé</th>
                                <th>Date présentation</th>
                                <th>Date limite</th>
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
<script src="vendor/jquery/jquery.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="vendor/datatables/jquery.dataTables4.js"></script>
<script type="text/javascript" language="javascript" src="js/sweetalert2.all.min.js"></script>
<script type="text/javascript">
    var table = $('#relevesTable');
    function delete_releve() {
        $(document).delegate(".btn-delete-releve", "click", function() {
            var releve = $(this).attr('id');
            Swal.fire({
            icon: 'warning',
                title: 'Voulez-vous vraiement supprimer le relevé '+releve+'?',
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
                    url: 'models/delete_releve.php', // get the route value
                    data: {code:releve}, //set data
                    beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                        
                    },
                    success: function (response) {//once the request successfully process to the server side it will return result here
                        // Reload lists of employees
                        $(table).DataTable().ajax.reload();
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
    
    delete_releve();
  });
</script>
<!-- footer -->
<?php include('includes/footer.php'); ?>
