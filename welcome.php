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
    $userInfos = getUserInfos($_SESSION['userId']);
    if(isset($_POST['description']) && isset($_POST['title'])){
		$description = filter_input(INPUT_POST, "description", FILTER_SANITIZE_STRING);
		$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
		
		$verification = validatePost($title, $description, $userInfos['idUser']);
		if($verification == ""){
			$_POST = array();
			$description = "";
			$title = "";
			echo "Post ajouté!";
			
		}
		else
			echo $verification. "<br>";
	}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Fil d'actualité</title>
</head>

<body>
    <?php 
	
	echo "Bonjour " . $userInfos['surname'] . " " . $userInfos['name'] . ", voici votre fil d'actualites!";
	?>
    <h1>Nouveau post</h1>
    <form id="news" action="welcome.php" method="POST">
        <table class="tableForm">
            <tr>
                <td class="tdForm"><label for="title">Titre : </label></td>
                <td class="tdForm"><input id="title" type="text" name="title" /></td>
            </tr>
            <tr>
                <td class="tdForm"><label for="description">Description : </label></td>
                <td class="tdForm"><textarea id="description" name="description"></textarea></td>
            </tr>
            <tr>
                <td class="tdForm">&nbsp;</td>
                <td class="tdForm"><input type="submit" name="btnSubmit" value="Insérer" /></td>
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
    <?php 
	$posts = getPosts();
	foreach($posts as $post){
		echo "<h2>".$post["title"]."</h2><br>";
        echo "<h2>Auteur: " . getnameFromId($post["idUser"])["surname"] . " " . getnameFromId($post["idUser"])["name"] . "</h2>";
        echo "<h3>Date de création : ".$post['creationDate']."</h3>";
        echo "<h3>Dernière modification : ".$post['lastEditDate']."</h3>";
		echo "<p>".$post["description"]."</p><br>";
	}
	?>
</body>

</html>
