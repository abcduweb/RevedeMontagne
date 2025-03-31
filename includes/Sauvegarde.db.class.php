<?php
class mysql{
    
	function mysql($serveur,$utilisateur,$password,$bd,$debug,$erreur){
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
		$this->link = @mysql_connect($this->serveur, $this->utilisateur, $this->password) or die($this->erreur());
		mysql_select_db($this->bd) or die($this->erreur());
	}
	
	function deconnection(){
		mysql_close($this->link);
	}
	
	function requete($sql){
		
		$this->result = @mysql_query($sql,$this->link) or die($this->erreur($sql));
		$this->requetes++;
		return $this->result;
	}
	
	function fetch($result = null)
	{
		if($result == null)$result = $this->result;
		$var = mysql_fetch_array($result);
		return $var;
	}
	
	function fetch_assoc($result = null){
		if($result == null)$result = $this->result;
		$var = mysql_fetch_assoc($result);
		return $var;
	}
	
	function row($result = null){
		if($result == null)$result = $this->result;
		$var = mysql_fetch_row($result);
		return $var;
	}

	function num($result = null)
	{
		if($result == null)$result = $this->result;
		$var = mysql_num_rows($result);
		return $var;
	}

	function last_id()
	{
		$var = mysql_insert_id($this->link);
		return $var;
	}
	
	function escape($var)
	{
		$var = mysql_real_escape_string($var,$this->link);
		return $var;
	}
	
    function erreur($sql=FALSE){
        if($this->debug == 0){
            echo $this->message_erreur;
        }
        elseif($this->debug == 1){
            $this->error = mysql_error();
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
