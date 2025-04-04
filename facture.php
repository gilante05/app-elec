<?php 
    require('includes/connexion.php');
    
    $db = connect_bd();

    $stmt = $db->prepare('SELECT * FROM client ORDER BY CodeCli');
    $stmt->execute();
    // Fetch the records so we can display them in our template.
    $clients = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include('includes/header.php'); ?>  
  <!-- contenu ici -->
  <div class="content-wrapper">
          <div class="container-fluid">
              <!-- Breadcrumbs-->
              <ol class="breadcrumb">
                  <li class="breadcrumb-item">
                      <a href="index.html">Dashboard</a>
                  </li>
                  <li class="breadcrumb-item active">Facture</li>
              </ol>
              <div class="row">
                  <div class="col-12">
                      <h1>Edition d'un facture</h1>
                  </div>
                  <div class="col-md-8">
                      <form action="print.php" method="post">
                            <div class="form-group">
                                <label>Code Client</label>
                                <input type="text" name="code_cli" class="form-control" list="list-client">
                                <datalist id="list-client">
                                <?php foreach($clients as $client): ?>
                                    <option><?=$client['CodeCli']?></option>
                                <?php endforeach; ?>
                                </datalist>
                            </div>
                          <div class="form-group">
                              <label>Mois</label>
                              <input type="month" name="mois_fact" class="form-control">
                          </div>
                          <div class="form-group">
                            <input type="submit"  value="Imprimer" class="btn btn-primary">
                          </div>
                      </form>
                  </div>
              </div>
          </div>
      </div>
  <?php include('includes/footer.php'); ?>          