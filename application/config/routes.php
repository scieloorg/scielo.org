<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
 */
$route['default_controller'] = 'home';
$route['404_override'] = 'home/page_not_found';
$route['translate_uri_dashes'] = false;

$route['pt/periodicos/listar-por-ordem-alfabetica'] = 'home/list_journals_by_alphabetical_order';
$route['pt/periodicos/listar-por-ordem-alfabetica-ajax'] = 'home/list_journals_by_alphabetical_order_ajax';

$route['en/journals/list-by-alphabetical-order'] = 'home/list_journals_by_alphabetical_order';
$route['en/journals/list-by-alphabetical-order-ajax'] = 'home/list_journals_by_alphabetical_order_ajax';

$route['es/revistas/listar-por-orden-alfabetico'] = 'home/list_journals_by_alphabetical_order';
$route['es/revistas/listar-por-orden-alfabetico-ajax'] = 'home/list_journals_by_alphabetical_order_ajax';

$route['pt/periodicos/listar-por-publicador'] = 'home/list_by_publishers';
$route['pt/periodicos/listar-por-publicador-ajax'] = 'home/list_by_publishers_ajax';

$route['en/journals/list-by-publishers'] = 'home/list_by_publishers';
$route['en/journals/list-by-publishers-ajax'] = 'home/list_by_publishers_ajax';

$route['es/revistas/listar-por-el-publicador'] = 'home/list_by_publishers';
$route['es/revistas/listar-por-el-publicador-ajax'] = 'home/list_by_publishers_ajax';

$route['pt/periodicos/listar-por-assunto/(:num)/(:any)'] = 'home/list_by_subject_area/$1/$2';
$route['pt/periodicos/listar-por-assunto'] = 'home/list_by_subject_area';

$route['pt/periodicos/listar-por-assunto-ajax/(:num)/(:any)'] = 'home/list_by_subject_area_ajax/$1/$2';
$route['pt/periodicos/listar-por-assunto-ajax'] = 'home/list_by_subject_area_ajax';

$route['en/journals/list-by-subject-area/(:num)/(:any)'] = 'home/list_by_subject_area/$1/$2';
$route['en/journals/list-by-subject-area'] = 'home/list_by_subject_area';

$route['en/journals/list-by-subject-area-ajax/(:num)/(:any)'] = 'home/list_by_subject_area_ajax/$1/$2';
$route['en/journals/list-by-subject-area-ajax'] = 'home/list_by_subject_area_ajax';

$route['es/revistas/listar-por-tema/(:num)/(:any)'] = 'home/list_by_subject_area/$1/$2';
$route['es/revistas/listar-por-tema'] = 'home/list_by_subject_area';

$route['es/revistas/listar-por-tema-ajax/(:num)/(:any)'] = 'home/list_by_subject_area_ajax/$1/$2';
$route['es/revistas/listar-por-tema-ajax'] = 'home/list_by_subject_area_ajax';

$route['php/index.php'] = 'home/redirect_legacy_index_url';

$route['pt/(.+)'] = 'home/page/$1';
$route['en/(.+)'] = 'home/page/$1';
$route['es/(.+)'] = 'home/page/$1';

$route['pt/'] = 'home/index';
$route['en/'] = 'home/index';
$route['es/'] = 'home/index';

$route['pt'] = 'home/index';
$route['en'] = 'home/index';
$route['es'] = 'home/index';

