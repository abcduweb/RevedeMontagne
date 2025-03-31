<?php
/*################################################################################################################################
Réalisation SAS ABCduWeb
Date de création : 04/04/2024
Date de mise à jour : 03/07/2024
Contact : contact@abcduweb.fr
################################################################################################################################*/

class sql2019{
public $serveur, $utilisateur,$password, $bd, $debug, $message_erreur, $requetes, $result, $link;	
   
	public function __construct($serveur,$utilisateur,$password,$bd,$debug,$erreur)
	{	
		$this->serveur = $serveur;
		$this->utilisateur = $utilisateur;
		$this->password = $password;
		$this->bd = $bd;
		$this->debug = $debug;
		$this->message_erreur = $erreur;
		$this->requetes = 0;
		$this->connection();
   	}

	 
	 
	function connection(){
		$this->link = mysqli_connect($this->serveur, $this->utilisateur, $this->password, $this->bd) or die($this->erreur());
		/* Vérification de la connexion */
		if (mysqli_connect_errno()) {
			$this->mysqli_connect_error();
			/*exit();*/
		}
	}
	
	function deconnection(){
		mysqli_close($this->link);
	}
	
	function requete($sql){
		$this->result = mysqli_query($this->link, $sql) or die($this->erreur($sql));	
		$this->requetes++;
		return $this->result;
	}
	
	function fetch($result = null)
	{
		if($result == null)$result = $this->result;
		$var = mysqli_fetch_array($result);
		return $var;
	}
	
	function fetch_assoc($result = null){
		if($result == null)$result = $this->result;
		$var = mysqli_fetch_assoc($result);
		return $var;
	}
	
	function row($result = null){
		if($result == null)$result = $this->result;
		$var = mysqli_fetch_row($result);
		return $var;
	}

	function num($result = null)
	{
		if($result == null)$result = $this->result;
		$var = mysqli_num_rows($result);
		return $var;
	}

	function last_id()
	{
		$var = mysqli_insert_id($this->link);
		return $var;
	}
	
	function escape($var)
	{
		$var = mysqli_real_escape_string($this->link, $var);
		return $var;
	}
	
    function erreur($sql=FALSE){
        if($this->debug == 0){
            echo $this->message_erreur;
        }
        elseif($this->debug == 1){
            $this->error = mysqli_error($this->link);
            $message = '<p>L erreur suivante est apparue: '.$this->error.'</p>';
			if($sql)
			{
				$message .= '<p style="font-weight:bold;">Sur la requete : '.$sql;
			}
            echo $message."</p>";
        }
		exit;
    }
	
	function nb_requetes()
	{
		return $this->requetes;
	}
}

?>
