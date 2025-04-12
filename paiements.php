<?php include('includes/header.php'); ?>
<link rel="stylesheet" type="text/css" href="vendor/datatables/jquery.dataTables4.css">
<div class="content-wrapper">
    <div class="container-fluid">
      <!-- Breadcrumbs-->
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
            <li class="breadcrumb-item active">Paiements</li>
        </ol>
        <!-- Example DataTables Card-->
        <div class="card mb-3">
            <div class="card-header"><i class="fa fa-table"></i> Liste des paiements</div>
        <div class="card-body">
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
                </table> <!-- End of table -->
            </div>
        </div>
    </div>
</div>
<script src="vendor/jquery/jquery.js" type="text/javascript"></script>
<script type="text/javascript" language="javascript" src="vendor/datatables/jquery.dataTables4.js"></script>
<script type="text/javascript" language="javascript" src="js/sweetalert2.all.min.js"></script>
<script type="text/javascript">
  var table = $('#payerTable');
    function payer_facture() {
      $(document).delegate(".btn-payer", "click", function() {
          var idPayer = $(this).attr('id');
          Swal.fire({
            icon: 'question',
              title: 'Voulez-vous payer ce facture '+idPayer+' ?',
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
                  url: 'models/payer_facture.php', // get the route value
                  data: {id:idPayer}, //set data
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

  function imprimer_facture() {
    $(document).delegate(".btn-print-facture", "click", function() {
        var codeReleve = $(this).attr('id');
        Swal.fire({
          icon: 'question',
            title: 'Imprimer le facture '+idPayer+' ?',
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
                url: 'models/imprimer_facture.php', // get the route value
                data: {code:codeReleve}, //set data
                beforeSend: function () {//We add this before send to disable the button once we submit it so that we prevent the multiple click
                    
                },
                success: function (response) {//once the request successfully process to the server side it will return result here
                    //Swal.fire('Success.', response, 'success');
                    
                }
            }); 
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    });
  });
}

$(document).ready(function () {
    var mainurl = "models/get_paiements.php";
    $(table).DataTable({
          "bProcessing": true,
          "serverSide": true,
          "lengthMenu": [[3, 5, 10, 20, -1], [3, 5, 10, 20]],
          "ajax":{
              url :mainurl, // json
              type: "get",  // type of method
              error: function(){  
                  //echo 'error';
              }
            }
    });
    
    payer_facture();
    imprimer_facture();
});
</script>

<?php include('includes/footer.php'); ?>          