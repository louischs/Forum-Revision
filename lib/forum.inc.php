<?php
/**
 * Cette fonction vérifie que la paire utilisateur/password existe dans la table users
 * @param string $userId l'identifiant de l'utilisateur
 * @param string $pwd Le mot de passe 
 * @return True si existe
 */
function authenticate($userId, $pwd) {
	//Création de la requete SQL
	$bdd = new PDO('mysql:host=127.0.0.1;dbname=forum', 'root', '');
	$sql = "select passwordUser from users where login=:userId LIMIT 1;";
		$ps = $bdd->prepare($sql);
		//Execution de la requete
		try {
			$ps->bindParam(':userId', $userId, PDO::PARAM_STR);
			$isok = $ps->execute();
		}
		catch (PDOException $e) {
			$isok = false;
		}
		$answer = $ps->fetch(PDO::FETCH_ASSOC);
		//Si la réponse de la requete correspond au SHA1, on connecte l'user.
		if($answer["password"] == $pwd){
			return true;  
		}
		//Sinon on renvoie une erreur.
	$_SESSION['error'] = "Email ou mot de passe invalide";
	return false;
}
