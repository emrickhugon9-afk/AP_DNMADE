<!DOCTYPE html>
<html lang="en">

<head>
  <?php
  include 'pdo_config.php';
  try {
    $requete = $db->prepare('SELECT * FROM USERS');
    $requete->execute();
    $users = $requete->fetchAll();
  } catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();
  }
  ?>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>SB Admin 2 - Tables</title>

  <!-- Custom fonts for this template -->
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

  <!-- Custom styles for this template -->
  <link href="css/sb-admin-2.min.css" rel="stylesheet">

  <!-- Custom styles for this page -->
  <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body id="page-top">

  <!-- Page Wrapper -->
  <div id="wrapper">

    <?php include 'sidebar.php'; ?>

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

      <!-- Main Content -->
      <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
          <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
            <i class="fa fa-bars"></i>
          </button>
        </nav>
        <!-- End Topbar -->

        <!-- Begin Page Content -->
        <div class="container-fluid">
          <h1 class="h3 mb-4 text-gray-800">Liste des utilisateurs</h1>

          <!-- Bouton Ajouter -->
          <button type="button" class="btn btn-primary mb-3" data-toggle="modal" id="addUserBtn" data-target="#addModal">
            <i class="bi bi-person-add"></i> Ajouter un utilisateur
          </button>

          <!-- DataTales Example -->
          <div class="card shadow mb-4">
            <div class="card-header py-3">
              <h6 class="m-0 font-weight-bold text-primary">
                Tableau des utilisateurs
              </h6>

              <?php  //Modal Add
              echo '
              <div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <form method="post" action="CRUD/user_add.php">
                      <div class="modal-header">
                        <h5 class="modal-title" id="userModalLabel"><i class="bi bi-person-add"></i> Ajouter un utilisateur</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                          <span aria-hidden="true">&times;</span>
                        </button>
                      </div>
                      <div class="modal-body">
                        <input type="hidden" name="id" id="userId">
                        <div class="form-group">
                          <label>Nom</label>
                          <input type="text" name="last_name" id="userNom" class="form-control" required>
                        </div>
                        <div class="form-group">
                          <label>Prénom</label>
                          <input type="text" name="first_name" id="userPrenom" class="form-control" required>
                        </div>
                          <div class="form-group">
                          <label>Classe</label>
                          <input type="text" name="class" id="userClass" class="form-control" required>
                        </div>
                        <div class="form-group">
                          <label>Mot de passe temporaire</label>
                          <input type="password" name="password" id="userPassword" class="form-control" required>
                        </div>
                        <div class="form-group">
                          <label>E-mail</label>
                          <input type="email" name="email" id="userEmail" class="form-control" required>
                        </div>
                        <div class="form-group">
                          <label>Statut</label>
                          <select name="status" id="userStatut" class="form-control">
                            <option value="Administrateur">Administrateur</option>
                            <option value="Élève">Élève</option>
                            <option value="Entreprise">Entreprise</option>
                          </select>
                        </div>
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                        <button type="submit" name="submit" class="btn btn-primary" id="modalSubmit">Ajouter</button>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
              '; ?>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                  <thead>
                    <tr>
                      <th>Nom</th>
                      <th>Prénom</th>
                      <th>E-mail</th>
                      <th>Classe</th>
                      <th>Statut</th>
                      <th>Date de création</th>
                      <th>Actions</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $modals = ""; // On initialise la variable pour stocker les modales

                    foreach ($users as $user) {
                      echo "<tr>";
                      echo "<td>" . $user['last_name'] . "</td>";
                      echo "<td>" . $user['first_name'] . "</td>";
                      echo "<td>" . $user['email'] . "</td>";
                      echo "<td>" . $user['class'] . "</td>";
                      echo "<td>" . $user['status'] . "</td>";
                      echo "<td>" . $user['created_at'] . "</td>";
                      echo "<td>
                        <a href='#' class='btn btn-sm btn-warning' data-toggle='modal' data-target='#editModal" . $user['id_user'] . "'><i class='bi bi-pencil-square'></i> Modifier</a>
                        <a href='#' class='btn btn-sm btn-danger' data-toggle='modal' data-target='#deleteModal" . $user['id_user'] . "'><i class='bi bi-trash3'></i> Supprimer</a>
                        <a href='#' class='btn btn-sm btn-secondary' data-toggle='modal' data-target='#resetPwdModal" . $user['id_user'] . "'><i class='bi bi-key'></i> Mot de passe</a>
                      </td>";
                      echo "</tr>";

                      // Stockage de la Modal Edit 
                      $modals .= "
                      <div class='modal fade' id='editModal" . $user['id_user'] . "' tabindex='-1' aria-hidden='true'>
                        <div class='modal-dialog'>
                          <div class='modal-content'>
                            <form method='post' action='CRUD/user_edit.php'>
                              <div class='modal-header'>
                                <h5 class='modal-title'>Modifier " . $user['first_name'] . " " . $user['last_name'] . "</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Fermer'>
                                  <span aria-hidden='true'>&times;</span>
                                </button>
                              </div>
                              <div class='modal-body'>
                                <input type='hidden' name='id' value='" . $user['id_user'] . "'>
                                <div class='form-group'>
                                  <label>Nom</label>
                                  <input type='text' name='last_name' class='form-control' required value='" . $user['last_name'] . "'>
                                </div>
                                <div class='form-group'>
                                  <label>Prénom</label>
                                  <input type='text' name='first_name' class='form-control' required value='" . $user['first_name'] . "'>
                                </div>
                                 <div class='form-group'>
                                  <label>Classe</label>
                                  <input type='text' name='class' class='form-control' required value='" . $user['class'] . "'>
                                </div>
                                <div class='form-group'>
                                  <label>E-mail</label>
                                  <input type='email' name='email' class='form-control' required value='" . $user['email'] . "'>
                                </div>
                                <div class='form-group'>
                                  <label>Statut</label>
                                  <select name='status' class='form-control'>
                                  <option value='Administrateur'" . ($user['status'] == 'Administrateur' ? " selected" : "") . ">Administrateur</option>
                                  <option value='Élève'" . ($user['status'] == 'Élève' ? " selected" : "") . ">Élève</option>
                                  <option value='Entreprise'" . ($user['status'] == 'Entreprise' ? " selected" : "") . ">Entreprise</option>
                                  </select>
                                </div>
                              </div>
                              <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Annuler</button>
                                <button type='submit' class='btn btn-primary'>Modifier</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      ";

                      // Stockage de la Modal Delete
                      $modals .= "
                      <div class='modal fade' id='deleteModal" . $user['id_user'] . "' tabindex='-1' role='dialog'>
                        <div class='modal-dialog' role='document'>
                          <div class='modal-content'>
                            <div class='modal-header'>
                              <h5 class='modal-title'>Supprimer un utilisateur</h5>
                              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                              </button>
                            </div>
                            <div class='modal-body'>
                              <p>Voulez-vous vraiment supprimer " . $user['first_name'] . " " . $user['last_name'] . " ?</p>
                            </div>
                            <div class='modal-footer'>
                              <a href='CRUD/user_delete.php?id=" . $user['id_user'] . "' class='btn btn-danger'>Supprimer</a>
                              <button type='button' class='btn btn-secondary' data-dismiss='modal'>Annuler</button>
                            </div>
                          </div>
                        </div>
                      </div>
                      ";

                      // Stockage de la Modal Reset Password
                      $modals .= "
                      <div class='modal fade' id='resetPwdModal" . $user['id_user'] . "' tabindex='-1' aria-hidden='true'>
                        <div class='modal-dialog'>
                          <div class='modal-content'>
                            <form method='post' action='CRUD/user_reset_pwd.php' onsubmit='checkPasswords(event, " . $user['id_user'] . ")'>
                              <div class='modal-header'>
                                <h5 class='modal-title'>Réinitialiser le mot de passe de " . $user['first_name'] . " " . $user['last_name'] . "</h5>
                                <button type='button' class='close' data-dismiss='modal' aria-label='Fermer'>
                                  <span aria-hidden='true'>&times;</span>
                                </button>
                              </div>
                              <div class='modal-body'>
                                <input type='hidden' name='id' value='" . $user['id_user'] . "'>
                                <div class='form-group'>
                                  <label>Nouveau mot de passe</label>
                                  <input type='password' name='password' id='password" . $user['id_user'] . "' class='form-control' required>
                                </div>
                               <div class='form-group'>
                                  <label>Confirmer le mot de passe</label>
                                  <input type='password' name='password_confirm' id='password_confirm" . $user['id_user'] . "' class='form-control' required>
                                </div>
                                <p id='pwdMatchError' style='color: red; display: none;'>Les mots de passe ne correspondent pas.</p>
                              </div>
                              <div class='modal-footer'>
                                <button type='button' class='btn btn-secondary' data-dismiss='modal'>Annuler</button>
                                <button type='submit' class='btn btn-primary' id='resetPwdBtn'>Réinitialiser</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div>
                      ";
                    }
                    ?>
                  </tbody>
                </table>
              </div>

              <!-- Affichage des modales ICI, en dehors du tableau -->
              <?php echo $modals; ?>

            </div>
          </div>

        </div>
        <!-- /.container-fluid -->

      </div>
      <!-- End of Main Content -->

      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright &copy; Your Website 2020</span>
          </div>
        </div>
      </footer>
      <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

  </div>
  <!-- End of Page Wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="login.html">Logout</a>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin-2.min.js"></script>

  <!-- Page level plugins -->
  <script src="vendor/datatables/jquery.dataTables.min.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="js/demo/datatables-demo.js"></script>

  <!-- Fichier utilisateur placé avant la fermeture du body -->
  <script src='js/user.js' defer></script>

</body>

</html>