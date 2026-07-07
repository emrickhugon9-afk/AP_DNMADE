<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    include 'pdo_config.php';
    ?>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

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

        <style>
            body {
                background-color: #e9ecef;
                font-family: Arial, sans-serif;
                color: #000;
            }

            /* Format page A4 pour l'écran */
            .a4-sheet {
                max-width: 21cm;
                min-height: 29.7cm;
                margin: 2cm auto;
                padding: 2cm;
                background: white;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
                position: relative;
            }

            /* Style des champs remplissables façon "papier" */
            .paper-input {
                flex-grow: 1;
                border: none;
                border-bottom: 2px dotted #000;
                background-color: transparent;
                margin-left: 10px;
                outline: none;
                font-family: inherit;
                font-size: 1rem;
                color: #004085;
                /* Couleur bleu "stylo" */
                padding: 0 5px;
            }

            .paper-input:focus {
                border-bottom: 2px solid #0d6efd;
                background-color: rgba(13, 110, 253, 0.05);
            }

            /* Style pour les zones de texte multi-lignes sans scrollbar ni poignée */
            .paper-textarea {
                width: 100%;
                border: none;
                background-color: transparent;
                line-height: 2rem;
                /* Génère les lignes horizontales pointillées en arrière-plan */
                background-image: repeating-linear-gradient(transparent, transparent 1.9rem, #000 1.9rem, #000 2rem);
                outline: none;
                color: #004085;
                /* Couleur bleu "stylo" */
                min-height: 6rem;
                margin-top: 10px;

                /* Sécurité visuelle : cache la poignée et les barres de défilement */
                resize: none;
                overflow: hidden;
            }

            .paper-textarea:focus {
                background-image: repeating-linear-gradient(transparent, transparent 1.9rem, #0d6efd 1.9rem, #0d6efd 2rem);
            }

            /* Titres de section */
            .section-title {
                text-decoration: underline;
                font-weight: bold;
                font-size: 1.1rem;
                margin-top: 1.5rem;
                margin-bottom: 1rem;
            }

            /* Identité visuelle haut de page */
            .logo-text-small {
                font-size: 0.85rem;
                font-weight: bold;
            }

            .logo-text-large {
                font-size: 2.2rem;
                font-weight: 900;
                line-height: 1;
                letter-spacing: -1px;
            }

            .logo-text-medium {
                font-size: 1.1rem;
                font-weight: bold;
            }

            .radio-label {
                margin-left: 5px;
                margin-right: 15px;
                cursor: pointer;
            }

            /* Gestion de l'impression */
            @media print {

                /* Cache les boutons d'action sur le papier */
                .no-print {
                    display: none !important;
                }

                /* Force l'affichage propre sans les grisés du navigateur */
                body {
                    background-color: white !important;
                }

                .a4-sheet {
                    margin: 0 !important;
                    padding: 0 !important;
                    box-shadow: none !important;
                    max-width: 100% !important;
                    min-height: auto !important;
                }
            }
        </style>
        </head>

        <body>

            <div class="a4-sheet">

                <form action="#" method="POST">

                    <div class="row mb-4 align-items-center">
                        <div class="col-7">
                            <div class="logo-text-small">Groupes scolaires [cite: 1]</div>
                            <div class="logo-text-large">Mont Roland [cite: 3]</div>
                            <div class="logo-text-medium">La Salle - Dolle [cite: 5]</div>
                        </div>
                        <div class="col-5 text-end">
                            <h4 class="fw-bold mb-0">Costumerie [cite: 2]</h4>
                            <div style="font-size: 0.9rem;">Stock costume du lycée Pasteur Mont Roland [cite: 4]</div>
                        </div>
                    </div>

                    <h2 class="text-center fw-bold mb-4" style="text-decoration: underline;">Fiche d'emprunt [cite: 6]</h2>

                    <div class="section-title">Contact emprunteur: [cite: 7]</div>

                    <div class="d-flex mb-3 align-items-end">
                        <label for="nom">Nom :</label>
                        <input type="text" id="nom" name="nom" class="paper-input me-4" required>

                        <label for="prenom">Prénom :</label>
                        <input type="text" id="prenom" name="prenom" class="paper-input" required>
                    </div>

                    <div class="d-flex mb-3 align-items-end">
                        <label for="classe">Classe: [cite: 9]</label>
                        <input type="text" id="classe" name="classe" class="paper-input">
                    </div>

                    <div class="d-flex mb-3 align-items-end">
                        <label for="telephone">Numéro de téléphone : [cite: 10]</label>
                        <input type="tel" id="telephone" name="telephone" class="paper-input">
                    </div>

                    <div class="d-flex mb-3 align-items-end">
                        <label for="mail">Mail: [cite: 11]</label>
                        <input type="email" id="mail" name="mail" class="paper-input" required>
                    </div>

                    <br>

                    <div class="section-title">Identification du costume: [cite: 12]</div>

                    <div class="d-flex mb-3 align-items-end">
                        <label for="nom_costume">Nom du costume: [cite: 13]</label>
                        <input type="text" id="nom_costume" name="nom_costume" class="paper-input" required>
                    </div>

                    <div class="d-flex mb-3 align-items-end">
                        <label for="num_inventaire">Numéro d'inventaire : [cite: 14]</label>
                        <input type="text" id="num_inventaire" name="num_inventaire" class="paper-input">
                    </div>

                    <div class="d-flex mb-3 align-items-end">
                        <label for="epoque">Epoque : [cite: 15]</label>
                        <input type="text" id="epoque" name="epoque" class="paper-input">
                    </div>

                    <br>

                    <div class="row mb-3">
                        <div class="col-6 d-flex align-items-end">
                            <label for="date_emprunt">Date d'emprunt: [cite: 16]</label>
                            <input type="date" id="date_emprunt" name="date_emprunt" class="paper-input">
                        </div>
                        <div class="col-6 d-flex align-items-end">
                            <label for="date_retour">Date de retour: [cite: 17]</label>
                            <input type="date" id="date_retour" name="date_retour" class="paper-input">
                        </div>
                    </div>

                    <div class="d-flex mb-4 align-items-end">
                        <label for="caution">Montant chèque de cossion: [cite: 19]</label>
                        <input type="text" id="caution" name="caution" class="paper-input">
                    </div>

                    <div class="mb-5 d-flex align-items-end">
                        <label for="signature">Signature de l'emprunteur : [cite: 18]</label>
                        <input type="text" id="signature" name="signature" class="paper-input" placeholder="Tapez votre nom pour signature">
                    </div>

                    <div class="section-title">Constat d'état [cite: 20]</div>

                    <div class="row mt-3">
                        <div class="col-6 pe-4">
                            <div class="fw-bold mb-2">Départ du costume : [cite: 21]</div>
                            <div class="mb-2">état général : [cite: 22]</div>
                            <div class="d-flex flex-column mb-3">
                                <div>
                                    <input type="radio" id="depBon" name="etat_depart" value="bon_etat">
                                    <label for="depBon" class="radio-label">bon état [cite: 23]</label>
                                </div>
                                <div>
                                    <input type="radio" id="depUse" name="etat_depart" value="use">
                                    <label for="depUse" class="radio-label">usé [cite: 24]</label>
                                </div>
                                <div>
                                    <input type="radio" id="depMauv" name="etat_depart" value="mauvais_etat">
                                    <label for="depMauv" class="radio-label">mauvais état [cite: 31]</label>
                                </div>
                            </div>
                            <div class="mb-2">Observations complémentaires : [cite: 30]</div>
                            <textarea name="obs_depart" class="paper-textarea"></textarea>
                        </div>

                        <div class="col-6 border-start ps-4">
                            <div class="fw-bold mb-2">Retour du costume : [cite: 25]</div>
                            <div class="mb-2">état général :</div>
                            <div class="d-flex flex-column mb-3">
                                <div>
                                    <input type="radio" id="retBon" name="etat_retour" value="bon_etat">
                                    <label for="retBon" class="radio-label">bon état [cite: 26]</label>
                                </div>
                                <div>
                                    <input type="radio" id="retUse" name="etat_retour" value="use">
                                    <label for="retUse" class="radio-label">usé [cite: 28]</label>
                                </div>
                                <div>
                                    <input type="radio" id="retMauv" name="etat_retour" value="mauvais_etat">
                                    <label for="retMauv" class="radio-label">mauvais état [cite: 29]</label>
                                </div>
                            </div>
                            <div class="mb-2">Observations complémentaires: [cite: 32]</div>
                            <textarea name="obs_retour" class="paper-textarea"></textarea>
                        </div>
                    </div>

                    <div class="text-center mt-5 no-print d-flex justify-content-center gap-3">
                        <button type="button" class="btn btn-secondary btn-lg px-4 shadow-sm" onclick="window.print()">
                            🖨️ Imprimer la fiche
                        </button>
                        <button type="submit" class="btn btn-primary btn-lg px-5 shadow-sm">
                            Envoyer le formulaire
                        </button>
                    </div>

                </form>
            </div>


            <!-- Begin Page Content -->


            <div class="container-fluid">


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
        <script src='js/user.js' defer></script>

</html>