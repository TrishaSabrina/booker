<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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


$route['default_controller'] = 'home/index';
$route['404_override'] = 'home/error_404';
$route['translate_uri_dashes'] = FALSE;
$route['index'] = 'home/index';
$route['error-404'] = 'home/error_404';

//site routes
$route['demo'] = 'home/demo';
$route['features'] = 'home/features';
$route['faqs'] = 'home/faqs';
$route['pricing'] = 'home/pricing';
$route['contact'] = 'home/contact';
$route['blogs'] = 'home/blogs';
$route['users'] = 'home/users';
$route['companies'] = 'home/users';
$route['category/(:any)'] = 'home/category/$1';
$route['post/(:any)'] = 'home/post_details/$1';
$route['page/(:any)'] = 'home/page/$1';

$route['create-profile'] = 'home/create_profile';
$route['create-profile/(:any)'] = 'home/create_profile/$1';
$route['page/(:any)'] = 'home/page/$1';
$route['home/check_username/(:any)'] = 'home/check_username/$1';
$route['purchase-plan/(:any)'] = 'home/purchase/$1';
$route['payment-success/(:any)'] = 'home/payment_success/$1';
$route['payment-cancel/(:any)'] = 'home/payment_cancel/$1';
$route['pay'] = 'home/pays';

//auth routes
$route['login'] = 'auth/login';
$route['register'] = 'auth/register';
$route['verify-email'] = 'auth/verify';
$route['setup'] = 'auth/setup';

$route['gc/auth/index'] = 'googlecalendar/index';
$route['gc/auth/login'] = 'googlecalendar/login';
$route['gc/auth/oauth'] = 'googlecalendar/oauth';

//user route
$route['(:any)'] = 'company/home/$1';
$route['staff/(:any)'] = 'company/staff/$1';
$route['services/(:any)'] = 'company/services/$1';
$route['gallery/(:any)'] = 'company/gallery/$1';
$route['booking/(:any)'] = 'company/booking/$1';
$route['service/(:any)/(:any)'] = 'company/service/$1/$2';
$route['change_password'] = 'admin/dashboard/change_password';


