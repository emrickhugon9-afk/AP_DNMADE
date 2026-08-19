<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require 'pdo_config.php';

if (!isset($_GET['id_loan'])) {
    die("ID d'emprunt manquant.");
}

// 1. Récupération des données de l'emprunt
$stmt = $db->prepare("
    SELECT 
        l.*, 
        c.name AS creation_name, 
        c.inventory_number,
        u.first_name, 
        u.last_name,
        u.email,
        u.class,
        u.phone
    FROM LOANS l
    INNER JOIN CREATIONS c ON l.id_creation = c.id_creation
    INNER JOIN USERS u ON l.id_user = u.id_user
    WHERE l.id_loan = :id_loan
");
$stmt->execute(['id_loan' => $_GET['id_loan']]);
$emprunt = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$emprunt) {
    die("Emprunt introuvable.");
}

// 2. Récupération de l'époque
$epoqueStmt = $db->prepare("
    SELECT ch.label 
    FROM CHARACTERISTICS ch 
    INNER JOIN OWNS o ON ch.id_characteristic = o.id_characteristic 
    INNER JOIN CRITERIA cr ON ch.id_criteria = cr.id_criteria 
    WHERE o.id_creation = :id_creation AND cr.criteria IN ('epoque', 'Epoque', 'EPOQUE')
");
$epoqueStmt->execute(['id_creation' => $emprunt['id_creation']]);
$epoque = $epoqueStmt->fetch(PDO::FETCH_ASSOC);

// Fonction utilitaire pour générer la case cochée (X) ou vide
function getCheckbox($etatBDD, $valeurCible)
{
    return (mb_strtolower($etatBDD, 'UTF-8') === $valeurCible) ? 'X' : '';
}

$etatDepart = $emprunt['condition_start'] ?? '';
$etatRetour = $emprunt['condition_return'] ?? '';
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Fiche d'emprunt - <?= htmlspecialchars($emprunt['inventory_number']) ?></title>
    <style>
        /* === PARAMÉTRAGE STRICT POUR L'IMPRESSION A4 SUR UNE SEULE PAGE === */
        @page {
            size: A4;
            margin: 0;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
            color: #000;
        }

        .page-a4 {
            width: 210mm;
            /* La hauteur est légèrement réduite pour garantir que ça rentre sans créer de page blanche à la fin */
            height: 296mm;
            padding: 10mm 15mm;
            margin: 10mm auto;
            background: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            box-sizing: border-box;
            /* Empêche le contenu de déborder */
            overflow: hidden;
            page-break-after: avoid;
        }

        /* Styles spécifiques appliqués UNIQUEMENT lors du CTRL+P */
        @media print {
            body {
                background-color: white;
            }

            .page-a4 {
                margin: 0;
                box-shadow: none;
                border: none;
                /* Réduction des marges internes à l'impression pour gagner de la place */
                padding: 10mm 15mm;
                height: 100vh;
                /* Force la hauteur à correspondre exactement à 1 page */
                page-break-inside: avoid;
                /* Interdit de couper le bloc en deux pages */
            }
        }

        /* === TYPOGRAPHIE ET ESPACEMENTS === */
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            /* Légèrement réduit */
        }

        .header-text {
            text-align: right;
            font-size: 11pt;
            line-height: 1.8;
            margin-top: 20px;
        }

        .title-box {
            border: 3px solid black;
            text-align: center;
            font-size: 22pt;
            font-weight: bold;
            padding: 5px 0;
            /* Légèrement réduit */
            margin-bottom: 25px;
            /* Légèrement réduit */
        }

        /* Mise en page en colonnes */
        .grid-2 {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            /* Légèrement réduit */
        }

        .col {
            width: 48%;
        }

        /* Lignes de texte */
        .bold-label {
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 20px;
            /* Légèrement réduit */
        }

        .info-line {
            font-size: 11pt;
            margin-bottom: 20px;
            /* Légèrement réduit */
        }

        /* Dates resserrées */
        .date-line {
            font-weight: bold;
            font-size: 11pt;
            margin-bottom: 5px;
        }

        /* Encadré Constat d'état */
        .constat-box {
            display: flex;
            min-height: 250px;
            /* Légèrement réduit */
            margin-top: 15px;
        }

        .constat-col {
            flex: 1;
        }

        .constat-col:first-child {
            padding-right: 15px;
        }

        .constat-col:last-child {
            border-left: 2px solid black;
            padding-left: 25px;
        }

        .checkbox-container {
            margin-left: 25px;
            margin-top: 20px;
            margin-bottom: 30px;
            /* Légèrement réduit */
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            margin-bottom: 12px;
            /* Légèrement réduit */
        }

        .custom-square {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 1.5px solid black;
            margin-right: 20px;
            text-align: center;
            line-height: 20px;
            font-size: 16px;
            font-weight: bold;
        }

        .checkbox-label {
            font-size: 11pt;
            font-weight: bold;
        }
    </style>
</head>


<body>

    <div class="page-a4">

        <!-- EN-TÊTE -->
        <div class="header">
            <img src="img/logo_pasteur.png" alt="Mont Roland La Salle - Dolle" style="height: 110px;">
            <div class="header-text">
                Costumerie<br><br>
                Stock costume du lycée Pasteur Mont Roland
            </div>
        </div>

        <!-- TITRE 1 -->
        <div class="title-box">Fiche d'emprunt</div>

        <!-- SECTION 1 : CONTACT & ID -->
        <div class="grid-2">
            <div class="col">
                <div class="bold-label">Contact emprunteur :</div>
                <div class="info-line">Nom Prénom : <?= htmlspecialchars($emprunt['first_name'] . ' ' . $emprunt['last_name']) ?></div>
                <div class="info-line">Classe : <?= htmlspecialchars($emprunt['class'] ?? '') ?></div>
                <div class="info-line">Numéro de téléphone : <?= htmlspecialchars($emprunt['phone'] ?? '') ?></div>
                <div class="info-line">Mail : <?= htmlspecialchars($emprunt['email'] ?? '') ?></div>
            </div>

            <div class="col">
                <div class="bold-label">Identification du costume :</div>
                <div class="info-line">Nom du costume : <?= htmlspecialchars($emprunt['creation_name']) ?></div>
                <div class="info-line">Numéro d'inventaire : <?= htmlspecialchars($emprunt['inventory_number']) ?></div>
                <div class="info-line">Epoque : <?= htmlspecialchars($epoque['label'] ?? '') ?></div>
            </div>
        </div>

        <!-- SECTION 2 : DATES & SIGNATURE -->
        <div class="grid-2">
            <div class="col">
                <div class="date-line">Date d'emprunt : <?= date('d/m/Y', strtotime($emprunt['loan_date'])) ?></div>
                <div class="date-line">Date de retour : <?= date('d/m/Y', strtotime($emprunt['return_date'])) ?></div>

                <div class="info-line" style="margin-top: 35px;">
                    Montant chèque de cossion : <?= !empty($emprunt['deposit_amount']) ? htmlspecialchars($emprunt['deposit_amount']) . ' €' : '' ?>
                </div>
            </div>

            <div class="col">
                <div class="bold-label">Signature de l'emprunteur : </div>
                <div class="info-line"><?php echo substr($emprunt['first_name'] ?? '', 0, 1) . '. ' . ($emprunt['last_name'] ?? ''); ?></div>
            </div>
        </div>

        <!-- TITRE 2 -->
        <div class="title-box" style="margin-top: 5px;">Constat d'état</div>

        <!-- SECTION 3 : ÉTATS (AVEC LIGNE VERTICALE) -->
        <div class="constat-box">

            <!-- Colonne Départ -->
            <div class="constat-col">
                <div class="bold-label" style="margin-bottom: 12px;">Départ du costume :</div>
                <div class="bold-label">état général :</div>

                <div class="checkbox-container">
                    <div class="checkbox-row">
                        <span class="custom-square"><?= getCheckbox($etatDepart, 'bon état') ?></span>
                        <span class="checkbox-label">bon état</span>
                    </div>
                    <div class="checkbox-row">
                        <span class="custom-square"><?= getCheckbox($etatDepart, 'usé') ?></span>
                        <span class="checkbox-label">usé</span>
                    </div>
                    <div class="checkbox-row">
                        <span class="custom-square"><?= getCheckbox($etatDepart, 'mauvais état') ?></span>
                        <span class="checkbox-label">mauvais état</span>
                    </div>
                </div>

                <div class="bold-label">Observations complémentaires : <span style="font-weight: normal;"><?= htmlspecialchars($emprunt['observation_start'] ?? '') ?></span></div>
            </div>

            <!-- Colonne Retour -->
            <div class="constat-col">
                <div class="bold-label" style="margin-bottom: 12px;">Retour du costume :</div>
                <div class="bold-label">état général :</div>

                <div class="checkbox-container">
                    <div class="checkbox-row">
                        <span class="custom-square"><?= getCheckbox($etatRetour, 'bon état') ?></span>
                        <span class="checkbox-label">bon état</span>
                    </div>
                    <div class="checkbox-row">
                        <span class="custom-square"><?= getCheckbox($etatRetour, 'usé') ?></span>
                        <span class="checkbox-label">usé</span>
                    </div>
                    <div class="checkbox-row">
                        <span class="custom-square"><?= getCheckbox($etatRetour, 'mauvais état') ?></span>
                        <span class="checkbox-label">mauvais état</span>
                    </div>
                </div>

                <div class="bold-label">Observations complémentaires : <span style="font-weight: normal;"><?= htmlspecialchars($emprunt['observation_return'] ?? '') ?></span></div>
            </div>

        </div>

    </div>
</body>

</html>