<?php ob_start(); ?> 
<?php $titre_page="Petites Annonces"; ?>
<?php
	echo "<p>Il y a ".$nb_annonces." annonce(s).</p>";
	//echo $nb_pages;
?>	

<div id="bloc_recherche">
	<form method="GET" action="annonces.php">
		
<!-- 		<label for="titre">Recherche par mot-clef : </label> -->
	     <input type="text" id="motclef" name="motclef" value=""  placeholder="Que recherchez-vous ?" />

<!-- 		  <label for="categorie">Catégorie : </label> -->
		  <select name="id_cat" id="categorie" >
		  <?php 
		  echo '<option value="">---Toutes catégories---</option>';
		  foreach($liste_infos_cat as $infos_cat)
		  {
				echo '<option value='.$infos_cat["id"].'>'.$infos_cat["nom"].'</option>';
		  }	
		  ?>								  					  
		  </select>
		  
<!-- 		  <label for="region">Région : </label> -->
		  <select name="id_reg" id="region" >
		  <?php 
		  echo '<option value="">---Toutes régions---</option>';
		  foreach($liste_infos_reg as $infos_reg)
		  {
				echo '<option value='.$infos_reg["id"].'>'.$infos_reg["nom"].'</option>';
		  }	
		  ?>								  					  
		  </select>
		  
		  <input type="submit" value="Lancer la recherche"></form>
</div>



<?php 
	 
	foreach($liste_id_ann as $id_ann)
	{

		echo '<article class="vue_macro" >';
			//echo $id_ann["id"];
			$ann=new Annonce($id_ann["id"]);
			
			echo '<a href="details.php?id='.$ann->getId().'"><h3>'.$ann->getTitre().'</h3></a>';
			//echo '<h3>'.$ann->getTitre().'</h3>';
			
			if ($ann->getNbImages()>0){
				// partie image
				$liste_nom_img=$ann->getImage();
							
							$nom_img=$liste_nom_img[0];

									$chemin =$ann->getUploadsDir().$nom_img["nom_img"];
									echo '<a href="details.php?id='.$ann->getId().'">';
										echo '<img class="photo_mini" ';
										echo fctaffichimage($chemin, 0, 130);
										echo ' alt="'.$ann->getTitre().'"';
										echo '  />';
									echo '</a>';
		   }
			
			
			echo "<p><em>Catégorie : ".$ann->getNom_cat() ."</em><br />";
			echo "<em>Région : ".$ann->getNom_reg() ."</em><br />";
			echo "<em>Ajoutée le ".$ann->getDate_creation()."</em></p>";
			echo "<strong>Prix : ".$ann->getPrix()." €</strong>";
			
	   echo "</article>";

	}  
?> 
<?php 
// gestion lien page precedente suivante
if ($page>1 AND $nb_pages>1){
	echo '<a href="annonces.php?motclef='.$motclef.'&id_cat='.$id_cat.'&id_reg='.$id_reg.'&page='.($page - 1).' "> &laquo; Page précédente</a>';
	echo "   ";
}
if ($page<$nb_pages){
	echo '<a href="annonces.php?motclef='.$motclef.'&id_cat='.$id_cat.'&id_reg='.$id_reg.'&page='.($page + 1).' ">Page suivante &raquo; </a>';

}


?>

<?php $contenu = ob_get_clean(); ?>

<?php require 'vue/gabarit.php'; ?>