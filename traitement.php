<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    // pied de page
    function Footer()
    {
        // Positionnement à 1,5 cm du bas
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);// Police Arial italique 8
        // texte pied de page
        $this->Cell(0, 10, 'Mohamed BENASR ', 0, 0, 'C');
    }
}

// suppression des sorties prematurées
ob_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // récupération des données avant verification
    function getPostData($key)
    {
        return isset($_POST[$key]) ? mb_convert_encoding($_POST[$key], 'UTF-8'): '';
    }

    $name = getPostData('name');
    $username = getPostData('username');
    $position = getPostData('position');
    $experience = getPostData('experience');
    $feedback = getPostData('feedback');
    $strenghts = getPostData('strenghts');
    $weaknesses = getPostData('weaknesses');
    $motivation = getPostData('motivation');
    $challenges = getPostData('challenges');
    $future = getPostData('future');
    $dateDuJour = date('d/m/Y');

    if(isset($_POST['action']) && $_POST['action'] == 'pdf'){

        // création d'un objet PDF personnalisé
        $pdf = new PDF();
        $pdf->AddPage();

        // verification et ajout de l'image
        if (file_exists('image.jpg')) {
            $pdf->Image('image.jpg', 160, 10, 30); // X=160, Y=10, largeur=30
        }

        // definition de la police
        $pdf->SetFont('Arial', '', 12);
        $pdf->Cell(200, 10, "Récapitulatif de l'entretien", 0, 1, 'C');
        $pdf->Ln(10);

        // ajout des données
        $pdf->Cell(40, 10, "Prénom : ");
        $pdf->Cell(0, 10, $username, 0, 1);

        $pdf->Cell(40, 10, "Nom : ");
        $pdf->Cell(0, 10, $name, 0, 1);

        $pdf->Cell(40, 10, "Poste : ");
        $pdf->Cell(0, 10, $position, 0, 1);

        $pdf->Cell(40, 10, "Experience : ");
        $pdf->MultiCell(0, 10, $experience, 0, 1);

        $pdf->Cell(40, 10, "Retour : ");
        $pdf->MultiCell(0, 10, $feedback, 0, 1);

        $pdf->Cell(40, 10, "Points forts : ");
        $pdf->MultiCell(0, 10, $strenghts, 0, 1);

        $pdf->Cell(40, 10, "Points faibles : ");
        $pdf->MultiCell(0, 10, $weaknesses, 0, 1);

        $pdf->Cell(40, 10, "Motivation : ");
        $pdf->MultiCell(0, 10, $motivation, 0, 1);

        $pdf->Cell(70, 10, "Situation difficile surmontée : ");
        $pdf->MultiCell(0, 10, $challenges, 0, 1);

        $pdf->Cell(70, 10, "Où vous voyez-vous dans 5 ans : ");
        $pdf->MultiCell(0, 10, $future, 0, 1);

        //accord de confidentialité
        $pdf->Ln(10);
        $pdf->Cell(200, 10, "Accord de confidentialité", 0, 1, 'C');
        $pdf->Ln(5);
        $pdf->Multicell(0, 10, "Je, soussigne(é) {$name} {$username}, déclare avoir pris connaissance des informations fournies lors de l'entretien." 
         . "Je m'engage à ne pas divulguer ces informations confidentielles échangées lors de cet entretien."
        . "Je comprends que ces informations sont strictement destinées à des fins professionnelles et doivent être traitées avec la plus grande confidentialité."
        . "\n\nSignature : ____________________________\nDate : {$dateDuJour}");

        // generation du pdf

        $pdf->Output('D', 'entretien_recapitulatif.pdf');
    } elseif (isset($_POST['action']) && $_POST['action'] == 'csv') {
        // nom du fichier CSV
        $filename = 'entretien_recapitulatif.csv';

        // ouvrir le fichier en mode écriture
        $file = fopen($filename, 'w');

        // ajouter les entêtes

        fputcsv($file, ['Prénom', 'Nom', 'Poste', 'Experience', 'Retour', 'Points forts', 'Points faibles', 'Motivation', 'Situation difficile surmontée', 'Où vous voyez-vous dans 5 ans']);

        // ajouter les reponses
        fputcsv($file, [$username, $name, $position, $experience, $feedback, $strenghts, $weaknesses, $motivation, $challenges, $future]);

        // fermer le fichier
        fclose($file);

        // telecharger le fichier CSV
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        readfile($filename);
        unlink($filename);
    } elseif (isset($_POST['action']) && $_POST['action'] == 'json') {
        // creation d'un tableau associatif pour les données
        $data = [
            "prenom" => $username,
            "nom" => $name,
            "poste" => $position,
            "experience" => $experience,
            "retour" => $feedback,
            "points_forts" => $strenghts,
            "points_faibles" => $weaknesses,
            "motivation" => $motivation,
            "situation_difficile_surmontée" => $challenges,
            "où_vous_voyez_vous_dans_5_ans" => $future,
            "date" => $dateDuJour
        ];

        // convertir le tableau associatif en JSON
        $jsonData = json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        // nom du fichier JSON
        $filename = 'entretien_recapitulatif.json';

        // envoie des entetes pour le telechargement
        header('Content-Type: application/json');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        // afficher des donnes JSON
        echo $jsonData;
    }
}
?>
