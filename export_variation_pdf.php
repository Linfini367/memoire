<?php
require('fpdf/fpdf.php');
require 'db.php';

$mois1 = isset($_GET['mois1']) ? $_GET['mois1'] . '-01' : date('Y-m-01');
$mois2 = isset($_GET['mois2']) ? $_GET['mois2'] . '-01' : date('Y-m-01');
$marcheFiltre = isset($_GET['marcheFiltre']) ? $_GET['marcheFiltre'] : '';

$produits = $pdo->query("SELECT IdProduit, NomProduit FROM produit")->fetchAll();
$allMarches = $pdo->query("SELECT IdMarche, NomMarche FROM marche")->fetchAll();

if ($marcheFiltre && $marcheFiltre != 'all') {
    $marches = $pdo->prepare("SELECT IdMarche, NomMarche FROM marche WHERE IdMarche = ?");
    $marches->execute([$marcheFiltre]);
    $marches = $marches->fetchAll();
} else {
    $marches = $allMarches;
}

// --- Génération du graphique secteur pour Nyawera ---
require_once("pChart2.1.4/class/pData.class.php");
require_once("pChart2.1.4/class/pDraw.class.php");
require_once("pChart2.1.4/class/pPie.class.php");
require_once("pChart2.1.4/class/pImage.class.php");

// Récupérer les données pour Nyawera
$nyaweraId = null;
foreach ($allMarches as $m) {
    if (stripos($m['NomMarche'], 'nyawera') !== false) $nyaweraId = $m['IdMarche'];
}
$nyaweraLabels = [];
$nyaweraValues = [];
if ($nyaweraId) {
    foreach ($produits as $prod) {
        $stmt = $pdo->prepare("SELECT Prix FROM releve_mensuel WHERE IdProduit = ? AND IdMarche = ? AND Mois = ?");
        $stmt->execute([$prod['IdProduit'], $nyaweraId, $mois2]);
        $prix = $stmt->fetchColumn();
        $nyaweraLabels[] = $prod['NomProduit'];
        $nyaweraValues[] = $prix ? floatval($prix) : 0;
    }
    // Création du graphique secteur
    $pieData = new pData();
    $pieData->addPoints($nyaweraValues, "ScoreA");
    $pieData->addPoints($nyaweraLabels, "Labels");
    $pieData->setAbscissa("Labels");
    $pieImage = new pImage(400,300,$pieData);
    $pieChart = new pPie($pieImage, $pieData);
    $pieChart->draw3DPie(200,150,array("Radius"=>100,"DrawLabels"=>TRUE,"LabelStacked"=>TRUE,"Border"=>TRUE));
    $pieImage->Render("nyawera.png");
}

// --- Génération du graphique histogramme pour Kadutu ---
$kadutuId = null;
foreach ($allMarches as $m) {
    if (stripos($m['NomMarche'], 'kadutu') !== false) $kadutuId = $m['IdMarche'];
}
$kadutuLabels = [];
$kadutuValues = [];
if ($kadutuId) {
    foreach ($produits as $prod) {
        $stmt = $pdo->prepare("SELECT Prix FROM releve_mensuel WHERE IdProduit = ? AND IdMarche = ? AND Mois = ?");
        $stmt->execute([$prod['IdProduit'], $kadutuId, $mois2]);
        $prix = $stmt->fetchColumn();
        $kadutuLabels[] = $prod['NomProduit'];
        $kadutuValues[] = $prix ? floatval($prix) : 0;
    }
    // Création du graphique histogramme
    $barData = new pData();
    $barData->addPoints($kadutuValues, "Prix");
    $barData->setAxisName(0,"Prix");
    $barData->addPoints($kadutuLabels, "Labels");
    $barData->setSerieDescription("Labels","Produit");
    $barData->setAbscissa("Labels");
    $barImage = new pImage(400,300,$barData);
    $barImage->setFontProperties(array("FontName"=>"pChart2.1.4/fonts/Forgotte.ttf","FontSize"=>10));
    $barImage->setGraphArea(60,40,370,250);
    $barImage->drawScale();
    $barImage->drawBarChart();
    $barImage->Render("kadutu.png");
}

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial','B',14);
$pdf->Cell(0,10,'Tableau de variation des prix',0,1,'C');
$pdf->SetFont('Arial','B',10);
$pdf->Cell(10,10,'N°',1);
$pdf->Cell(40,10,'Produit',1);
$pdf->Cell(20,10,'Unite',1);
$pdf->Cell(25,10,date('F Y', strtotime($mois1)),1);
$pdf->Cell(25,10,date('F Y', strtotime($mois2)),1);
$pdf->Cell(30,10,'Variation Abs.',1);
$pdf->Cell(30,10,'Variation Rel. (%)',1);
$pdf->Ln();

$pdf->SetFont('Arial','',9);
$i = 1;
foreach ($marches as $marche) {
    $pdf->SetFont('Arial','B',10);
    $pdf->Cell(180,8,'Marché : ' . $marche['NomMarche'],1);
    $pdf->Ln();
    $pdf->SetFont('Arial','',9);
    foreach ($produits as $prod) {
        $unite = $pdo->prepare("SELECT Unite FROM prix WHERE IdProduit = ? AND IdMarche = ? ORDER BY DateReleve DESC LIMIT 1");
        $unite->execute([$prod['IdProduit'], $marche['IdMarche']]);
        $unite = $unite->fetchColumn();

        $stmt1 = $pdo->prepare("SELECT Prix FROM releve_mensuel WHERE IdProduit = ? AND IdMarche = ? AND Mois = ?");
        $stmt1->execute([$prod['IdProduit'], $marche['IdMarche'], $mois1]);
        $prix1 = $stmt1->fetchColumn();
        if ($prix1 === false) $prix1 = 0;

        $stmt2 = $pdo->prepare("SELECT Prix FROM releve_mensuel WHERE IdProduit = ? AND IdMarche = ? AND Mois = ?");
        $stmt2->execute([$prod['IdProduit'], $marche['IdMarche'], $mois2]);
        $prix2 = $stmt2->fetchColumn();
        if ($prix2 === false) $prix2 = 0;

        $variationAbs = $prix2 - $prix1;
        $variationRel = ($prix1 != 0) ? round(($variationAbs / $prix1) * 100, 2) : 0;

        $pdf->Cell(10,8,$i,1);
        $pdf->Cell(40,8,$prod['NomProduit'],1);
        $pdf->Cell(20,8,$unite,1);
        $pdf->Cell(25,8,number_format($prix1, 0, ',', ' '),1);
        $pdf->Cell(25,8,number_format($prix2, 0, ',', ' '),1);
        $pdf->Cell(30,8,number_format($variationAbs, 0, ',', ' '),1);
        $pdf->Cell(30,8,number_format($variationRel, 2, ',', ' '),1);
        $pdf->Ln();
        $i++;
    }
}
$pdf->Ln(10);

// --- Ajout des graphiques dans le PDF ---
if (file_exists("nyawera.png")) {
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,10,'Diagramme secteur - Nyawera',0,1,'C');
    $pdf->Image("nyawera.png", 30, $pdf->GetY(), 70, 50);
    $pdf->Ln(55);
}
if (file_exists("kadutu.png")) {
    $pdf->SetFont('Arial','B',12);
    $pdf->Cell(0,10,'Histogramme - Kadutu',0,1,'C');
    $pdf->Image("kadutu.png", 30, $pdf->GetY(), 70, 50);
    $pdf->Ln(55);
}

$pdf->Output();
?>