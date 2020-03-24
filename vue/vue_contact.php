<?php ob_start(); ?> 
<?php $titre_page="Contact"; ?>

<article>

<p>
Ceci est la version 0.1.0 de <a href="https://framagit.org/anto1ne/petitesannonces">PetitesAnnonces</a>.
</p>

<p>Ce site à été réalisé à l'aide de <a href="http://bluefish.openoffice.nl/">Bluefish</a>.
<!-- et <a href="https://fluxbb.fr/">Fluxbb</a>.</p>
<p>Pour toutes demandes d'informations, veuillez utiliser le <a href="../forums/index.php">Forum</a>. 
 -->
</p>

<p>Pour plus de renseignements ou pour signaler un bug, rendez-vous sur le site internet de 
<a href="https://framagit.org/anto1ne/petitesannonces">PetitesAnnonces</a> et sur le 
<a href="https://framagit.org/anto1ne/petitesannonces/-/wikis/home">Wiki.</a>
</p>



</article>


<?php $contenu = ob_get_clean(); ?>

<?php require 'vue/gabarit.php'; ?>
