<!--
Auteur : Choisy Louis
Titre : Forum
Description : Nous allons créer	un site	d’échange d’information	basique, une sorte	de	petit	forum.
Version : 1.0.0
Date : 30.08.2018
Copyright : Entreprise Ecole CFPT-I © 2018
-->

<?php
	session_start();
	require './lib/forum.inc.php';

?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Fil d'actualité</title>
  </head>
  <body>
  <?php 
	echo "Bienvenue ".$_SESSION['userInfos']['surname']. " " .$_SESSION['userInfos']['name'].", vous etes connecte!!";
	?>
    <h1>Connexion</h1>
    <form id="news" action=".php" method="POST">
      <table class="tableForm">
        <tr>
          <td class="tdForm"><label for="user">Identifiant : </label></td>
          <td class="tdForm"><input id="user" type="text" name="user" /></td>
        </tr>
        <tr>
          <td class="tdForm"><label for="pwd">Mot de passe : </label></td>
          <td class="tdForm"><input id="pwd" type="password" name="pwd" /></td>
        </tr>
        <tr>
          <td class="tdForm">&nbsp;</td>
          <td class="tdForm"><input type="submit" name="btnSubmit" value="Valider" /></td>
        </tr>
      </table>
	  <?php 
	  //Si l'utilisateur a mal rentré les indentifiants, une erreur s'affiche.
		if(isset($_SESSION['error']) and $_SESSION['error'] != ""){
			echo '<p style="color: red;">'.$_SESSION['error'].'</p>';
		}
	  ?>
    </form>
	<a href="register.php">Pas encore inscrit?</a>
  </body>
</html>
