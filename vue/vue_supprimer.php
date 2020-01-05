<?php ob_start(); ?> 
<?php $titre_page="Supprimer l'annonce"; ?>
<?php
	echo "<article>";
	
		if (isset($_POST["email"]) AND isset($_POST["motdepasse"]) AND isset($_POST["id"]))
		{
							$ann=new Annonce($_POST["id"]);
							$reussite=$ann->suppr_bdd($_POST["email"],$_POST["motdepasse"]);
							if($reussite) 
							{
								echo "<p><strong>Annonce supprimée avec succès</strong></p>";
		
							}
							else 
							{
								echo "<p><strong>Echec de la suppression. Vérifier vos données d'entrées.</strong></p>";
							}
							//echo '<a href="index.php?action=liste">Retour à l\'accueil</a>';
							//echo '<br /><a href="ajout.php">Déposer une nouvelle annonce</a>';
							
		}
		else {
		
		?>
							
							<form method="POST" action="supprimer.php">
							
		      					<strong>Entrez votre email et mot de passe pour supprimer l'annonce.</strong>
							
									<p><label for="email">Adresse Email : </label>
									<input type="email" id="email" name="email" value="" required placeholder="Email" /></p>
									
									<p><label for="motdepasse">Mot de passe : </label>
									<input type="password" id="motdepasse" name="motdepasse" value="" required placeholder="minimum 6 caractères" pattern=".{6,}" /></p>
									
									<input type='hidden' name='id' value=<?php echo $id ?> >
									
									<input type="submit" name="Envoyer" value="Supprimer" />
									
							</form>
		<?php
	
		}
		echo "</article>";
?>

             
<?php $contenu = ob_get_clean(); ?>

<?php require 'vue/gabarit.php'; ?>