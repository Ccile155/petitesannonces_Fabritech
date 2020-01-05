<?php

require "controleur/Controleur.php";



if (isset($_GET["id"]) or isset($_POST["id"]))
{
	$id=htmlspecialchars($_GET["id"]);
	pageSupprimer($id);
}
else 
{
	header('Location: index.php');
	exit();
}
