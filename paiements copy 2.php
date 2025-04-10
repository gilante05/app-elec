<?php 
     session_start(); 
     if(!(isset($_SESSION['is_connected']) && $_SESSION['is_connected'] == 'connected' ))
     {
         header('location:login.php');
         die();
     }
?>
<?php include('includes/header.php'); ?>
<link rel="stylesheet" type="text/css" href="vendor/datatables/jquery.dataTables4.css">
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
            <li class="breadcrumb-item active">Paiements</li>
        </ol>
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header"><i class="fa fa-table"></i> Liste des paiements</div>
        <div class="card-body">
            <a href="facture.php" class="btn btn-primary"> Générer une facture</a>
            <div class="table-responsive">
                <!-- Table here-->
                <table class="table table-bordered" id="payerTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Client</th>
                            <th>Date de paiement</th>
                            <th>Montant</th>
                            <th>Etat</th>
                            <th>Relevé</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script src="vendor/jquery/jquery.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="vendor/datatables/jquery.dataTables4.js"></script>
<script type="text/javascript" language="javascript" src="js/sweetalert2.all.min.js"></script>
<script type="text/javascript">
<script type="text/javascript">
    var table = $('#payerTable');
    $(document).ready(function () {
        var mainurl = "models/get_paiements.php";
        $(table).DataTable({
            "bProcessing": true,
            "serverSide": true,
            "ajax":{
                url :mainurl, // json
                type: "GET",  // type of method
                error: function(){  
                    //echo 'error';
                }
            }
        });
    //delete_client();
  });
</script>
<!-- footer -->
<?php include('includes/footer.php'); ?>
