INSERT UTILISATEUR (MDP_UTILISATEUR, NOM_UTILISATEUR, PRENOM_UTILISATEUR, MAIL_UTILISATEUR, ADMIN) VALUES 
	('t4bCV9NW', 'Charlon', 'Yuna', 'yuna.charlon@hotmail.fr', 1),
	('456', 'Montgrandi', 'Romain', 'r.montgrandi@gmail.com', 0);

	
INSERT RUBRIQUE (LIBELLE_RUBRIQUE) VALUES 
	('Nouveautés'),
	('Décoration'),
	('Bijoux'),
	('Signalétique'),
	('Tables'),
	('Funéraire'),
	('Accessoires');
			
INSERT ANNONCE (ID_UTILISATEUR, ID_RUBRIQUE, EN_TETE_ANNONCE, CORPS_ANNONCE)
	VALUES 
	(1, 2, 'Geïsha', 'Pièce unique inspirée par la culture asiatique et plus particulièrement japonaise'),
	(1, 2, 'Dieu Hindou', 'Pièce unique représentant un dieu hindou en position divine'),
	(1, 2, 'Eléphant', 'Dessous de plat atypique et moderne'),
	(2, 3, 'Collier design', 'Collier unique en lave émaillée et argent'),
	(2, 3, 'Bracelet DVO', 'Bracelet original en lave émaillée et argent'),
	(1, 4, 'Numéro de rue', 'Numéro de rue unique et durable en lave émaillée'),
	(2, 4, 'Plaque commerciale', 'Plaque commerciale réalisée pour le Relais des Capucines à Largnac (15210)'),
	(1, 5, 'Table ronde', 'Magnifique table ronde avec plateau en lave émaillée'),
	(2, 6, 'Plaque funéraire personnalisable', 'Possibilité de rajouter une photographie, une image ou un message. Entièrement personnalisable'),
	(1, 7, 'Support pour plaque', 'Support pour maintenir une plaque, idéal pour valoriser la plaque en élément de décoration');
