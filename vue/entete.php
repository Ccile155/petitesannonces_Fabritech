<header>
	<div id="logo">
		<img 
		<?php 
		fctaffichimage("contenu/images/logo.png" , 0, 100);
		?>
		alt="Logo" id="fichier_logo" />

	</div>
    <div id="titre_principal">
        <h1><?php echo $titre_page; ?></h1>
    </div>
</header>

 <nav>
     <ul>
         <li><a href="index.php">ACCUEIL</a></li>
<!--          <li><a href="../annonces/annonces.php">PETITES ANNONCES</a></li> -->
         <li><a href="../annonces/ajout.php">DÉPOSER UNE ANNONCE</a></li>
<!--          <li><a href="../forums/index.php">FORUM</a></li> -->
     </ul>
 </nav>