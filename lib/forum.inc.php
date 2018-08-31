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
function insertPost($title, $description, $userId){
	$insertmbr = $GLOBALS['bdd']->prepare("INSERT INTO news(title, description, idUser) VALUES(?, ?, ?)");
    $insertmbr->execute(array($title, $description, $userId));	
	
}

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






































