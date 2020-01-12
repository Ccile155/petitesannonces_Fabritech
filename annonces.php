<?php 


require "controleur/Controleur.php";


if (!isset($_GET['page']) ) 
{
	$page= (int) 1;
}
else 
{
	$page = (int) $_GET['page'];
}



if (isset($_GET["motclef"]) AND isset($_GET["id_cat"]) AND isset($_GET["id_reg"]) )
{
	$motclef=htmlspecialchars($_GET["motclef"]);
	$id_cat=htmlspecialchars($_GET["id_cat"]);
	$id_reg=htmlspecialchars($_GET["id_reg"]);
 	pageListe($motclef, $id_cat, $id_reg, $page);
}
else 
{
   pageListe("","","",$page);
}

