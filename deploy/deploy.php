<?php
/**
 * Part of CodeIgniter Deployer.
 * Original script by Kenji Suzuki <https://github.com/kenjis>
 *
 * @author     Stefan Ashwell <https://github.com/stef686>
 * @license    MIT License
 * @copyright  2018 Stefan Ashwell
 * @link       https://github.com/stef686/codeigniter-deployer
 */

 namespace Deployer;

 require 'recipe/codeigniter.php';

 // Project name
 set('application', 'my_project');

 // Project repository
 set('repository', 'git@github.com:org/your-codeigniter-app.git');

 // [Optional] Allocate tty for git clone. Default value is false.
 set('git_tty', true);

 // Shared files/dirs between deploys
 add('shared_files', []);
 add('shared_dirs', []);

 // Writable dirs by web server
 add('writable_dirs', []);

 // Hosts
 host('your.server.example.com')
     ->stage('production')
     ->port(22)
     ->set('branch', 'master')
     ->set('deploy_path', '/var/www/your-codeigniter-app');

 // Tasks
 task('build', function () {
     run('cd {{release_path}} && build');
 });

 // task('deploy:vendors-dev', function () {
 //    if (commandExist('composer')) {
 //        $composer = 'composer';
 //    } else {
 //        run("cd {{release_path}} && curl -sS https://getcomposer.org/installer | php");
 //        $composer = 'php composer.phar';
 //    }
 //
 //    run("cd {{release_path}} && $composer install --verbose --prefer-dist --no-progress --no-interaction");
 // })->desc('Installing vendors including require-dev');

 // task('deploy:migrations', function () {
 //      run("cd {{release_path}} && php cli migrate");
 // })->desc('Run migrations');

 //task('deploy:phpunit', function () {
 //    try {
 //        run("cd {{release_path}}/application/tests && php ../../vendor/bin/phpunit");
 //    } catch (\RuntimeException $e) {
 //        // test fails
 //        run("cd {{deploy_path}} && if [ ! -d releases-failed ]; then mkdir releases-failed; fi");
 //        run("mv {{release_path}} {{deploy_path}}/releases-failed");
 //        run("cd {{deploy_path}} && if [ -h release ]; then rm release; fi");
 //
 //        throw $e;
 //    }
 //})->desc('Run PHPUnit');

 //task('deploy:security-checker', function () {
 //     run("cd {{release_path}} && vendor/bin/security-checker security:check composer.lock");
 //})->desc('Run SensioLabs Security Checker');


 /**
  * Main task
  */
 task('deploy', [
     'deploy:info',
     'deploy:prepare',
     'deploy:lock',
     'deploy:release',
     'deploy:update_code',
     'deploy:vendors',
     //'deploy:vendors-dev',
     //'deploy:phpunit',
     //'deploy:security-checker',
     'deploy:shared',
     //'deploy:migrations',
     'deploy:symlink',
     'deploy:unlock',
     'cleanup',
 ])->desc('Deploy your project');

 // [Optional] if deploy fails automatically unlock.
 after('deploy:failed', 'deploy:unlock');
