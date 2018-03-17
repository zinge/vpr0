# vpr0

[![Greenkeeper badge](https://badges.greenkeeper.io/zinge/vpr0.svg)](https://greenkeeper.io/)
laravel 5.4 build

My simple private project, for work, and for training development skills on laravel
## Install steps
first install [laravel](https://laravel.com) via [composer](http://getcomposer.org/)
```
cd /home/lara
composer create-project --prefer-dist laravel/laravel .
```
## Make auth
Simple authorization. Laravel suggests using the following command:
```
php artisan make:auth
```

clone me now! [Thnx for idea](http://stackoverflow.com/questions/5377960/whats-the-best-practice-to-git-clone-into-an-existing-folder)
```
git init
git remote add origin https://github.com/zinge/vpr0.git
git fetch
git checkout origin/master -ft
```
and run `composer update`

## Seed default admin
Look files database/seeds/DefaultUser.php, edit if need, and seed in the database
```
composer dump-autoload
php artisan migrate:refresh
php artisan db:seed
```

## License
The licensed under the [MIT license](http://opensource.org/licenses/MIT).
