<?php 



include_once('modele/Annonce.class.php');

require "modele/Modele.php";

function pageListe($motclef,$id_cat,$id_reg,$page) 
{
	$limite =(int) 10;
	$debut = (int) ($page - 1) * $limite;
	
	
	$nb_annonces=getNb_annonces($motclef,$id_cat,$id_reg);
	$liste_id_ann=getListe_id_ann($motclef,$id_cat,$id_reg,$debut,$limite);
	$nb_pages=getNb_pages($motclef,$id_cat,$id_reg,$limite);

	$liste_infos_cat=getListe_infos_cat();
	$liste_infos_reg=getListe_infos_reg();
	
	require "vue/vue_liste.php";
}

/*
function pageAccueil() 
{
	$limite =(int) 5;
	$debut = (int) 0;
	
	$liste_id_ann=getListe_id_ann("","","",$debut,$limite);

	$liste_infos_cat=getListe_infos_cat();
	$liste_infos_reg=getListe_infos_reg();
	
	require "vue/vue_accueil.php";
}
*/

function pageAjout() 
{
	$liste_infos_cat=getListe_infos_cat();
	$liste_infos_reg=getListe_infos_reg();
	require "vue/vue_ajout.php";
}

function pageDetails($id) 
{	
	$ann=new Annonce($id);
	require "vue/vue_details.php";

}

function pageSupprimer($id) 
{
	require "vue/vue_supprimer.php";

}

function pageMailProp($id) {
	
	require "vue/vue_mail.php";
}

function pageContact() {
	
	require "vue/vue_contact.php";
}