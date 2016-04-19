BDD::getInstance()->types() //permet de recuperer les types (nom) des managers

BDD::getInstance()->getManager($Type) //permet de recuperer le manager en fonction du type


10 Objet :
Adherent, Club_Organisateur, Competiteur, Competition, Course, Equipe, Message, Palmares, Utilisateur, Voyage

9 Tableau :
Categorie, Droit_Acces, Role, Sexe, Specialite, Tache, Type_Competition, Type_Specialite, Type_Voyage

Pour recuperer des infos de la basse :

	-Objet : dans le fichier qui decrit l'objet (class_NOMOBJET.php) il y a une fonction load qui prend en parametre un tableau et retourne l'objet

	Exemple :
		Utilisateur
		$info['Id'] = 1; ou $info['Mail'] = "ddd@gmsdiu.fr";
		loadUtilisateur($info);

	Description fonction load et tableau
 		Adherent : loadAdherent($info) | $info['Id'],$info['Mail']
		Club_Organisateur : loadClub($info) | $info['Id'],$info['Nom']
		Competiteur : loadCompetiteur($info) | $info['Id'],$info['Mail']
		Competition : loadCompetition($info) | $info['Id']
		Course : loadCourse($info) | $info['Id']
		Equipe : loadEquipe($info) | $info['Id']
		Message : loadMessage($info) | $info['Id']
		Palmares : loadPalmares($info) | $info['Id']
		Utilisateur : loadUtilisateur($info) | $info['Id'],$info['Mail']
		Voyage : loadVoyage($info) | $info['Id']

	-Tableau : utilise la function getManager()->getId() retourne le tableau
	
	Exemple :
		Sexe
		$id =1;
		BDD::getInstance()->getManager("Sexe")->getId($id)	

	Description cles des tableaux:
		Categorie : Id,Nom
		Droit_Acces : Id,Nom
		Role : Id,Titre
		Sexe : Id,Type
		Specialite : Id,Nom
		Tache : Id,Nom
		Type_Competition : Id,Nom,Selectif
		Type_Specialite : Id,Nom
		Type_Voyage : Id,Nom

Pour ajouter ou mettre a jour un objet dans la basse :
	
	Il faut utiliser la fonction save de l'objet qui prend en parametre un boolean $bupdate qui doit valoir vrai pour mettre a jour un objet sinon faux pour le creer

Pour supprimer un objet de la basse : //pas encore fait 
	
	Il faut utiliser la fonction remove de l'objet
	

