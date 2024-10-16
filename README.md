# Bacasable

## Description
Cette application est une plateforme bacasable en Symfony, conçue pour faciliter l'apprentissage de la création d'entités, de contrôleurs et de dépôts dans un contexte de développement. Elle permet aux utilisateurs de tester et de comprendre le processus de mise en œuvre des opérations CRUD (Créer, Lire, Mettre à jour, Supprimer) en intégrant des formulaires interactifs.

## Prérequis
1. PHP 8
2. Composer
3. Symfony CLI
4. MySQL ou autre base de données

**Remarque** : Vous pouvez utiliser WampServer et installer Composer et Symfony CLI.

##  Instalation
1. Clone project : 
``git clone git@github.com:DayZmooN/symfony_formation.git ``

2. Utilisez Composer pour installer les dépendances nécessaires au projet :``composer install``

3. Modifiez le fichier .env si nécessaire pour la base de données par défaut (n'oubliez pas de remplacer YOUR_PASSWORD par votre propre mot de passe) :
`DATABASE_URL="mysql://root:@127.0.0.1:3306/db_recipe?serverVersion=8.3.0&charset=utf8mb4"`

4. Créez la base de données (si ce n'est pas déjà fait) :
``php bin/console doctrine:database:create``

5. Créez une migration :
``php bin/console make:migration``

6. Exécutez les migrations pour créer les tables nécessaires :
``php bin/console doctrine:migrations:migrate``

7. Démarrez le serveur de développement :
``php bin/console server``

## Utilisation

Après avoir installé l'application et démarré le serveur de développement, accédez à l'application via votre navigateur : `http://127.0.0.1:8000/`.

**Exemple d'utilisation des fonctionnalités CRUD**
1. Créez une recette : `http://127.0.0.1:8000/recettes` ou cliquez sur le bouton "Créer une recette".
- Remplissez le formulaire avec les informations requises, indiquées par un `*`, par exemple :
    - Nom : `Recette de gâteau`
    - Description : `Une délicieuse recette de gâteau au chocolat`

2. Lire les entités :
- Allez dans la section "Liste des recettes" pour voir toutes les recettes créées.
- Cliquez sur une recette pour voir les détails.

3. Mettre à jour une entité :
- Sur la page de détails d'une recette, cliquez sur le bouton "Modifier".
- Modifiez les informations nécessaires, puis cliquez sur "Sauvegarder" pour enregistrer les modifications.

4. Supprimer une entité :
- Dans la section "Liste des recettes", trouvez la recette que vous souhaitez supprimer.
- Cliquez sur le bouton "Supprimer" à côté de la recette.
- Confirmez la suppression dans la fenêtre de confirmation qui apparaît.

**Remarques**
- Assurez-vous que le serveur est en cours d'exécution avant d'accéder à l'application.
- Les erreurs de validation seront affichées si les champs requis ne sont pas remplis correctement lors de la création ou de la mise à jour des entités.
- Vous pouvez effectuer ce genre d'action sur "category" et "product".

## Contact
**Pour la partie contact, vous pouvez utiliser Mailpit pour envoyer et recevoir des messages.**
1. Ouvrez un terminal dans votre projet et utilisez la commande suivante pour le lancer :
`` bin\mailpit.exe ``
2. Ensuite, allez à l'adresse suivante : `http://localhost:8025/`.
3. Retournez sur l'application.
4. Dans l'application web, allez sur la route :  
   `http://127.0.0.1:8000/contact`
5. Remplissez le formulaire de contact.
6. Soumettez le formulaire en cliquant sur le bouton "Envoyer".
7. Allez sur la boîte email à `http://localhost:8025/`.
8. Vous verrez un email reçu (normalement) :)



N'hésite pas à me dire si tu souhaites d'autres modifications ou ajouts !

