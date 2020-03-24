<?php ob_start(); ?> 
<?php $titre_page="Détails de l'annonce"; ?>

<?php

echo "<article >";
//echo "<div id='form_ajout'>";
   echo "<h3>".$ann->renderTitre()."</h3>";
	//echo $ann->getNbImages(); 
	
	if ($ann->getNbImages()>0){
		// partie image
		$liste_nom_img=$ann->getImage();
		echo '<div class="photo">';
			// photos miniature
			//echo '<ul>';
			echo '<center> ';
				
					foreach($liste_nom_img as $nom_img )
					{
						//echo "<li>";
							//echo $ann->getUploadsDir().$nom_img["nom_img"];
							$chemin =$ann->getUploadsDir().$nom_img["nom_img"];
							//echo '<img src="'.$chemin.'" alt="'.$ann->renderTitre().'" />';
							//echo '<img src="'.fctaffichimage($chemin, 120, 100).'" alt="'.$ann->renderTitre().'"/>';
							//echo '<a href="'.$chemin.'" title="'.$ann->renderTitre().'">';
							
							echo '<img class="mySlides" ';
							echo fctaffichimage($chemin, 0, 400);
							echo ' alt="'.$ann->renderTitre().'"';
							echo '  />';
						//echo "</li>";
						
	
					}
				   echo '<button class="w3-button w3-black w3-display-left" onclick="plusDivs(-1)">&#10094; Image précédente</button>';
	  			   echo '<button class="w3-button w3-black w3-display-right" onclick="plusDivs(1)">Image suivante &#10095;</button>';
				
			//echo '</ul>';
	      
	   echo '</div>';
	   echo '</center> ';
	   // fin partie image
   }

 

	echo "<p>Catégorie : ".$ann->renderNom_cat() ."<br />";
   echo "Ajoutée le ".$ann->renderDate_creation()."<br />";
   echo "Région : ".$ann->renderNom_reg() ."</p>";
   
   echo "<blockquote>".$ann->renderContenu()."</blockquote>";
   
	//echo "<p> Téléphone : ".$ann->renderTel()."</p>";
	//echo "<p> Mail : ".$ann->renderEmail()."</p>";
	echo "<strong>Prix : ".$ann->renderPrix()." €</strong>";
	
	echo '<p><a href="supprimer.php?id='.$ann->renderId().'">Supprimer l\'annonce</a></p>';


//echo "</div>";
echo "</article>";
//echo '<a href="index.php?action=liste">Retour à l\'accueil</a>';
?>

<script type="text/javascript" src="vue/defil_image.js"></script>


<article >
	 <h4>Contacter le propriétaire</h4>
	 <h5>Par téléphone :</h5>
	 <p> Téléphone : <?php echo $ann->renderTel() ?> </p>
	 
	 <h5>Par mail :</h5>
    <form id="envoi_mail" method="post" action="contact_prop.php">

    		<p><label for="nom_personne">Votre nom* :</label>
    		<input type="text" id="nom_personne" name="nom_personne" required placeholder="Nom (minimum 4 caractères)" pattern=".{4,}" /></p>
    		
    		<p><label for="email">Votre email* :</label>
    		<input type="email" id="email" name="email" value="" required placeholder="Email" /></p>
    		
    		<p><label for="tel">Votre téléphone : </label>
			<input type="tel" id="tel" name="tel" value="" placeholder="Tél au format 0123456789" /></p>


    		<!--<p> <label for="objet">Objet :</label> 
    		<input type="hidden" id="objet" name="objet" value="[Annonce] <?php echo $ann->renderTitre() ?>" /></p>-->
    		<input type='hidden' name='id' value=<?php echo $id ?> >
    		
    		<p><label for="message">Message* :</label><br />
    		<textarea id="message" name="message" required placeholder="Informations (entre 10 et 2000 caractères)" pattern=".{10,2000}" ></textarea></p>
    		
     
    	<input type="submit" name="envoi" value="Envoyer le message" />
    </form>
</article>

<?php $contenu = ob_get_clean(); ?>

<?php require 'vue/gabarit.php'; ?>