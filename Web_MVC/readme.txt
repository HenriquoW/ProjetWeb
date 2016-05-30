pour installer le site il faut modifier la variable $_SERVER['Racine'] dans le fichier controleur.php qui est dans le dossier controleur, la variable permet de stocker le chemin exact du dossier du site
a partir du dossier racine du serveur

exemple:mon dossier racine du serveur = /home/adrien/public
	mon dossier contenant le site /home/adrien/public/ProjetWeb/Web_MVC
	valeur de la variable $_SERVER['Racine'] = $_SERVER["DOCUMENT_ROOT"]."/ProjetWeb/Web_MVC"

pour modifier les informations de connexion a la base de données il faut modifier les variables du fichier class_bdd.php qui est dans le dossier Core/BDD/


pour tous les utilisateur inscrit dans la bdd le mot de passe est 123

