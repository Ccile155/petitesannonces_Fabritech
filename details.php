<?php 

require "controleur/Controleur.php";

if (isset($_GET["id"]))
{
	$id=htmlspecialchars($_GET["id"]);
	pageDetails($id);
}
else 
{
	header('Location: index.php');
	exit();
}

