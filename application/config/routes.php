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
$route['default_controller'] = 'Welcome';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Rest API
$route['getprinted'] = 'C_General/GetPrintingDocument';


$route['permissionread'] = 'Auth/C_Permission/permission';

$route['permission'] = 'Home/permission';
$route['role'] = 'Home/role';
$route['permissionrole/(:num)'] = 'Home/permissionrole/$1';
$route['user'] = 'Home/user';

// content
$route['kategori'] = 'Home/kategori';
$route['buku'] = 'Home/buku';

// Pembayaran
$route['metodepembayaran'] = 'Home/metodepembayaran';

// Transaksi
$route['pembayaran'] = 'Home/pembayaran';


// ======================================== API ========================================

// API Auth
$route['APIAUTHUname'] = 'API/API_auth/FindUserName';
$route['APIAUTHEmail'] = 'API/API_auth/FindEmail';
$route['APIAUTHReg'] = 'API/API_auth/RegisterUser';
$route['APIAUTHLogin'] = 'API/API_auth/Log_Pro';
$route['APIAUTHChangePass'] = 'API/API_auth/ChangePassword';
$route['APIAUTHChangeImage'] = 'API/API_auth/ChangeImage';
$route['APIAUTHUserInfo'] = 'API/API_auth/GetUserInfo';
$route['APIAUTHUserInformation'] = 'API/API_auth/send_email';
$route['APIAUTHSaldoAkun'] = 'API/API_auth/SaldoAccount';
$route['APIAUTHlogout'] = 'API/API_auth/logout';
$route['APIAUTHgetSideBar'] = 'API/API_auth/GetSidebar';

// API Lokasi

$route['APILokasiRead'] = 'API/API_Lokasi/Read';
$route['APILokasiCRUD'] = 'API/API_Lokasi/CRUD';
$route['APILokasiGetLookup'] = 'API/API_Lokasi/getLookup';

// API Tahanan

$route['APITahananRead'] = 'API/API_Tahanan/Read';
$route['APITahananCRUD'] = 'API/API_Tahanan/CRUD';
$route['APITahananperLocation'] = 'API/API_Tahanan/ReadPerLocation';