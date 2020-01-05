<?php ob_start(); ?> 
<?php $titre_page="Ajouter une annonce"; ?>
<?php

			if (isset($_POST["titre"]) AND isset($_POST["contenu"]) AND isset($_POST["prix"]) AND isset($_POST["id_cat"]) AND isset($_POST["id_reg"]) AND isset($_POST["tel"]) AND isset($_POST["email"]) AND isset($_POST["motdepasse"]))
			{
					/*echo $_POST["titre"];
					echo "<br />";
					echo date("d-m-Y");
					echo '<br /><a href="ajout.php">Ajouter</a>';
					echo '<br /><a href="index.php">Retour</a><br />';*/
					
					$ann = new Annonce("");
					$ann->setTitre($_POST["titre"]);
					$ann->setPrix($_POST["prix"]);
					$ann->setContenu($_POST["contenu"]);
					$ann->setId_cat($_POST["id_cat"]);
					$ann->setId_reg($_POST["id_reg"]);
					$ann->setTel($_POST["tel"]);
					$ann->setEmail($_POST["email"]);
					$ann->setMotdepasse($_POST["motdepasse"]);
					//$ann->setDate_creation("01/01/1950");
					//$ann->affiche();
					
					
					$reussite=$ann->ajout_bdd();
					
					// partie inclusion fichiers
					//echo $ann->getId();
					//echo var_dump($reussite);
					
				   if ( (isset($_FILES['pictures']['error']) || !is_array($_FILES['pictures']['error']) ) AND $reussite ) {
				   	$ann->setImage($_FILES);
				   } 
					
					
					// fin partie inclusion fichiers
					
					if($reussite) 
					{
						echo "<p><strong>Annonce ajoutée avec succès</strong></p>";
					}
					else 
					{
						echo "<p><strong>Echec de l'ajout. Vérifier vos données d'entrées.</strong></p>";
					}
					echo '<a href="index.php">Retour à l\'accueil</a>';
					echo '<br /><a href="ajout.php">Déposer une nouvelle annonce</a>';
					


			} 
			else {
?>
			<div id="form_ajout">
					<form enctype="multipart/form-data" method="POST" action="ajout.php">
					
						<fieldset>
						<legend>Produit : </legend>

							<p><label for="titre">Titre* : </label>
							<input type="text" id="titre" name="titre" value="" required placeholder="Titre (minimum 5 caractères)" pattern=".{5,50}" /></p>
							
						  <label for="categorie">Catégorie : </label>
						  <select name="id_cat" id="categorie" required>
						  <?php 
						  foreach($liste_infos_cat as $infos_cat)
						  {
								echo '<option value='.$infos_cat["id"].'>'.$infos_cat["nom"].'</option>';
						  }	
						  ?>								  					  
						  </select>
						  
						  <label for="region">Région : </label>
						  <select name="id_reg" id="region" required>
						  <?php 
						  foreach($liste_infos_reg as $infos_reg)
						  {
								echo '<option value='.$infos_reg["id"].'>'.$infos_reg["nom"].'</option>';
						  }	
						  ?>								  					  
						  </select>
						  
							<p><label for="contenu">Informations* : </label><br>
							<textarea id="contenu" name="contenu" required placeholder="Informations (entre 10 et 2000 caractères)" pattern=".{10,2000}"></textarea></p>
							
							<p><label for="prix">Prix* : </label>
							<input type="number" id="prix" name="prix" value="" required placeholder="Prix" /></p>
							
							<p><label for="images">Photos (2 Mo max/image, formats .jpg et .png acceptés) : </label><br>
							<input type="file" name="pictures[]" /><br>
							<input type="file" name="pictures[]" /><br>
							<input type="file" name="pictures[]" />
							<input type="hidden" name="MAX_FILE_SIZE" value="2097152" />
							</p>
							
							
						
						</fieldset>

						<fieldset>
							<legend>Contact : </legend>
							
							<p><label for="tel">Téléphone* : </label>
							<input type="tel" id="tel" name="tel" value="" pattern="^[0-9]{9}[0-9]$" required placeholder="Tél au format 0123456789" /></p>

							<p><label for="email">Adresse Email* : </label>
							<input type="email" id="email" name="email" value="" required placeholder="Email" /></p>
							
							<p><label for="motdepasse">Mot de passe* : </label>
							<input type="password" id="motdepasse" name="motdepasse" value="" required placeholder="minimum 6 caractères" pattern=".{6,}" /></p>
							
						</fieldset>
						
						<input type="submit" name="Envoyer" value="Envoyer" />
					</form>
			</div>
<?php 
			}

?>

             
<?php $contenu = ob_get_clean(); ?>

<?php require 'vue/gabarit.php'; ?>