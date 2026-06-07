## Tester l'API avec Postman

Une collection Postman prête à l'emploi est fournie : [`docs/postman_collection.json`](docs/postman_collection.json).

1. Démarrer le serveur : `php artisan serve` (l'API écoute sur `http://localhost:8000`).
2. Dans Postman : bouton **Import**, puis sélectionner le fichier `docs/postman_collection.json`.
3. Les requêtes des deux entités (**Catégories** et **Produits**) sont prêtes à l'emploi. La variable de collection `{{base}}` pointe sur `http://localhost:8000/api` (modifiable dans l'onglet *Variables*).
