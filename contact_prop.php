<?php 

require "controleur/Controleur.php";


if (isset($_POST["id"]))
{
	$id=htmlspecialchars($_POST["id"]);
	pageMailProp($id);
}
else 
{
	header('Location: index.php');
	exit();
}
