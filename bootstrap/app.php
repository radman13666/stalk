<?php 
/**
 * 
 * Bootstraping the application
 * 
 */
session_start();

require_once  __DIR__ .'/../vendor/autoload.php';

 use Respect\Validation\Validator as v;

//  error_reporting(E_ALL);
// ini_set('display_errors','On');

 $app = new \Slim\App([
     'settings' => [
         'displayErrorDetails' => true,
         'db' => [
                    'driver'    => 'mysql',
                    'host'      => 'localhost',
                    'database'  => 'bursary',
                    'username'  => 'root',
                    'password'  => 'HJy2]>kWN@474B+!+PsKg3',
                    'charset'   => 'utf8',
                    'collation' => 'utf8_unicode_ci',
                    'prefix'    => ''
         ],
     ]
 ]);

 /**
  * Getting slim container
  */

  $container = $app->getContainer();

  /**
   * Attaching slim twig view to the container
   */

  $container['view'] = function($container){
    $view = new \Slim\Views\Twig(__DIR__.'/../resources/Views',[
        'cache'=> false,
    ]);

    //Adding twig extension
    $view->addEXtension( new \Slim\Views\TwigExtension(
        $container->router,
        $container->request->getUri()
    ));

    /**
     * Setting global variabless
     */
    $view->getEnvironment()->addGlobal('helper',[
        'roles'      => $container->helper->allRoles(),
        'districts'  => $container->helper->allDistricts(),
        'karamojadistricts'  => $container->helper->karamojaDistricts(),
        'subjects'   => $container->helper->allSubjects(),
        'levels'     => $container->helper->allLevels(),
        'secondary'  => $container->helper->allSecondary(),
        'tertiary'   => $container->helper->allTertiary(),
        'university' => $container->helper->allUniversity(),
        'funders'    => $container->helper->allFunders(),
        'banks'      => $container->helper->allBanks(),
        'hostels'    => $container->helper->allHostels(),
        'courses'    => $container->helper->allCourses(),
        'schools'    => $container->helper->allSchools(),
        'forms'      => $container->helper->allForms(),
        'logo'       => $container->helper->logo(),
        'tribes'     => $container->helper->allTribes(),
        'subcounties'=> $container->helper->allSubcounties(),
       
    ]);

    //Auth
    $view->getEnvironment()->addGlobal('auth',[
        'user'          => $container->auth->user(),
        'check'         =>  $container->auth->check(),
        'permission'    => $container->auth->permission(),
        'isStudent'     => $container->auth->isStudent(),
        'studentProfile'=> $container->auth->studentProfile()
    ]);

    // students
    $view->getEnvironment()->addGlobal('students',[
        'drafts' => $container->students->drafts()
    ]);

    // flash message
    $view->getEnvironment()->addGlobal('flash',$container->flash);

    return $view;
};

/**
 * 
 * Setting up eloquent
 * 
 */

$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['db']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

/**
 * Booting query builder
 */
$container['db'] = function($container) use ($capsule) {
    return $capsule;
};


/**
 * Helper class
 */

 $container['helper'] = function($container){
     return new \App\Helpers\Helper;
 };

 $container['files'] = function($container){
    return new \App\Helpers\Files;
 };
//  student helper
$container['students'] = function($container)
{
    return new \App\Helpers\Students;
};

 /**
  * Respect validation class
  */

  $container['Validator'] = function($container){
      return new \App\Validation\Validator;
  };

//   Flash message
$container['flash'] = function($container){
    return new \Slim\Flash\Messages;
};
// Form Request

$container['FormRequest'] = function($container){
    return new \App\FormRequest\FormRequest;
};

/**
 * Slim csrf
 */
$container['csrf'] = function($container){
    return new \Slim\Csrf\Guard;
};

// Auth class
$container['auth'] = function($container){
    return new \App\Auth\Auth;
};

/**
 * LOg
 */
$container['log'] = function($container){
    return new \App\Log\Log;
};

/**
 * Registering all middleware
 */
$app->add( new \App\Middleware\InputErrorsMiddleware($container));
// $app->add( new \App\Middleware\CsrfMiddleware($container));
$app->add( new \App\Middleware\OldInputMiddleware($container));
// $app->add( new \App\Middleware\LogMiddleware($container));


// $app->add($container->csrf);



v::with("App\\Validation\\Rules\\");

/**
 * Requiring all controllers
 */
require __DIR__ .'/../config/BoostrapController.php';

// Requiring all routes
 require_once __DIR__ .'/../routes/web.php';
 require_once __DIR__ .'/../routes/api.php';

