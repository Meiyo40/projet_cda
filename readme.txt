Descrption de la réalisation du projet.

Objectif: Réalisation d'un CRUD via une API REST



### Etape 1: Analyse de la demande

Stack: PHP + AltoRouter (simple/léger routeur php, simple classe), back only

J'ai d'abord hésité sur la technologie à utiliser, J2E aurait pu permettre de rapidement mettre en place une API REST mais j'ai principalement utilisé SpringBoot donc j'ai préféré pas perdre de temps et je suis parti sur PHP.

Je n'avais pas utilisé de PHP vanilla depuis longtemps, j'ai voulu faire un peu plus propre donc j'ai utilisé AltoRouter pour gérer le routing, ce n'est pas un framework mais une simple classe pour pas réinventer la roue.

Quelques difficultés de configuration m'ont obligé à m'adapter sur ce projet pour y répondre dans les délais.

Lecture du diagramme pour établir les relations et le besoin en entités.

L'entité User aura des relations oneToMany avec les entités Topic et Post
Chaque Post sera lié à un User et un Topic qui sera lui même lié à une Category.
Chaque Category pourra contenir 0 à X Topic
Chaque Topic pourra contenir 0 à X Post

Je ferais probablement le choix de représenter ces liens en rajoutant un champ en table 
Exemple pour Post => Post.userId Post.topicId

Une des questions que je me pose sur cette API est la précision des données renvoyé ? 
Si je fais un GET sur User, dois je recevoir la liste des posts de ce dernier ? Ou simplement les informations de User ?
Cette réponse changerait l'implémentation des DAO's pour récupérer l'ensemble des relations.

A defaut je choisis la solution courte, si je GET un User, je m'attends uniquement à recevoir un User et ses informations direct (exit les relations qui ne seront qu'en back), pareil avec Post/Topic/Category

Néanmoins, pour respecter le diagramme, du fait des relations existente, pour les méthodes POST et PUT, les informations de relations sont à fournir.
Un Post ou un Topic devant avoir un User, par ex.

### Etape 2: L'objectif

Après la prise de connaissance de la demande, j'établis rapidement dans ma tête une ligne directrice, il a été stipulé dans le mail que je n'aurais pas le temps de finir et faire une API REST complète prendrait en effet un peu de temps, mais je tente ma chance en fournissant au moins une API basique qui répond un minima au standard REST

Le temps manquant et l'idée étant de faire quelque chose au plus simple possible, je me passerais de la rédaction de tests, faute de manque de pratique sur ces derniers en php.

### Etape 3: Mise en place du projet.

Une fois le projet créé, j'ai commencé par structurer le code:
-Premier objectif représenter en code les entités dans l'état le plus simple sans faire les relations.
	-repo entity: Post / Topic / User / Category
	-Création d'un DAOFactory pour récupérer les différents DAO et d'une interface pour servir à l'implentation des méthodes des différents DAO.
	-Création des différents DAO d'entités.
	-Classe Database pour l'accès MySQL.
-La base établit, création du premier controleur (UserController) et des premières routes (GET/GET[id]/POST/PUT/DELETE) sur une classe (Ici User)

### Etape 4: Implémentation

A partir d'ici, le squelette de base est dessiné, je commence donc à implémenter le tout, en commençant par l'entité User et l'api correspondante.

Il faut implémenter le DAO correspondant qui ira query la database.

/! \ Les premières difficultés

La question de l'implémentation dès le départ des relations se pose.
J'ai jamais tenté de faire une approche propre du modèle relationnel en "vanilla", donc je me pose la question de comment faire ça proprement.
Le DAO doit construire les objets depuis les données en BDD, dans le cas de l'utilisateur, il doit donc également query  pour récupérer la liste des Post/Topic où l'utilisateur est intervenu afin de "peupler" les propriétés $posts && $topics qui seront donc 2 tableaux contenant les id de Post et Topic lié à l'utilisateur.

PHP n'a pas de support natif de la méthode PUT pour récupérer les données, comme je n'avais jamais fais d'API REST de cette manière je me suis rendu compte qu'il fallait faire un peu de bricolage en utilisant la méthode file_get_contents pour récupérer une string contennant les variables pour ensuite faire un json_decode($data) et accéder à ces données comme à un tableau associatif. C'est tout bête dit comme ça mais comme je suis arrivé là dessus assez tard j'ai perdu beaucoup de temps à vouloir faire marcher des solutions plus complexe inutilement à coup d'horrible regex...
Une fois compris le coup du file_get_contents -> json_decode, la gestion de la méthode PUT est implémenté correctement et tout s'est bien passé.

Une fois l'API de la première entity (User) implémenté, tout est allé plus vite forcément, le code de base est là, il suffit ensuite de l'adapater aux différentes entités.
A présent pour faire les choses bien, je devrais faire un système relationnel plus complexe, mais je ne suis pas certains d'avoir le temps de me le permettre donc je vais faire basic, l'objectif premier c'est que ça marche.
De même, ca n'a pas été demandé, donc je vais me passer de faire un système d'authorization/authentication, si j'ai le temps je ferais simplement une clé API hardcoder (en url ?api=key) pour démontrer le concept.

Une fois les différents DAO/Routes implémenté, j'ai ajouté les relations simple à l'API.
Ainsi en faisant un GET User, contrairement à ce que j'avais dis au début, j'affiche les TopicS et PostS qui sont lié à l'utilisateur. (De même avec toutes les entités).
Si aucune relation, les champs seront seront des tableaux vide.

On notera que par principe le GET /user/x ne renverra pas le champ password, même hash...

A partir de là, l'API de base est je pense présente, on peut bien sûr aller beaucoup plus loin en s'assurant du standard sur les réponses http, la résilience avec l'utilisation de try/catch et des exceptions, un système d'auth/token/csrf, la sécurisation du contenu en passant avec du htmlpurifier etc...