<!--
Auteur : Choisy Louis
Titre : Forum
Description : Fichier contenant toutes les fonctions
Version : 1.0.0
Date : 03.09.2018
Copyright : Entreprise Ecole CFPT-I © 2018
-->
<?php
session_start();
$GLOBALS['bdd'] = new PDO('mysql:host=127.0.0.1;dbname=forum', 'root', '');
/**
 * Cette fonction vérifie que la paire utilisateur/password existe dans la table users
 * @param string $userId l'identifiant de l'utilisateur
 * @param string $pwd Le mot de passe 
 * @return True si existe
 */
function authenticate($userId, $pwd) {
	//Création de la requete SQL	
	$sql = "select password from users where login=:userId LIMIT 1;";
		$ps = $GLOBALS['bdd']->prepare($sql);
		//Execution de la requete
		try {
			$ps->bindParam(':userId', $userId, PDO::PARAM_STR);
			$isok = $ps->execute();
		}
		catch (PDOException $e) {
			$isok = false;
		}
		$answer = $ps->fetch(PDO::FETCH_ASSOC);
		var_dump($sql);
		//Si la réponse de la requete correspond au SHA1, on connecte l'user.
		if($answer["password"] == $pwd){
			return true;  
		}
		//Sinon on renvoie une erreur.
	$_SESSION['error'] = "Email ou mot de passe invalide";
	return false;
}
/**
 * Cette fonction retourne les informations d'un utilisateur
 * @param int $userId l'identifiant de l'utilisateur
 * @return array
 */
function getUserInfos($userId){
	$sql = "select idUser, name, surname from users where login=:userId LIMIT 1;";
	$ps = $GLOBALS['bdd']->prepare($sql);
		//Execution de la requete
		try {
			$ps->bindParam(':userId', $userId, PDO::PARAM_STR);
			$isok = $ps->execute();
		}
		catch (PDOException $e) {
			$isok = false;
		}
		$answer = $ps->fetch(PDO::FETCH_ASSOC);
		return $answer;  
}
/**
 * Cette fonction valide un post avant de l'entrer dans la base de données
 * @param string $title titre du post
 * @param string $description Description du post
 * @param int $userId id de l'auteur
 * @return "" si valide ou retourne une erreur
 */
function validatePost($title, $description, $userId){
	if($title === "")
		return "Pas de titre";
	if($description === "")
		return "Pas de description";
	if(strlen($title)>100)
		return "Titre trop long 100 char max";
	if(strlen($description)>1000)
		return "Description trop longue 1000 char max";
	insertPost($title, $description, $userId);
	return "";
}
/**
 * Cette fonction entre dans la base de données
 * @param string $title titre du post
 * @param string $description Description du post
 * @param int $userId id de l'auteur
 */
function insertPost($title, $description, $userId){
	$insertmbr = $GLOBALS['bdd']->prepare("INSERT INTO news(title, description, idUser) VALUES(?, ?, ?)");
    $insertmbr->execute(array($title, $description, $userId));		
}
/**
 * Cette fonction retourne tous les posts
 * @return array contenant tous les posts
 */
function getPosts(){
	$sql = "select idNews, title, description, creationDate, lastEditDate, idUser from news ORDER BY idNews DESC;";
	$ps = $GLOBALS['bdd']->prepare($sql);
		//Execution de la requete
		try {
			$isok = $ps->execute();
		}
		catch (PDOException $e) {
			$isok = false;
		}
		$answer = $ps->fetchAll(PDO::FETCH_ASSOC);
		return $answer; 
}
/**
 * Cette fonction retourne le nom et le prenom dun user
 * @param int $idUser id de l'utilisateur
 * @return array nom pre
 nom de l'user
 */
function getNameFromId($idUser){
    $sql = "select name, surname from users where idUser=:userId LIMIT 1;";
	$ps = $GLOBALS['bdd']->prepare($sql);
		//Execution de la requete
		try {
			$ps->bindParam(':userId', $idUser, PDO::PARAM_STR);
			$isok = $ps->execute();
		}
		catch (PDOException $e) {
			$isok = false;
		}
		$answer = $ps->fetch(PDO::FETCH_ASSOC);
		return $answer; 
}
/**
 * Cette fonction récupère un post par son ID
 * @param int $idPost
 * @return array infos du post
 */
function getPostById($idPost){
    $sql = "select idNews, title, description from news where idNews=:idPost LIMIT 1;";
	$ps = $GLOBALS['bdd']->prepare($sql);
		//Execution de la requete
		try {
			$ps->bindParam(':idPost', $idPost, PDO::PARAM_STR);
			$isok = $ps->execute();
		}
		catch (PDOException $e) {
			$isok = false;
		}
		$answer = $ps->fetch(PDO::FETCH_ASSOC);
		return $answer; 
}
/**
 * Cette fonction modifie un post
 * @param string $title titre du post
 * @param string $description Description du post
 * @param int $idPost id du post a modifier
 */
function updatePost($idPost, $title, $description){
    $sql = "UPDATE `forum`.`news` SET `title` = '".$title."', `description` = '".$description."' WHERE `news`.`idNews` = ".$idPost.";";
    $ps = $GLOBALS['bdd']->prepare($sql);
		//Execution de la requete
		try {
			$isok = $ps->execute();
		}
		catch (PDOException $e) {
			$isok = false;
		}
}
/**
 * Cette fonction supprime un post
 * @param int $idPost id du post a supprimer
 */
function deletePost($idPost){
    $sql = "DELETE FROM `forum`.`news` WHERE `news`.`idNews` = ".$idPost.";";
    $ps = $GLOBALS['bdd']->prepare($sql);
		//Execution de la requete
		try {
			$isok = $ps->execute();
		}
		catch (PDOException $e) {
			$isok = false;
		}
}




































