<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = 'login';
$route['404_override'] = 'erreur';


$route['back/traitement_admin/supprimer_traitement/(:num)'] = 'back/traitement_admin/supprimer_traitement/$1';
$route['front/accueil_categories/(:num)'] = 'front/accueil_categories/accueil_categories/$1';
$route['front/accueil_traitement/(:num)'] = 'front/accueil_traitement/accueil_traitement/$1';
$route['front/accueil_operation/(:num)'] = 'front/accueil_operation/accueil_operation/$1';
$route['front/accueil_processus/(:num)'] = 'front/accueil_processus/accueil_processus/$1';
$route['front/accueil_action/(:num)'] = 'front/accueil_action/accueil_action/$1';
/* End of file routes.php */
/* Location: ./application/config/routes.php */

