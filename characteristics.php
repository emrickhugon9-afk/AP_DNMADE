<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Characteristics</title>

    <!-- Custom fonts -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- DataTables -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
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


                <!-- Content Wrapper -->
                <div id="content-wrapper" class="d-flex flex-column">

                    <!-- Main Content -->
                    <div id="content">

                        <!-- Topbar -->
                        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                            <button id="sidebarToggleTop"
                                class="btn btn-link d-md-none rounded-circle mr-3">

                                <i class="fa fa-bars"></i>

                            </button>

                        </nav>
                        <!-- End Topbar -->

                        <!-- Begin Page Content -->
                        <div class="container-fluid">

                            <?php

                            include 'pdo_config.php';

                            try {

                                $requete = $db->prepare('SELECT * FROM CRITERIA');
                                $requete->execute();
                                $criteres = $requete->fetchAll();
                                $requete = $db->prepare('SELECT * FROM CHARACTERISTICS ORDER BY id_criteria ASC');
                                $requete->execute();
                                $caracteristiques = $requete->fetchAll();
                            } catch (PDOException $e) {

                                echo "Erreur : " . $e->getMessage();
                            }

                            ?>

                            <!-- Title -->
                            <h1 class="h3 mb-4 text-gray-800">
                                Liste des caractéristiques
                            </h1>

                            <!-- Add Button -->
                            <button type="button"
                                class="btn btn-primary mb-3"
                                data-toggle="modal"
                                data-target="#addModal">

                                <i class="bi bi-plus-circle"></i>

                                Ajouter une caractéristique

                            </button>

                            <!-- Modal Add -->
                            <div class="modal fade"
                                id="addModal"
                                tabindex="-1"
                                aria-hidden="true">

                                <div class="modal-dialog">

                                    <div class="modal-content">

                                        <form method="post"
                                            action="characteristics_add.php">

                                            <div class="modal-header">

                                                <h5 class="modal-title">
                                                    Ajouter une caractéristique
                                                </h5>

                                                <button type="button"
                                                    class="close"
                                                    data-dismiss="modal">

                                                    <span>&times;</span>

                                                </button>

                                            </div>

                                            <div class="modal-body">

                                                <div class="form-group">

                                                    <label>Nom</label>

                                                    <input type="text"
                                                        name="characteristic"
                                                        class="form-control"
                                                        required>

                                                </div>

                                                <div class="form-group">

                                                    <label>Critère</label>

                                                    <select name="id_criteria"
                                                        class="form-control"
                                                        required>

                                                        <option value=""
                                                            disabled
                                                            selected>

                                                            Sélectionnez un critère

                                                        </option>

                                                        <?php foreach ($criteres as $critere): ?>

                                                            <option value="<?= $critere['id_criteria'] ?>">

                                                                <?= $critere['criteria'] ?>

                                                            </option>

                                                        <?php endforeach; ?>

                                                    </select>

                                                </div>

                                            </div>

                                            <div class="modal-footer">

                                                <button type="button"
                                                    class="btn btn-secondary"
                                                    data-dismiss="modal">

                                                    Annuler

                                                </button>

                                                <button type="submit"
                                                    class="btn btn-primary">

                                                    Ajouter

                                                </button>

                                            </div>

                                        </form>

                                    </div>

                                </div>

                            </div>

                            <!-- Table -->
                            <div class="card shadow mb-4">

                                <div class="card-header py-3">

                                    <h6 class="m-0 font-weight-bold text-primary">

                                        Tableau des caractéristiques

                                    </h6>

                                </div>

                                <div class="card-body">

                                    <div class="table-responsive">

                                        <table class="table table-bordered"
                                            id="dataTable"
                                            width="100%"
                                            cellspacing="0">
                                            <thead>

                                                <tr>

                                                    <th>Nom</th>

                                                    <th>Critère</th>

                                                    <th>Actions</th>

                                                </tr>

                                            </thead>


                                            <tbody>

                                                <?php foreach ($caracteristiques as $caracteristique): ?>

                                                    <tr>

                                                        <td>
                                                            <?= $caracteristique['label'] ?>
                                                        </td>

                                                        <td>

                                                            <?php

                                                            $requete = $db->prepare('SELECT criteria, id_criteria FROM CRITERIA WHERE id_criteria = :id');

                                                            $requete->execute([
                                                                'id' => $caracteristique['id_criteria']
                                                            ]);

                                                            $crit = $requete->fetch();

                                                            echo $crit['criteria'];

                                                            ?>

                                                        </td>

                                                        <td>
                                                            <?php
                                                            echo "
                                                    <a href='#' class='btn btn-sm btn-warning' data-toggle='modal' data-target='#editModal" . $caracteristique['id_characteristic'] . "'><i class='bi bi-pencil-square'></i> Modifier</a>
                                                    <a href='#' class='btn btn-sm btn-danger' data-toggle='modal' data-target='#deleteModal" . $caracteristique['id_characteristic'] . "'><i class='bi bi-trash3'></i> Supprimer</a>
                                                            ";
                                                            ?>
                                                        </td>

                                                    </tr>


                                                    <?php
                                                    // Modal Edit 
                                                    echo "
                                            
    <div class='modal fade' id='editModal" . $caracteristique['id_characteristic'] . "' tabindex='-1' aria-hidden='true'>
      <div class='modal-dialog'>
        <div class='modal-content'>
          <form method='post' action='characteristic_edit.php'>
            <div class='modal-header'>
              <h5 class='modal-title'>Modifier " . $caracteristique['label'] . "</h5>
              <button type='button' class='close' data-dismiss='modal' aria-label='Fermer'>
                <span aria-hidden='true'>&times;</span>
              </button>
            </div>
            <div class='modal-body'>
              <input type='hidden' name='id' value='" . $caracteristique['id_characteristic'] . "'>
              <input type='hidden' name='id_criteria' value='" . $crit['id_criteria'] . "'>
              <div class='form-group'>
                <label>Nom</label>
                <input type='text' name='label' class='form-control' required value='" . $caracteristique['label'] . "'>
              </div>
                <label>Critère</label>
                <input type='text' disabled name='criteria' class='form-control' required value='" . $crit['criteria'] . "'>
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

                                                    // Modal Delete
                                                    echo "
    <div class='modal fade' id='deleteModal" . $caracteristique['id_characteristic'] . "' tabindex='-1' role='dialog'>
      <div class='modal-dialog' role='document'>
        <div class='modal-content'>
          <div class='modal-header'>
            <h5 class='modal-title'>Supprimer une caractéristique</h5>
            <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
              <span aria-hidden='true'>&times;</span>
            </button>
          </div>
          <div class='modal-body'>
            <p>Voulez-vous vraiment supprimer " . $caracteristique['label'] . " ?</p>
          </div>
          <div class='modal-footer'>
            <a href='characteristic_delete.php?id=" . $caracteristique['id_characteristic'] . "' class='btn btn-danger'>Supprimer</a>
            <button type='button' class='btn btn-secondary' data-dismiss='modal'>Annuler</button>
          </div>
        </div>
      </div>
    </div>
    ";
                                                    ?>

                                                <?php endforeach; ?>

                                            </tbody>

                                        </table>

                                    </div>

                                </div>

                            </div>

                        </div>
                        <!-- /.container-fluid -->

                    </div>
                    <!-- End Main Content -->

                    <!-- Footer -->
                    <footer class=" sticky-footer bg-white">

                        <div class="container my-auto">

                            <div class="copyright text-center my-auto">

                                <span>
                                    Copyright &copy; Your Website 2020
                                </span>

                            </div>

                        </div>

                    </footer>
                    <!-- End Footer -->

                </div>
                <!-- End Content Wrapper -->

            </div>
            <!-- End Page Wrapper -->

            <!-- Scroll to Top -->
            <a class="scroll-to-top rounded" href="#page-top">

                <i class="fas fa-angle-up"></i>

            </a>

            <!-- Bootstrap core JavaScript -->
            <script src="vendor/jquery/jquery.min.js"></script>

            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript -->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts -->
            <script src="js/sb-admin-2.min.js"></script>

            <!-- DataTables -->
            <script src="vendor/datatables/jquery.dataTables.min.js"></script>

            <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

            <!-- DataTables Demo -->
            <script src="js/demo/datatables-demo.js"></script>

</body>

</html>