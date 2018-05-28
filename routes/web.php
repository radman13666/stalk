<?php

/**
 * 
 * This contains all the web routes
 * 
 */
$app->get('/','LoginController:index')->setName('auth.login');
$app->post('/','LoginController:authenticate');
$app->get('/logout','LoginController:logout')->setName('auth.logout');

$app->get('/dashboard','HomeController:index')->setName('dashboard');

$app->get('/register','RegistrationController:create')->setName('auth.register');
$app->post('/register','RegistrationController:store')->setName('auth.store');

$app->get('/users','UserController:index')->setName('user.index');
$app->post('/users','UserController:search')->setName('user.search');
$app->get('/users/{id}/edit','UserController:edit')->setName('user.edit');
$app->put('/users/{id}/edit','UserController:update');
$app->put('/users/{id}/trash','UserController:trashUser')->setName('user.trash');
