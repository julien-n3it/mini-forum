<h1>Projet de Forum V0.1.1</h1>

Description : ce projet permet à des utilisateurs Web de créer des sujets puis de discuter autour de ces derniers.

Il y a une mise à jour basique dans cette version qui permet de discuter non plus sur "Onglet 1" ou "Onglet 2" mais sur "Pour" ou "Contre" 

Je profite de ce commit pour préciser dans le readme qu'il est nécessaire de charger bootstrap et de l'inclure dans le projet car je n'ai inclus que le datetimepicker associé et une librairie mobile-detect.
Ceci pour une raison simple : je ne suis pas sur que mon datetimepicker ou mobile-detect seront rétrocompatibles mais je suis sur que boostrap le sera. J'ai du coup mis un .gitignore dans mon projet qui précise d'ignorer boostrap.
Sinon la vraie nouveauté de ce dernier commit c'est qu'on a changé la charte graphique pour passer des fonds bleus aux fonds rouges.

Ah un dernier commit pour ceux qui voudraient installer ceci sur un serveur PHP / MySQL, ceci implique la création d'une base de données MySQL (cf. include/bdd pour le paramétrage de la connexion).

Cette base de données est présente dans le GIT sur le fichier discussion.sql à la racine. Enjoy :-)