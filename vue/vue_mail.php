<?php ob_start(); ?> 
<?php $titre_page="Contacter le propriétaire"; ?>
<?php

if (isset($_POST["nom_personne"]) AND isset($_POST["email"]) AND isset($_POST["id"]) AND isset($_POST["message"]) ) 
{
	$ann=new Annonce($_POST["id"]);
	
	$destinataire = $ann->renderEmail();
	// Pour les champs $expediteur / $copie / $destinataire, séparer par une virgule s'il y a plusieurs adresses
	$expediteur = htmlspecialchars($_POST['email']);
	$nom_expediteur=htmlspecialchars($_POST["nom_personne"]);
	$objet = "[Annonce] ".$ann->renderTitre();

	$headers  = 'MIME-Version: 1.0' . "\n"; // Version MIME
	//$headers .= 'Content-type: text/html; charset=utf-8\n'; // l'en-tete Content-type pour le format HTML
	
	$headers .='Content-Type: text/plain; charset="utf-8"'."\n"; // ici on envoie le mail au format texte encodé en UTF-8
	$headers .='Content-Transfer-Encoding: 8bit'."\n"; // ici on précise qu'il y a des caractères accentués
	
	$headers .= 'Reply-To: '.$expediteur."\n"; // Mail de reponse
	$headers .= 'From: '.$nom_expediteur.' <'.$expediteur.'>'."\n"; // Expediteur
	$headers .= 'Delivered-to: '.$destinataire."\n"; // Destinataire    
	//$headers .= "Bcc: contact@mail.net" . "\n"; // mail en copie cachée 
	
	//$message = '<div style="width: 100%; text-align: center; font-weight: bold"> Bonjour'.$_POST['name'].'! \n'.$_POST['message'].'</div>';

	$message="\n";
	$message.="Message de ".$nom_expediteur." ".$expediteur."\n";
	if (isset($_POST["tel"]))
	{
	$message.="Téléphone : ".htmlspecialchars($_POST["tel"])."\n";
	}
	$message.="\n";
	$message.=$_POST['message']."\n";
	
	//echo $headers;
	//echo $message;

	$nom_expediteur_valid=(strlen($nom_expediteur)>3 AND strlen($nom_expediteur)<100 ) ;
	$message_valid=(strlen($_POST['message'])>9 AND strlen($_POST['message'])<2000);
	$email_valid=(preg_match("#^[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}$#", $expediteur));
   
   //echo $nom_expediteur;
   //echo var_dump($nom_expediteur_valid);
   
	echo "<article>";
	if ($nom_expediteur_valid AND $message_valid AND $email_valid )
	{
		if (mail($destinataire, $objet, $message, $headers)) // Envoi du message
		{
		    echo "<p><strong>Votre message a bien été envoyé.</strong></p>";
		}
		else // Non envoyé
		{
		    echo "<p><strong>Votre message n'a pas pu être envoyé.</strong></p>";
		}
		
	}
	else 
	{
		echo "<p><strong>Mauvaises coordonnées ou message trop court.</strong></p>";
	}
	echo "</article>";


}
?>

<?php $contenu = ob_get_clean(); ?>

<?php require 'vue/gabarit.php'; ?>