<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require 'pdo_config.php';

try {
    // Requête corrigée avec les VRAIS noms de colonnes de votre table LOANS
    $stmt = $db->query("
        SELECT 
            l.id_loan, 
            l.loan_date, 
            l.return_date, 
            l.deposit_amount, 
            l.actual_return_date,
            l.condition_start, 
            l.observation_start,
            l.condition_return,
            l.observation_return,
            c.id_creation, 
            c.name AS creation_name, 
            c.inventory_number,
            u.first_name, 
            u.last_name,
            i.path AS image
        FROM LOANS l
        INNER JOIN CREATIONS c ON l.id_creation = c.id_creation
        INNER JOIN USERS u ON l.id_user = u.id_user
        LEFT JOIN IMAGES i ON c.id_creation = i.id_creation
        GROUP BY l.id_loan
        ORDER BY l.return_date ASC
    ");

    $emprunts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("<div style='color:red; padding:20px; font-family:sans-serif;'><h3>Erreur SQL :</h3><p>" . $e->getMessage() . "</p></div>");
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Récapitulatif des Emprunts - SB Admin 2</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/style_param.css" rel="stylesheet">

    <style>
        .img-thumbnail-loan {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border-radius: 8px;
        }

        .table-align-middle td {
            vertical-align: middle !important;
        }
    </style>
</head>

<body id="page-top">
    <div id="wrapper">

        <!-- Sidebar -->
        <?php include 'sidebar.php'; ?>

        <!-- End of Sidebar -->

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                    <h4 class="m-0 font-weight-bold text-primary ml-3"></h4>
                </nav>

                <!-- Page Content -->
                <div class="container-fluid">


                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Liste des emprunts</h6>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-align-middle" id="dataTable" width="100%" cellspacing="0">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>Pièce</th>
                                            <th>Emprunteur</th>
                                            <th>Dates</th>
                                            <th>Caution</th>
                                            <th>État Départ</th>
                                            <th>Observations</th>
                                            <th>État Retour</th>
                                            <th>Observations</th>
                                            <th>Statut</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($emprunts as $emprunt):
                                            // Comparaison des dates
                                            $dateRetourPrevu = new DateTime($emprunt['return_date']);
                                            $dateRetourReelle = new DateTime($emprunt['actual_return_date']);
                                            $aujourdhui = new DateTime();
                                            $aujourdhui->setTime(0, 0, 0);

                                            $diff = $aujourdhui->diff($dateRetourPrevu);

                                            $badgeClass = "badge-success";
                                            $badgeText = "En cours ";

                                            if ($dateRetourReelle !== NULL && $dateRetourReelle !== '0000-00-00 00:00:00') {
                                                $badgeClass = "badge-primary";
                                                $badgeText = "Terminé";
                                            } elseif ($dateRetourPrevu < $aujourdhui && ($dateRetourReelle == NULL || $dateRetourReelle == '0000-00-00 00:00:00')) {
                                                $badgeClass = "badge-danger";
                                                $badgeText = "En retard";
                                            }
                                        ?>
                                            <tr>
                                                <td>
                                                    <span class="font-weight-bold"><?= htmlspecialchars($emprunt['creation_name']) ?></span><br>
                                                    <small class="text-muted"><i class="fas fa-tag"></i> <?= htmlspecialchars($emprunt['inventory_number']) ?></small>
                            </div>
                        </div>
                        </td>
                        <td class="font-weight-bold text-dark">
                            <i class="fas fa-user-circle text-gray-500 mr-1"></i>
                            <?= htmlspecialchars(($emprunt['first_name'] ?? '') . ' ' . ($emprunt['last_name'] ?? '')) ?>
                        </td>
                        <td>
                            <small class="d-block"><b>Début:</b> <?= date('d/m/Y', strtotime($emprunt['loan_date'])) ?></small>
                            <small class="d-block text-primary"><b>Prévu le:</b> <?= date('d/m/Y', strtotime($emprunt['return_date'])) ?></small>
                        </td>
                        <td class="text-center font-weight-bold">
                            <?= !empty($emprunt['deposit_amount']) ? htmlspecialchars($emprunt['deposit_amount']) . ' €' : '<span class="text-muted">-</span>' ?>
                        </td>
                        <td>
                            <?php
                                            $etat = mb_strtolower($emprunt['condition_start'] ?? '', 'UTF-8');
                                            if ($etat == 'bon état') echo '<span class="badge badge-success"><i class="fas fa-check"></i> Bon état</span>';
                                            elseif ($etat == 'usé') echo '<span class="badge badge-warning text-dark"><i class="fas fa-exclamation-triangle"></i> Usé</span>';
                                            elseif ($etat == 'mauvais état') echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Mauvais état</span>';
                                            else echo htmlspecialchars($emprunt['condition_start'] ?? '-');
                            ?>
                        </td>
                        <td>
                            <small><?= !empty($emprunt['observation_start']) ? htmlspecialchars($emprunt['observation_start']) : '<span class="text-muted">-</span>' ?></small>
                        </td>
                        <td>
                            <?php
                                            $etat = mb_strtolower($emprunt['condition_return'] ?? '', 'UTF-8');
                                            if ($etat == 'bon état') echo '<span class="badge badge-success"><i class="fas fa-check"></i> Bon état</span>';
                                            elseif ($etat == 'usé') echo '<span class="badge badge-warning text-dark"><i class="fas fa-exclamation-triangle"></i> Usé</span>';
                                            elseif ($etat == 'mauvais état') echo '<span class="badge badge-danger"><i class="fas fa-times"></i> Mauvais état</span>';
                                            else echo htmlspecialchars($emprunt['condition_return'] ?? '-');
                            ?>
                        </td>
                        <td>
                            <small><?= !empty($emprunt['observation_return']) ? htmlspecialchars($emprunt['observation_return']) : '<span class="text-muted">-</span>' ?></small>
                        </td>
                        <td class="text-center">
                            <span class="badge <?= $badgeClass ?>"><?= $badgeText ?></span>
                        <td class="text-center">
                            <!-- Bouton pour générer le PDF -->
                            <a href="fiche_pdf.php?id_loan=<?= $emprunt['id_loan'] ?>" target="_blank" class="btn btn-sm btn-outline-danger" title="Exporter la fiche en PDF">
                                <i class="fas fa-file-pdf"></i> Fiche PDF
                            </a>
                        </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                    </table>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <footer class="sticky-footer bg-white">
        <div class="container my-auto">
            <div class="copyright text-center my-auto">
                <span>Copyright &copy; Your Website 2026</span>
            </div>
        </div>
    </footer>
    </div>
    </div>

    <a class="scroll-to-top rounded" href="#page-top"><i class="fas fa-angle-up"></i></a>


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

</body>

</html>