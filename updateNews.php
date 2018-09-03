<!--
Auteur : Choisy Louis
Titre : Forum
Description : Fichier permettant de modifier le post sélectionné
Version : 1.0.0
Date : 03.09.2018
Copyright : Entreprise Ecole CFPT-I © 2018
-->

<?php
	require './lib/forum.inc.php';
    $userInfos = getUserInfos($_SESSION['userId']);
    if(isset($_POST['idNews'])){
		$idNews = filter_input(INPUT_POST, "idNews", FILTER_VALIDATE_INT);
		$post = getPostById($idNews);
	}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Modification</title>
</head>

<body>
    <?php 
	
	echo "Bonjour " . $userInfos['surname'] . " " . $userInfos['name'] . ", bienvenue sur la page de modification!";
	?>
    <h1>Modifier un post</h1>
    <form id="news" action="welcome.php" method="POST">
        <table class="tableForm">
            <tr>
                <td class="tdForm"><label for="title">Titre : </label></td>
                <td class="tdForm"><input id="title" type="text" name="titleModif" value="<?php echo $post['title']?>" /></td>
            </tr>
            <tr>
                <td class="tdForm"><label for="description">Description : </label></td>
                <td class="tdForm"><textarea id="description" name="descriptionModif"><?php echo $post['description']?></textarea></td>
            </tr>
            <tr>
                <td class="tdForm">&nbsp;</td>
                <td class="tdForm"><input type="submit" name="btnModifier" value="Modifier" />
                <input type="text" name="idPost" hidden value="<?php echo $idNews?>"></td>
            </tr>
        </table>
        <?php 
	  //Si l'utilisateur a mal rentré les indentifiants, une erreur s'affiche.
		if(isset($_SESSION['error']) and $_SESSION['error'] != ""){
			echo '<p style="color: red;">'.$_SESSION['error'].'</p>';
		}
	  ?>
    </form>
    <a href="logout.php">Deconnexion</a>
</body>

</html>
