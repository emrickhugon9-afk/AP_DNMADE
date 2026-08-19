<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Dashboard</title>

    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/style_params.css" rel="stylesheet">

</head>

<body id="page-top">
    <?php
    include 'pdo_config.php';
    try {

        $requete = $db->prepare('SELECT COUNT(id_creation) FROM CREATIONS LIMIT 1');
        $requete->execute();
        $creations = $requete->fetchAll();

        $requete = $db->prepare('SELECT DISTINCT COUNT(id_creation), storage_location FROM CREATIONS GROUP BY storage_location');
        $requete->execute();
        $creations_location = $requete->fetchAll();

        $requete = $db->prepare('SELECT COUNT(id_loan) FROM LOANS LIMIT 1');
        $requete->execute();
        $loans = $requete->fetchAll();

        $requete = $db->prepare('SELECT COUNT(id_user) FROM USERS LIMIT 1');
        $requete->execute();
        $users = $requete->fetchAll();

        $requete = $db->prepare("SELECT category, COUNT(*) AS count FROM CATEGORIES GROUP BY category ORDER BY category ASC");
        $requete->execute();
        $category = $requete->fetchAll(PDO::FETCH_ASSOC);

        $categories = [];
        $counts = [];

        foreach ($category as $row) {
            $categories[] = $row['category'];
            $counts[] = $row['count'];
        }
    } catch (PDOException $e) {
        $Error = "Erreur : " . $e->getMessage();
    } ?>

    <div id="wrapper">

        <?php include 'sidebar.php'; ?>
        <div id="content-wrapper" class="d-flex flex-column">

            <div id="content">

                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>
                </nav>

                <div class="container-fluid">

                    <div class="row align-items-center justify-content-center mb-4">
                        <div class="row no-gutters align-items-center mr-4">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-4">
                                    <button
                                        class="btn-important"
                                        id="btn-inventaire"
                                        style="padding: 15px 35px; font-size: 15px; min-width: 250px;">
                                        Accéder à l'inventaire
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="row no-gutters align-items-center">
                            <div class="col">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-4">
                                    <button
                                        class="btn-important"
                                        id="btn-admin"
                                        style="padding: 15px 35px; font-size: 15px; min-width: 250px;">
                                        Accéder à l'interface administrateur
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row justify-content-center">

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-pink shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-pink text-uppercase mb-1">
                                                Creations</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $creations[0][0]; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-palette fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-pink shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-pink text-uppercase mb-1">
                                                Emprunts</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $loans[0][0]; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-book fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-pink shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-pink text-uppercase mb-1">
                                                Utilisateurs</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $users[0][0]; ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <br>

                    <div class="row">

                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-primary">
                                        Tableau des créations par lieu de stockage
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                            <thead>
                                                <tr>
                                                    <th class="text-center">Lieu</th>
                                                    <th class="text-center">Nombre de créations</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach ($creations_location as $creation) {
                                                    echo "<tr>";
                                                    echo "<td class='text-center'>" . $creation['storage_location'] . "</td>";
                                                    echo "<td class='text-center'>" . $creation['COUNT(id_creation)'] . "</td>";
                                                    echo "</tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-6 col-lg-6">
                            <div class="card shadow mb-4">
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Catégories</h6>
                                </div>
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <canvas id="myPieChart"></canvas>
                                    </div>
                                    <div class="mt-4 text-center small">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

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

    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <script src="js/sb-admin-2.min.js"></script>

    <script src="vendor/chart.js/Chart.min.js"></script>

    <script>
        const categories = <?= json_encode($categories) ?>;
        const counts = <?= json_encode($counts) ?>;

        Chart.defaults.global.defaultFontFamily = 'Nunito,-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
        Chart.defaults.global.defaultFontColor = '#858796';

        var ctx = document.getElementById("myPieChart");

        new Chart(ctx, {
            type: "doughnut",
            data: {
                labels: categories,
                datasets: [{
                    data: counts,
                    backgroundColor: [
                        '#4e73df',
                        '#1cc88a',
                        '#36b9cc',
                        '#f6c23e',
                        '#e74a3b',
                        '#858796',
                        '#5a5c69',
                        '#fd7e14',
                        '#20c997',
                        '#6f42c1'
                    ]
                }]
            },
            options: {
                maintainAspectRatio: false,
                cutoutPercentage: 70,
                legend: {
                    display: true,
                    position: 'bottom'
                }
            }
        });
    </script>

</body>

</html>