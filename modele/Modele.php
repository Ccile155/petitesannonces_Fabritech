<?php 


// connection à la BDD
function getBDD()
{
	try
	{
		require_once "./conf/config.php";
		$bdd= new PDO('mysql:host='.DB_HOST.'; dbname='.DB_NAME,DB_USER,DB_PASSWORD, array(PDO::MYSQL_ATTR_INIT_COMMAND => " SET NAMES utf8 ", PDO::MYSQL_ATTR_LOCAL_INFILE => true));

		return $bdd;
	}
	catch(Exception $e)
	{
		die('Erreur : '.$e->getMessage());
	}
	//echo "Connection réussi<br />";
}

// install 
function getNb_regions() 
{
	$bdd=getBDD();
	$nb_regions = 0; 
	$query="SELECT COUNT(*) AS nb_regions FROM regions ";
	$req=$bdd->prepare($query);
	$req->execute();
	$donnees=$req->fetch();
	$req->closeCursor();
	$nb_regions=$donnees['nb_regions'];
	
	return $nb_regions;
}

function getNb_categories() 
{
	$bdd=getBDD();
	$nb_categories = 0; 
	$query="SELECT COUNT(*) AS nb_categories FROM categories ";
	$req=$bdd->prepare($query);
	$req->execute();
	$donnees=$req->fetch();
	$req->closeCursor();
	$nb_categories=$donnees['nb_categories'];
	
	return $nb_categories;
}

// modele ajout 
function getListe_infos_cat() 
{
	$bdd=getBDD();
	$req=$bdd->query("SELECT id, nom FROM categories ORDER BY nom");
	$liste_infos_cat=$req->fetchAll();
	$req->closeCursor();
	
	return $liste_infos_cat;
}

function getListe_infos_reg() 
{  
	$bdd=getBDD();
	$req=$bdd->query("SELECT id, nom FROM regions ORDER BY nom");
	$liste_infos_reg=$req->fetchAll();
	$req->closeCursor();
	return $liste_infos_reg;
}

//modele liste
function getNb_annonces($motclef,$id_cat,$id_reg) {
	$bdd=getBDD();
	
	$motclef="%".$motclef."%";

	$query="SELECT COUNT(*) AS nb_annonces FROM annonces WHERE titre LIKE ? ";
	if ($id_cat=="") {
		$id_cat="%";
		$query=$query."AND id_cat LIKE ? ";
	}
	else {
		$query=$query."AND id_cat = ? ";
	}

	if ($id_reg=="") {
		$id_reg="%";
		$query=$query."AND id_reg LIKE ? ";
	}
	else {
		$query=$query."AND id_reg = ? ";
	}	

	$req=$bdd->prepare($query);

	$req->execute(array($motclef,$id_cat,$id_reg));
	$donnees=$req->fetch();
	
	
	$req->closeCursor();
	
	$nb_annonces=$donnees['nb_annonces'];
	return $nb_annonces;
}

function getListe_id_ann($motclef,$id_cat,$id_reg,$debut,$limite) {
	$bdd=getBDD();
	
	$motclef="%".$motclef."%";
	
	
	$query="SELECT id, titre, id_cat FROM annonces WHERE titre LIKE ? ";
	if ($id_cat=="") {
		$id_cat="%";
		$query=$query."AND id_cat LIKE ? ";
	}
	else {
		$query=$query."AND id_cat = ? ";
	}

	if ($id_reg=="") {
		$id_reg="%";
		$query=$query."AND id_reg LIKE ? ";
	}
	else {
		$query=$query."AND id_reg = ? ";
	}	
	$query=$query."ORDER BY date_creation DESC ";
	$query=$query."LIMIT ".$limite." OFFSET ".$debut; //pas safe
	//$query=$query."LIMIT ? OFFSET ?";
	
	//$req=$bdd->prepare("SELECT id, titre, id_cat FROM annonces WHERE titre LIKE ? AND id_cat LIKE ? AND id_reg  LIKE ? ORDER BY date_creation DESC");
	$req=$bdd->prepare($query);

	$req->execute(array($motclef,$id_cat,$id_reg));
	$liste_id_ann=$req->fetchAll();
	
	$req->closeCursor();
	return $liste_id_ann;
}

function getNb_pages($motclef,$id_cat,$id_reg,$limite) {
	$nombreDePages = ceil(getNb_annonces($motclef,$id_cat,$id_reg) / $limite);
	return $nombreDePages;
}


function fctaffichimage($img_Src, $W_max, $H_max) {
// © Jérome Réaux : http://j-reaux.developpez.com - http://www.jerome-reaux-creations.fr
// http://j-reaux.developpez.com/tutoriel/php/fonctions-redimensionner-image/
// ---------------------------------------------------
// Fonction de redimensionnement A L'AFFICHAGE (pas de modif du poids)
// ---------------------------------------------------
// La FONCTION : fctaffichimage($img_Src, $W_max, $H_max)
// Les paramètres :
// - $img_Src : URL (chemin + NOM) de l'image Source
// - $W_max : LARGEUR maxi finale ----> ou 0 : largeur libre
// - $H_max : HAUTEUR maxi finale ----> ou 0 : hauteur libre
// ---------------------
// Affiche : src="..." width="..." height="..." pour la balise img
// Utilisation :
// &lt;img alt=&quot;&quot; &lt;?php fctaffichimage('repimg/monimage.jpg', 120, 100) ?&gt; /&gt;
// ---------------------------------------------------
/* Exemple : <img alt="" <?php fctaffichimage('repimg/monimage.jpg', 120, 100) ?> /> */

 if (file_exists($img_Src)) {
   // ---------------------
   // Lit les dimensions de l'image source
   $img_size = getimagesize($img_Src);
   $W_Src = $img_size[0]; // largeur source
   $H_Src = $img_size[1]; // hauteur source
   // ---------------------
   if(!$W_max) { $W_max = 0; }
   if(!$H_max) { $H_max = 0; }
   // ---------------------
   // Teste les dimensions tenant dans la zone
   $W_test = round($W_Src * ($H_max / $H_Src));
   $H_test = round($H_Src * ($W_max / $W_Src));
   // ---------------------
   // si l'image est plus petite que la zone
   if($W_Src<$W_max && $H_Src<$H_max) {
      $W = $W_Src;
      $H = $H_Src;
   // sinon si $W_max et $H_max non definis
   } elseif($W_max==0 && $H_max==0) {
      $W = $W_Src;
      $H = $H_Src;
   // sinon si $W_max libre
   } elseif($W_max==0) {
      $W = $W_test;
      $H = $H_max;
   // sinon si $H_max libre
   } elseif($H_max==0) {
      $W = $W_max;
      $H = $H_test;
   // sinon les dimensions qui tiennent dans la zone
   } elseif($H_test > $H_max) {
      $W = $W_test;
      $H = $H_max;
   } else {
      $W = $W_max;
      $H = $H_test;
   }
   // ---------------------
 } else { // si le fichier image n existe pas
      $W = 0;
      $H = 0;
 }
 // ---------------------------------------------------
 // Affiche : src="..." width="..." height="..." pour la balise img
 echo ' src="'.$img_Src.'" width="'.$W.'" height="'.$H.'"';
 // ---------------------------------------------------
}



function fctredimimage($W_max, $H_max, $rep_Dst, $img_Dst, $rep_Src, $img_Src) {
// © Jérome Réaux : http://j-reaux.developpez.com - http://www.jerome-reaux-creations.fr
// http://j-reaux.developpez.com/tutoriel/php/fonctions-redimensionner-image/
// ---------------------------------------------------
// Fonction de REDIMENSIONNEMENT physique "PROPORTIONNEL" et Enregistrement
// ---------------------------------------------------
// retourne : true si le redimensionnement et l'enregistrement ont bien eu lieu, sinon false
// ---------------------
// La FONCTION : fctredimimage ($W_max, $H_max, $rep_Dst, $img_Dst, $rep_Src, $img_Src)
// Les paramètres :
// - $W_max : LARGEUR maxi finale --> ou 0
// - $H_max : HAUTEUR maxi finale --> ou 0
// - $rep_Dst : repertoire de l'image de Destination (déprotégé) --> ou '' (même répertoire)
// - $img_Dst : NOM de l'image de Destination --> ou '' (même nom que l'image Source)
// - $rep_Src : repertoire de l'image Source (déprotégé)
// - $img_Src : NOM de l'image Source
// ---------------------
// 3 options :
// A- si $W_max!=0 et $H_max!=0 : a LARGEUR maxi ET HAUTEUR maxi fixes
// B- si $H_max!=0 et $W_max==0 : image finale a HAUTEUR maxi fixe (largeur auto)
// C- si $W_max==0 et $H_max!=0 : image finale a LARGEUR maxi fixe (hauteur auto)
// Si l'image Source est plus petite que les dimensions indiquées : PAS de redimensionnement.
// ---------------------
// $rep_Dst : il faut s'assurer que les droits en écriture ont été donnés au dossier (chmod)
// - si $rep_Dst = ''   : $rep_Dst = $rep_Src (même répertoire que l'image Source)
// - si $img_Dst = '' : $img_Dst = $img_Src (même nom que l'image Source)
// - si $rep_Dst='' ET $img_Dst='' : on ecrase (remplace) l'image source !
// ---------------------
// NB : $img_Dst et $img_Src doivent avoir la meme extension (meme type mime) !
// Extensions acceptées (traitees ici) : .jpg , .jpeg , .png
// Pour Ajouter d autres extensions : voir la bibliotheque GD ou ImageMagick
// (GD) NE fonctionne PAS avec les GIF ANIMES ou a fond transparent !
// ---------------------
// UTILISATION (exemple) :
// $redimOK = fctredimimage(120,80,'reppicto/','monpicto.jpg','repimage/','monimage.jpg');
// if ($redimOK==true) { echo 'Redimensionnement OK !';  }
// ---------------------------------------------------
/*$redimOK = fctredimimage(120,80,'reppicto/','monpicto.jpg','repimage/','monimage.jpg');
if ($redimOK == 1) { echo 'Redimensionnement OK !'; }*/

 $condition = 0;
 // Si certains paramètres ont pour valeur '' :
 if ($rep_Dst=='') { $rep_Dst = $rep_Src; } // (même répertoire)
 if ($img_Dst=='') { $img_Dst = $img_Src; } // (même nom)
 // ---------------------
 // si le fichier existe dans le répertoire, on continue...
 if (file_exists($rep_Src.$img_Src) && ($W_max!=0 || $H_max!=0)) { 
   // ----------------------
   // extensions acceptées : 
	$extension_Allowed = 'jpg,jpeg,png';	// (sans espaces)
   // extension fichier Source
	$extension_Src = strtolower(pathinfo($img_Src,PATHINFO_EXTENSION));
   // ----------------------
   // extension OK ? on continue ...
   if(in_array($extension_Src, explode(',', $extension_Allowed))) {
     // ------------------------
      // récupération des dimensions de l'image Src
      $img_size = getimagesize($rep_Src.$img_Src);
      $W_Src = $img_size[0]; // largeur
      $H_Src = $img_size[1]; // hauteur
      // ------------------------
      // condition de redimensionnement et dimensions de l'image finale
      // ------------------------
      // A- LARGEUR ET HAUTEUR maxi fixes
      if ($W_max!=0 && $H_max!=0) {
         $ratiox = $W_Src / $W_max; // ratio en largeur
         $ratioy = $H_Src / $H_max; // ratio en hauteur
         $ratio = max($ratiox,$ratioy); // le plus grand
         $W = $W_Src/$ratio;
         $H = $H_Src/$ratio;   
         $condition = ($W_Src>$W) || ($W_Src>$H); // 1 si vrai (true)
      }
      // ------------------------
      // B- HAUTEUR maxi fixe
      if ($W_max==0 && $H_max!=0) {
         $H = $H_max;
         $W = $H * ($W_Src / $H_Src);
         $condition = ($H_Src > $H_max); // 1 si vrai (true)
      }
      // ------------------------
      // C- LARGEUR maxi fixe
      if ($W_max!=0 && $H_max==0) {
         $W = $W_max;
         $H = $W * ($H_Src / $W_Src);         
         $condition = ($W_Src > $W_max); // 1 si vrai (true)
      }
      // ---------------------------------------------
      // REDIMENSIONNEMENT si la condition est vraie
      // ---------------------------------------------
      // - Si l'image Source est plus petite que les dimensions indiquées :
      // Par defaut : PAS de redimensionnement.
      // - Mais on peut "forcer" le redimensionnement en ajoutant ici :
      // $condition = 1; (risque de perte de qualité)
      if ($condition==1) {
         // ---------------------
         // creation de la ressource-image "Src" en fonction de l extension
         switch($extension_Src) {
         case 'jpg':
         case 'jpeg':
           $Ress_Src = imagecreatefromjpeg($rep_Src.$img_Src);
           break;
         case 'png':
           $Ress_Src = imagecreatefrompng($rep_Src.$img_Src);
           break;
         }
         // ---------------------
         // creation d une ressource-image "Dst" aux dimensions finales
         // fond noir (par defaut)
         switch($extension_Src) {
         case 'jpg':
         case 'jpeg':
           $Ress_Dst = imagecreatetruecolor($W,$H);
           break;
         case 'png':
           $Ress_Dst = imagecreatetruecolor($W,$H);
           // fond transparent (pour les png avec transparence)
           imagesavealpha($Ress_Dst, true);
           $trans_color = imagecolorallocatealpha($Ress_Dst, 0, 0, 0, 127);
           imagefill($Ress_Dst, 0, 0, $trans_color);
           break;
         }
         // ---------------------
         // REDIMENSIONNEMENT (copie, redimensionne, re-echantillonne)
         imagecopyresampled($Ress_Dst, $Ress_Src, 0, 0, 0, 0, $W, $H, $W_Src, $H_Src); 
         // ---------------------
         // ENREGISTREMENT dans le repertoire (avec la fonction appropriee)
         switch ($extension_Src) { 
         case 'jpg':
         case 'jpeg':
           imagejpeg ($Ress_Dst, $rep_Dst.$img_Dst);
           break;
         case 'png':
           imagepng ($Ress_Dst, $rep_Dst.$img_Dst);
           break;
         }
         // ------------------------
         // liberation des ressources-image
         imagedestroy ($Ress_Src);
         imagedestroy ($Ress_Dst);
      }
      // ------------------------
   }
 }
 // ---------------------------------------------------
 // retourne : true si le redimensionnement et l'enregistrement ont bien eu lieu, sinon false
 if ($condition==1 && file_exists($rep_Dst.$img_Dst)) { return true; }
 else { return false; }
 // ---------------------------------------------------
};