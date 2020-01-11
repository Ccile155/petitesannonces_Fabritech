<?php

require "controleur/Controleur.php";



if (isset($_GET["id"]) or isset($_POST["id"]))
{
	if (isset($_GET["id"])){
		$id=htmlspecialchars($_GET["id"]);	
	}
	else {
		$id=htmlspecialchars($_POST["id"]);	
	}
	pageSupprimer($id);
}
else 
{
	header('Location: index.php');
	exit();
}
