<?php
/**
 *  * This file contains all the routes of the application
 *
 */

global $router;

$router->get('/', function (){echo "welcome to the homepage GET";},['guest']);
$router->post('/', function (){echo "welcome to the homepage POST";},['guest']);


// use this route to test your code (len t7eb ttesti ayy haja)  Yaa Sioua meghir ma tbaddel fl index.php 5allih rayedh!!
$router->get('/test', 'TestController@testMethod',['guest']);
$router->post('/test', 'TestController@testMethodPost',['guest']);

$router->get('/example', "ExampleController@referenceMethod", ['user', 'admin']); //TODO: to remove



$router->post('/login', "AuthController@login", ['guest']);
$router->post('/register', "AuthController@register", ['guest']);
$router->post('/logout', "AuthController@logout", ['user', 'admin']);

$router->get('/user/checkAuth', "AuthController@checkAuth", ['user', 'admin']); // return the user object if the user is logged in (null if not)

// routes to send email of forgot password, and route for reset password with token
$router->post('/forgotPassword', "AuthController@forgotPassword", ['guest']); // send email with token
$router->post('/resetPassword', "AuthController@resetPassword", ['guest']); // reset password with token

// verify email after registration
$router->get('/sendVerificationEmail', "AuthController@sendVerificationEmail", ['user', 'admin']); // send verification email
$router->get('/verifyEmail', "AuthController@verifyEmail", ['guest']); // verify email (token in the url?)


$router->get('/user/:id', "UserController@getUserProfile", ['user', 'admin']); // get user profile
$router->post('/user/profile/modifyPassword', "UserController@modifyPassword", ['user', 'admin']); // modify user password
$router->post('/user/profile/edit', "UserController@editProfile", ['user', 'admin']); // edit user profile (username, email, ...) (not password), the modifications are sent in the body of the request
$router->delete('/user/profile', "UserController@deleteProfile", ['user', 'admin']);



$router->get('/memes', "MemeController@getAllMemes", ['user', 'admin']);
$router->get('/memes/:id', "MemeController@getMemeById", ['user', 'admin']);
$router->get('/memes/user/:id', "MemeController@getUserMemes", ['user', 'admin']);
$router->post('/memes', "MemeController@addMeme", ['user', 'admin']);
$router->post('/memes/:id/like', "MemeController@likeMeme", ['user', 'admin']);
$router->post('/memes/:id/dislike', "MemeController@dislikeMeme", ['user', 'admin']);
$router->post('/memes/:id/report', "MemeController@reportMeme", ['user', 'admin']);
$router->delete('/memes/:id', "MemeController@deleteMeme", ['user', 'admin']); // CHECK IF THE USER IS THE OWNER OF THE MEME


$router->get('/templates', "TemplateController@getAllTemplates", ['user', 'admin']); // get all templates
$router->get('/templates/:id', "TemplateController@getTemplateById", ['user', 'admin']); // get template by id
$router->post('/templates', "TemplateController@addTemplate", ['admin']); // add a template
$router->delete('/templates/:id', "TemplateController@deleteTemplate", ['admin']); // delete a template


$router->get('/admin/users', "AdminController@getAllUsers", ['admin']); // get all users
$router->get('/admin/users/:id', "AdminController@getUserProfile", ['admin']); // get user by id
$router->post('/admin/users/:id/role', "AdminController@changeUserRole", ['admin']); // change user role
$router->post('/admin/users/:id/delete', "AdminController@deleteUser", ['admin']); // delete user

$router->get('/admin/reports', "AdminController@getAllReports", ['admin']); // get all reports
$router->post('/admin/reports/:id/resolve', "AdminController@resolveReport", ['admin']); // resolve report (delete meme)
$router->post('/admin/reports/:id/ignore', "AdminController@ignoreReport", ['admin']); // ignore report
$router->post('/admin/reports/:id/delete', "AdminController@deleteReport", ['admin']); // delete report

$router->post('/admin/memes/:id/delete', "AdminController@deleteMeme", ['admin']); // delete meme








