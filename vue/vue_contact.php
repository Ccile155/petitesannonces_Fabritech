<?php ob_start(); ?> 
<?php $titre_page="Contact"; ?>

<article>

<p>Ce site à été réalisé à l'aide de <a href="http://bluefish.openoffice.nl/">Bluefish</a>.
<!-- et <a href="http://fluxbb.fr/">Fluxbb</a>.</p>
<p>Pour toutes demandes d'informations, veuillez utiliser le <a href="../forums/index.php">Forum</a>. 
 -->
</p>

</article>


<?php $contenu = ob_get_clean(); ?>

<?php require 'vue/gabarit.php'; ?>