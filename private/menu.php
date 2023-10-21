<?php
$texteBienvenue = 'Bienvenue dans le menu de gestion de bondprice. 
Vous pouvez consulter vos clients qui ont souscrit à votre service,
générer des codes d\'accès, voir les dernières connexions des administrateurs 
et télécharger la base de données.
En cas de problème, contactez le développeur dont les coordonnées se trouvent tout en  bas de la barre latérale.';

$html = '
<div class="text-bienvenue"><pre>' . $texteBienvenue . '</pre></div>
';

echo $html;
?>
