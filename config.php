<?php // config.php :: Infos pour l'installation du script à remplir.

$dbsettings = Array(
        "server"        => "localhost",       // Nom du serveur MySQL. (Default: localhost)
        "user"          => "rpgillusion",     // Nom de votre login MySQL.
        "pass"          => "mickael",         // Nom de votre password MySQL.
        "name"          => "rpgillusion-db1", // Nom de votre base MySQL.
        "secretword"    => "rpg",             // Mot secret utilisé lors de la mise a jour des cookies.       

// Pour éviter les problèmes MYSQL ne changez pas le préfixe
		"prefix"        => "rpg");             // Prefixe des tables MySQL


?>