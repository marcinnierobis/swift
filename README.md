## Installation

1. Run `composer install`.
2. Go to config directory and create app_local.php base on the app_local.example.php
3. Create empty DB and put the name to the app_local.php
4. Run `bin/cake init` to run migrations and seed the DB.
5. Password for testowy.user@mail.com is `SwifT1.1#`.
6 a) If you want to change the email for test, please change it in the `config/Seeds/UsersSeed.php`, then run the command from point 3 again.
7. CSV file with users is called `users-to-import.csv`.
8. Have fun!
