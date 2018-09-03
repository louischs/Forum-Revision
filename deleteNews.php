<!--
Auteur : Choisy Louis
Titre : Forum
Description : Fichier permettant de supprimer le post
Version : 1.0.0
Date : 03.09.2018
Copyright : Entreprise Ecole CFPT-I © 2018
-->
<?php 
    require './lib/forum.inc.php';
    if(isset($_POST['idNews'])){
        $idPostD = filter_input(INPUT_POST, "idNews", FILTER_VALIDATE_INT); 
        deletePost($idPostD);
        header('Location:./welcome.php');
    }
?>