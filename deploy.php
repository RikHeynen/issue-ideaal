<?php
namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'Ideaal');

// Set php version
set('bin/php', function () {
    return '/opt/plesk/php/8.1/bin/php';
});

// Project repository
set('repository', 'git@github.com:Appart-Media/ideaal.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', false);

// Shared files/dirs between deploys
add('shared_files', ['.env']);
add('shared_dirs', ['storage', 'public/assets']);

// Writable dirs by web server
add('writable_dirs', [
    'bootstrap/cache',
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);

// Hosts
// Live
/* host('__LIVE_HOST__')
    ->stage('master')
    ->set('deploy_path', '/var/www/deploy')
    ->set('bin/php', function () {
        return 'php';
    })
    ->set('bin/composer', function () {
        return '{{bin/php}} /usr/local/bin/composer';
    })
    ->set('branch', 'master')
    ->user('__LIVE_SSH_USER__')
    ->forwardAgent(); */

// Acceptance
host('server.appartdev.nl')
    ->stage('acceptance')
    ->set('bin/composer', function () {
        return '{{bin/php}} /usr/local/psa/var/modules/composer/composer.phar';
    })
    ->set('deploy_path', '/var/www/vhosts/server.appartdev.nl/ideaal.appartdev.nl/deploy')
    ->set('branch', 'acceptance')
    ->user('appart')
    ->forwardAgent();

// Tasks
task('build', function () {
    run('cd {{release_path}} && build');
});

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.
before('deploy:symlink', 'artisan:migrate');
