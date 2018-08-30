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

if(isset($_POST['userId']) and isset($_POST['pwd']) and isset($_POST['firstName']) and isset($_POST['name']) and isset($_POST['pwdConf']))
{
	$errors = [];
	$userId = filter_input(INPUT_POST, "userId", FILTER_SANITIZE_STRING);
	$pwd = filter_input(INPUT_POST, "pwd", FILTER_SANITIZE_STRING);
	$pwdConf = filter_input(INPUT_POST, "pwdConf", FILTER_SANITIZE_STRING);
	$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_STRING);
	$firstName = filter_input(INPUT_POST, "firstName", FILTER_SANITIZE_STRING);
	$userInfos = array($userId=>"userId", $pwd=>"password", $name=>"name", $firstName=>"firstName");
	if(!empty($userId)&&!empty($pwd)&&!empty($pwdConf)&&!empty($name)&&!empty($firstName)){
		if($pwd === $pwdConf){
			$bdd = new PDO('mysql:host=127.0.0.1;dbname=forum', 'root', '');
			 $insertmbr = $bdd->prepare("INSERT INTO users(surname, login, name, password) VALUES(?, ?, ?, ?)");
             $insertmbr->execute(array($firstName, $userId, $name, $pwd));
			 $_SESSION['freshUser'] = true;
			 header('Location:./login.php');
		}
		else
		array_push($errors, "Les mots de passe ne correspondent pas!");
	}
	else
		array_push($errors, "Un des champs est vide!");
}
?><!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Inscription</title>
  </head>
  <body>
    <h1>Inscription</h1>
    <form id="register" action="register.php" method="POST">
      <table class="tableForm">
	  <tr>
          <td class="tdForm"><label for="firstName">Prenom : </label></td>
          <td class="tdForm"><input id="firstName" type="text" name="firstName" /></td>
        </tr>
		<tr>
          <td class="tdForm"><label for="name">Nom : </label></td>
          <td class="tdForm"><input id="user" type="text" name="name" /></td>
        </tr>
        <tr>
          <td class="tdForm"><label for="userId">Identifiant : </label></td>
          <td class="tdForm"><input id="userId" type="text" name="userId" /></td>
        </tr>
        <tr>
          <td class="tdForm"><label for="pwd">Mot de passe : </label></td>
          <td class="tdForm"><input id="pwd" type="password" name="pwd" /></td>
        </tr>
		<tr>
          <td class="tdForm"><label for="pwdConf">Confirmation du mot de passe : </label></td>
          <td class="tdForm"><input id="pwdConf" type="password" name="pwdConf" /></td>
        </tr>
        <tr>
          <td class="tdForm">&nbsp;</td>
          <td class="tdForm"><input type="submit" name="btnSubmit" value="Valider" /></td>
        </tr>
      </table>
	  <?php 
	  //Si l'utilisateur a mal rentré les indentifiants, une erreur s'affiche.
		if(isset($errors) and $errors != ""){
			foreach($errors as $erreur){
				echo $erreur . "<br>";
			}
		}
	  ?>
    </form>
	<a href="register.php">Pas encore inscrit?</a>
  </body>
</html>
