# vpr0
laravel 5.4 build

My simple private project, for work, and for training development skills on laravel
## Install steps
first install via [composer](http://getcomposer.org/), [laravel](https://laravel.com)
```
cd /home/lara
composer create-project --prefer-dist laravel/laravel .
```
## Make auth
Simple, auth. Laravel said, this easy, use:
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
Look files database/seeds/roleSeed.php, edit if need, and seed in the database
```
composer dump-autoload
php artisan migrate:refresh
php artisan db:seed
```

## License
The licensed under the [MIT license](http://opensource.org/licenses/MIT).
