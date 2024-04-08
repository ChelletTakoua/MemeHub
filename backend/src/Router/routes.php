<?php
/**
 *  * This file contains all the routes of the application
 *
 */

global $router;

$router->get('/', function (){echo "welcome to the homepage GET";},['guest']);
$router->post('/', function (){echo "welcome to the homepage POST";},['guest']);

$router->options('*', function (){} , ['guest']);


$router->get('/test', 'TestController@testMethod',['guest'], true);
$router->get('/test/:id', 'TestController@testMethod',['guest'], true);
$router->post('/test', 'TestController@testMethodPost',['guest'], true);



$router->post('/login', "AuthController@login", ['guest']);
$router->post('/register', "AuthController@register", ['guest']);
$router->post('/logout', "AuthController@logout", ['user', 'admin']);

$router->get('/checkAuth', "AuthController@checkAuth", ['guest','user', 'admin']); // return the user object if the user is logged in (null if not)

// route to verify jwk token and return the user object
$router->post('/verifyToken', "AuthController@verifyToken", ['guest']);

// routes to send email of forgot password, and route for reset password with token
$router->post('/forgotPassword/:username', "UserController@forgotPassword", ['guest']); // send email with token
$router->post('/resetPassword', "UserController@resetPassword", ['guest']); // reset password with token

// verify email after registration
$router->post('/sendVerificationEmail/:username', "UserController@sendVerificationEmail", ['guest']); // send verification email
$router->post('/verifyEmail', "UserController@verifyEmail", ['guest']); // verify email (token in the url?)




$router->get('/user/:id', "UserController@getUserProfile", ['guest','user', 'admin']); // get user profile
$router->post('/user/profile/modifyPassword', "UserController@modifyPassword", ['user', 'admin']); // modify user password
$router->post('/user/profile/edit', "UserController@editProfile", ['user', 'admin']); // edit user profile (username, email, ...) (not password), the modifications are sent in the body of the request
$router->delete('/user/profile', "UserController@deleteProfile", ['user', 'admin']);


$router->get('/memes', "MemeController@getAllMemes", ['guest','user', 'admin']);
$router->get('/memes/:id', "MemeController@getMemeById", ['user', 'admin']);
$router->get('/memes/user/:id', "MemeController@getUserMemes", ['guest','user', 'admin']);
$router->get('/memes/:id/likes', "MemeController@getMemeNbLikes", ['guest','user', 'admin']);
$router->post('/memes', "MemeController@addMeme", ['user', 'admin']);
$router->post('/memes/:id/modify', "MemeController@modifyMeme", ['user', 'admin']); // modify meme (title, template, ...)
$router->post('/memes/:id/like', "MemeController@likeMeme", ['user', 'admin']);
$router->post('/memes/:id/dislike', "MemeController@dislikeMeme", ['user', 'admin']);
$router->post('/memes/:id/report', "MemeController@reportMeme", ['user', 'admin']);
$router->delete('/memes/:id', "MemeController@deleteMeme", ['user', 'admin']); // CHECK IF THE USER IS THE OWNER OF THE MEME


$router->get('/templates', "TemplateController@getAllTemplates", ['user', 'admin']); // get all templates
$router->get('/templates/:id', "TemplateController@getTemplateById", ['user', 'admin']); // get template by id
$router->get('/admin/templates/url/:url', "TemplateController@getTemplateByUrl", ['user', 'admin']);
//$router->post('/templates', "TemplateController@addTemplate", ['admin']); // add a template
//$router->delete('/templates/:id', "TemplateController@deleteTemplate", ['admin']); // delete a template

$router->get('/admin', "AdminController@getAdminDashboard", ['admin']); // get admin dashboard
$router->get('/admin/users', "AdminController@getAllUsers", ['admin']); // get all users
$router->get('/admin/users/:id', "AdminController@getUserProfile", ['admin']); // get user by id
$router->put('/admin/users/:id/role', "AdminController@changeUserRole", ['admin']); // change user role
$router->delete('/admin/users/:id/delete', "AdminController@deleteUser", ['admin']); // delete user
$router->delete('/admin/memes/:id/delete', "AdminController@deleteMeme", ['admin']); // delete meme


$router->get('/admin/reports', "ReportController@getAllReports", ['admin']); // get all reports
$router->post('/admin/reports/:id/resolve', "ReportController@resolveReport", ['admin']); // resolve report (delete meme)
$router->post('/admin/reports/:id/ignore', "ReportController@ignoreReport", ['admin']); // ignore report
$router->post('/admin/reports/:id/delete', "ReportController@deleteReport", ['admin']); // delete report


//checks if devMode is active
$router->get('/admin/devmode', "AdminController@devMode", ['admin']);


//These routes are for debugging purposes
$router->get('/admin/sessionHistory', "../src/Debugging/SessionHistory.php", ['guest'], true);
$router->get('/admin/requestDetails', "../src/Debugging/requestDetails.php", ['guest'], true);



$router->get('/code/:code', function($code){
    http_response_code($code);
    echo "response code: $code";
}, ['guest']);



