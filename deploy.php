<?php
namespace Deployer;

require 'recipe/laravel.php';

// Nombre del proyecto

set('application', 'backoffice');

// Config

set('repository', 'https://github.com/JorgeDAW12/backoffice.git');

add('shared_files', ['database/database.sqlite', '.env']);
add('shared_dirs', ['bootstrap/cache', 'storage']);
add('writable_dirs', ['bootstrap/cache', 'storage']);

// Hosts

host('3.90.100.233')
    ->set('remote_user', 'backoffice-deployer')
    ->set('identity_file', '~/.ssh/id_rsa')
    ->set('deploy_path', '/home/backoffice-deployer/var/www');

set('keep_releases', 3);

// Tasks

task('build', function () {
    run('cd {{release_path}} && build');
});

task('reload:php-fpm', function () {
    run('sudo /etc/init.d/php8.3-fpm restart');
});


// Hooks

after('deploy:failed', 'deploy:unlock');
after('deploy', 'reload:php-fpm');

before('deploy:symlink', 'artisan:migrate');
