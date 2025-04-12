<?php 
    session_start(); 
     if(!(isset($_SESSION['is_connected']) && $_SESSION['is_connected'] == 'connected' ))
     {
         header('location:login.php');
         die();
     }
    require('includes/connexion.php');
    $db = connect_bd();
    $dateReleve = '';
    if(isset($_POST)){
        $codeReleve = $_POST['code_releve'];
        $codeCli = $_POST['code_cli'];
        $stmt = $db->prepare("SELECT Date_releve FROM releve WHERE  CodeReleve = ?");
        $stmt->execute([$codeReleve]);
        $releve = $stmt->fetch(PDO::FETCH_ASSOC);
        setlocale(LC_TIME, 'fr_FR');
        $moisReleve = date('F',strtotime($releve['Date_releve']));
    }
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
                                <input type="text" name="code_cli" class="form-control"  readonly value="<?=$codeCli?>">
                            </div>
                          <div class="form-group">
                              <label>Mois</label>
                              <input type="text" name="mois_fact" class="form-control" value="<?=$moisReleve;?>" readonly>
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