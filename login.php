<!--
Auteur : Choisy Louis
Titre : Forum
Description : Nous allons créer	un site	d’échange d’information	basique, une sorte	de	petit	forum.
Version : 1.0.0
Date : 30.08.2018
Copyright : Entreprise Ecole CFPT-I © 2018
-->

<?php

require './lib/forum.inc.php';
//On verifie que le mail et le mdp ne soient pas vides
if(isset($_POST['user']) and isset($_POST['pwd']))
{
	if(authenticate($_POST['user'], $_POST['pwd'])){
		$bdd = new PDO('mysql:host=127.0.0.1;dbname=forum', 'root', '');
		$sql = "select name, surname from users where login=:userId LIMIT 1;";
		$ps = $bdd->prepare($sql);
		//Execution de la requete
		try {
			$ps->bindParam(':userId', $_POST['user'], PDO::PARAM_STR);
			$isok = $ps->execute();
		}
		catch (PDOException $e) {
			$isok = false;
		}
		$answer = $ps->fetch(PDO::FETCH_ASSOC);
		$_SESSION['userInfos'] = $answer;
		//header('Location:./welcome.php');
	}
}
?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Connexion</title>
  </head>
  <body>
  <?php 
	if(isset($_SESSION['freshUser'])){
		echo "<h1>Votre inscription a bien été prise en compte! Bienvenue!</h1>";
	}
  ?>
    <h1>Connexion</h1>
    <form id="login" action="login.php" method="POST">
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
