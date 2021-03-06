<?php

include_once 'header.php';

if (!isset($_SESSION['user_id'])) {

    header("Location: signup&login_form.php");
}



$num_projets = selectAllProjectsNum();


$msg = [];
print_r($num_projets);
$num_projets_1d = [];
foreach ($num_projets as $n) {
    $num_projets_1d[] = $n['noproj'];
}
print_r($num_projets_1d);


if (isset($_POST['noemp'])) {
    $incomplet = false;
    if (empty($_POST['nom'])) {
        $msg[] = " Vous n'avez pas entré le nom ";
        $incomplet = true;
    }
    if (empty($_POST['prenom'])) {
        $msg[] = "Vous n'avez pas entré le prenom ";
        $incomplet = true;
    }
    if (empty($_POST['emploi'])) {
        $msg[] = "Vous n'avez pas entré l'emploi de l'employé";
        $incomplet = true;
    }
    if (empty($_POST['sup'])) {
        $msg[] = "Vous n'avez pas selectionné le supérieur de l'employé";
        $incomplet = true;
    }
    if (empty($_POST['embauche'])) {
        $msg[] = "Vous n'avez pas entré la date d'embauche ";
        $incomplet = true;
    }
    if (empty($_POST['sal'])) {
        $msg[] = " Vous n'avez pas entré le montant du salaire ";
        $incomplet = true;
    }
    if (empty($_POST['noserv'])) {
        $msg[] = "Vous n'avez pas entré le numero de service ";
        $incomplet = true;
    }
    if (empty($_POST['noproj'])) {
        $msg[] = "Vous n'avez pas entré le numero de projet ";
        $incomplet = true;
    } elseif (!in_array($_POST['noproj'], $num_projets_1d)) {
        $msg[] = "Ce projet n'existe pas";
        $incomplet = true;
    }
    if ($incomplet) {
        include('form.php');
        foreach ($msg as $m) {
            echo $m . "<br>";
        }
    } else {

        $sql = "INSERT INTO emp(noemp, nom, prenom, emploi, sup, embauche, sal, comm, noserv, noproj) VALUES('" . $_POST["noemp"] . "','" . $_POST["nom"] . "','" . $_POST["prenom"] . "','" . $_POST["emploi"] . "','" . $_POST["sup"] . "','" . $_POST["embauche"] . "','" . $_POST["sal"] . "','" . $_POST["comm"] . "','" . $_POST["noserv"] . "','" . $_POST["noproj"] . "' );";
        maQuery($sql, 'nop');
        $noemp = $_POST['noemp'];
        $insert_date = "UPDATE emp SET date_ajout = DATE(NOW()) WHERE noemp = $noemp;";
        maQuery($insert_date, 'nop');
        function selectAllProjectsNum()
        {
            $con = mysqli_init();
            if (!$con) {
                die("mysqli_init failed");
            }
            mysqli_real_connect($con, 'localhost', 'zak', 'mdp', 'gestion_emp');
            $sql = " SELECT DISTINCT noproj FROM proj;";
            $rs = mysqli_query($con, $sql);

            $data = mysqli_fetch_all($rs, MYSQLI_ASSOC);
            mysqli_free_result($rs);
            return $data;

            mysqli_close($con);
        }

        header("Location: tableau-connecte.php?Enregistrement=succes");
    }
}
