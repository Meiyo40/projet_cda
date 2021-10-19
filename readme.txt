Descrption de la réalisation du projet.

Objectif: Réalisation d'un CRUD via une API REST



### Etape 1: Analyse de la demande

Stack: PHP + AltoRouter (simple/léger routeur php) + Composer, back only

J'ai d'abord hésité sur la technologie à utiliser, J2E aurait pu permettre de rapidement mettre en place en API REST mais j'ai principalement utilisé SpringBoot donc j'ai préféré pas perdre de temps et je suis parti sur PHP.

Je n'avais pas utilisé de PHP vanilla depuis longtemps, j'ai voulu faire un peu plus propre donc j'ai utilisé AltoRouter pour gérer le routing, ce n'est pas un framework mais une simple classe pour pas réinventer la roue.

Quelques difficulté de configuration m'ont obligé à m'adapter sur ce projet pour y répondre dans les délais.

Lecture du diagramme pour établir les relations et le besoin en entités.

L'entité User aura des relations oneToMany avec les entités Topic et Post
Chaque Post sera lié à un User et un Topic qui sera lui même lié à une Category.
Chaque Category pourra contenir 0 à X Topic
Chaque Topic pourra contenir 0 à X Post

Je ferais probablement le choix de représenter ces liens en rajoutant un champ en table 
Exemple pour Post => Post.userId Post.topicId

### Etape 2: Mise en place du projet.

Une fois le projet créé, j'ai commencé par structurer le code:
-Premier objectif représenter en code les entités dans l'état le plus simple sans faire les relations.
	-repo entity: Post / Topic / User / Category
	-Création d'un DAOFactory pour récupérer les différents DAO et d'une interface pour servir à l'implentation des méthodes des différents DAO.
	-Création des différents DAO d'entités.
	-Classe Database pour l'accès MySQL.
-La base établit, création du premier controleur (UserController) et des premières routes (GET/GET[id]/POST/PUT/DELETE) sur une classe (Ici User)

### Etape 3: Implémentation

A partir d'ici, le squelette de base est dessiné, je commence donc à implémenter le tout, en commençant par l'entité User et l'api correspondante.

Il faut implémenter le DAO correspondant qui ira query la database.

/! \ Les premières difficultés

La question de l'implémentation dès le départ des relations se pose.
J'ai jamais tenté de faire une approche propre du modèle relationnel en "vanilla", donc je me pose la question de comment faire ça proprement.
Le DAO doit construire les objets depuis les données en BDD, dans le cas de l'utilisateur, il doit donc également query  pour récupérer la liste des Post/Topic où l'utilisateur est intervenu afin de "peupler" les propriétés $posts && $topics qui seront donc 2 tableaux contenant les id de Post et Topic lié à l'utilisateur.
