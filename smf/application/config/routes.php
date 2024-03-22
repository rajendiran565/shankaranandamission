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

$route['category'] = 'welcome/category';
$route['add_category'] = 'welcome/add_category';
$route['update_category'] = 'welcome/update_category';
$route['delete_category'] = 'welcome/delete_category';

$route['users'] = 'welcome/users';
$route['transactions'] = 'welcome/transactions';


$route['blogs'] = 'welcome/blogs';

$route['update_blogs/(:any)'] = 'welcome/update_blogs/$1';

$route['delete_blogs'] = 'welcome/delete_blogs';

$route['update_events/(:any)'] = 'welcome/update_events/$1';
$route['delete_event'] = 'welcome/delete_event';
$route['events'] = 'welcome/events';


$route['banners'] = 'welcome/banners';
$route['add_banner'] = 'welcome/add_banner';
$route['update_banner'] = 'welcome/update_banner';
$route['delete_banner'] = 'welcome/delete_banner';




$route['image_gallery'] = 'welcome/image_gallery';
$route['add_gallery'] = 'welcome/add_gallery';
$route['update_gallery'] = 'welcome/update_gallery';
$route['delete_gallery'] = 'welcome/delete_gallery';

$route['gallery_category'] = 'welcome/gallery_category';
$route['update_gallery_category'] = 'welcome/update_gallery_category';

$route['blessings'] = 'welcome/blessings';
$route['about_aashram'] = 'welcome/about_aashram';
$route['about_swamiji'] = 'welcome/about_swamiji';


$route['notification'] = 'welcome/notification';

$route['play_store_privacy_policy'] = 'api/play_store_privacy_policy';


$route['app_settings'] = 'settings/app_settings';
$route['add_settings'] = 'settings/add_settings';
$route['payment_methods'] = 'settings/apayment_methods';
$route['add_payment_methods'] = 'settings/add_payment_methods';
$route['notification_settings'] = 'settings/notification_settings';
$route['contact_us'] = 'settings/contact_us';
$route['privacy_policy'] = 'settings/privacy_policy';
$route['about_us'] = 'settings/about_us';

$route['faq'] = 'settings/faq';
$route['add_faq'] = 'settings/add_faq';
$route['delete_faq'] = 'settings/delete_faq';






$route['test_alert'] = 'api/test_alert';

$route['dashboard'] = 'welcome/dashboard';
$route['settings'] = 'welcome/settings';
$route['logout'] = 'welcome/logout';


$route['default_controller'] = 'welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;
