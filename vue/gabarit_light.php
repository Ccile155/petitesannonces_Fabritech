<!DOCTYPE html>
<html lang="fr">

	 <head>
	  <meta charset="utf-8" />
	  <link rel="stylesheet" href="contenu/style.css" />
	  <title>Petites Annonces - <?php echo $titre_page; ?> </title>
	  
	  <link rel="icon" type="image/png" href="contenu/images/favicon.png" >
	  
 	 </head>
 	 
 	 
    <body>
    		<div id="bloc_page">

                
            <?php
            	//require "vue/entete.php";
            	require "vue/header.php";
					// contenu web
				   echo $contenu;
					
					//require "vue/pieddepage.php";
            ?>


        </div>
    </body>
</html>