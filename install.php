<?php require "modele/Modele.php"; ?>

<?php ob_start(); ?> 
<?php $titre_page="Script d'installation"; ?>
<?php

$bdd=getBDD();
$install_is_ok = true;

print("<h2>L'installation va se faire automatiquement</h2>");

print("<h3>1-Création de la base de données</h3>");

try{
	/*-- --------------------------------------------------------
	--
	-- Table structure for table `annonces`
	--*/
	
	$bdd->query("
	CREATE TABLE IF NOT EXISTS `annonces` (
	  `id` int(20) NOT NULL auto_increment,
	  `titre` varchar(50) NOT NULL,
	  `contenu` text NOT NULL,
	  `prix` int(30) NOT NULL,
	  `date_creation` datetime NOT NULL,
	  `id_cat` int(5) NOT NULL,
	  `id_reg` int(5) NOT NULL,
	  `tel` varchar(20) NOT NULL,
	  `email` varchar(255) NOT NULL,
	  `motdepasse` varchar(255) NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
	");
	
	/*-- --------------------------------------------------------
	--
	-- Table structure for table `annonces_img`
	--*/
	
	$bdd->query("
	CREATE TABLE IF NOT EXISTS `annonces_img` (
	  `id` int(20) NOT NULL auto_increment,
	  `id_ann` int(20) NOT NULL,
	  `nom_img` varchar(255) NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
	");
	
	/*-- --------------------------------------------------------
	--
	-- Table structure for table `categories`
	--*/
	
	$bdd->query("
	CREATE TABLE IF NOT EXISTS `categories` (
	  `id` int(5) NOT NULL auto_increment,
	  `nom` varchar(50) NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
	");
	
	/*-- --------------------------------------------------------
	--
	-- Table structure for table `regions`
	--*/
	
	$bdd->query("
	CREATE TABLE IF NOT EXISTS `regions` (
	  `id` int(5) NOT NULL auto_increment,
	  `nom` varchar(50) NOT NULL,
	  PRIMARY KEY  (`id`)
	) ENGINE=MyISAM  DEFAULT CHARSET=utf8 ;
	");
	
	print("<p>Base de données créée avec succès.</p>");
	
}catch (Exception $e) {
	print("<p>Erreur lors de la création de la base de données</p>");
	$install_is_ok = false;
}
	
// ==========================================================================
print("<h3>2-Initialisation de la base de données</h3>");

// regions
$bdd->query("
LOAD DATA LOCAL INFILE './bdd/regions.csv' INTO TABLE regions
CHARACTER SET UTF8
FIELDS TERMINATED BY ';'
ENCLOSED BY ''  
LINES TERMINATED BY '\n'
(id, nom); 
");

$nb_regions = getNb_regions();

if ($nb_regions == 0) {
	print("<p>Erreur lors de l'ajout de régions</p>");
	$install_is_ok = false;
}
else {
	print("<p>Nombre de régions créées : $nb_regions</p>");
}

// categories
$bdd->query("
LOAD DATA LOCAL INFILE './bdd/categories.csv' INTO TABLE categories
CHARACTER SET UTF8
FIELDS TERMINATED BY ';'
ENCLOSED BY ''  
LINES TERMINATED BY '\n'
(id, nom); 
");

$nb_categories = getNb_categories();

if ($nb_categories == 0) {
	print("<p>Erreur lors de l'ajout de catégories</p>");
	$install_is_ok = false;
}
else {
	print("<p>Nombre de catégories créées : $nb_categories</p>");
}


// ==========================================================================

print("<h3>3-Création du dossier de téléversement</h3>");
if (!is_dir("./uploads")) {
	if (!mkdir("./uploads", 0755)) {
		$install_is_ok = false;
    	die('<p>Echec lors de la création des répertoires</p>');
	}
}
else {
	print("<p>Répertoire créé avec succès</p>");
	}
// ==========================================================================

if ($install_is_ok){
	print("<h3>4-Félicitations PetitesAnnonces a été installé avec succès !!</h3>");	
	print("<p>Pour utiliser le site, <b>supprimer le fichier install.php</b> et mettez à jour votre page web.</p>");
}
else {
	print("<h3>Échec d'installation : Vérifier les paramètres de votre installation et mettez à jour cette page.</h3>");
}

?>

<?php $contenu = ob_get_clean(); ?>

<?php require 'vue/gabarit_light.php'; ?>
