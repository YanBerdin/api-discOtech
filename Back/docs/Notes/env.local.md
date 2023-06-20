# login : app
# mdp : !ChangeMe!
# le nom de la BDD : app (le 2eme)

# Malheureusement on utilise pas MySQL mais mariaDB, il faut donc absolument modifier la version du serveur
# serverVersion=8
# serverVersion=mariadb-10.3.25
# * j'ai obtenu ma version mariaDB avec la commande `mysql -V`
# mysql  Ver 15.1 Distrib 10.3.25-MariaDB, for debian-linux-gnu (x86_64) using readline 5.2
DATABASE_URL="mysql://disco:disco@127.0.0.1:3306/disco?serverVersion=mariadb-10.3.25&charset=utf8mb4"
# * pour voir la BDD de test

# Exemple:
# DATABASE_URL="mysql://explorateur:Ereul9Aeng@127.0.0.1:3306/oflix_test?serverVersion=mariadb-10.3.25&charset=utf8mb4"
