<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['admin']                                 = 'admin/Admin/index';
$route['admin/login']                           = 'admin/Admin/doLogin';
$route['admin/dashboard']                       = 'admin/Admin/dashboard';
$route['admin/logout']                          = 'admin/Admin/doLogout';
$route['admin/change/password']                 = 'admin/Admin/change_password';
$route['admin/profile']                         = 'admin/Admin/profile';
$route['admin/forgot/password']                 = 'admin/Admin/forget_password';
$route['admin/categories']                      = 'admin/Services/category_listing';
$route['admin/category/add_category']           = 'admin/Services/add_category';

// Credit Plans
$route['admin/credit/plans']                    = 'admin/settings/credit_plan';
$route['admin/credit/add_plan']                 = 'admin/settings/add_credit_plan';

$route['admin/users/list/(:any)']               = 'admin/Services/users/$1';
$route['admin/users/add-user']                  = 'admin/Services/add_user';
$route['admin/users/edit-user/(:any)']          = 'admin/Services/add_user/$1';
$route['admin/verification/performer']          = 'admin/Services/verify_performer';
$route['admin/user/details/(:any)']             = 'admin/Services/user_details/$1';
$route['admin/vote']                            = 'admin/Services/vote';
$route['admin/show-type']                       = 'admin/Services/showType';
$route['admin/add-show-type']                   = 'admin/Services/addShowType';
$route['admin/edit-show-type/(:any)']           = 'admin/Services/addShowType/$1';

$route['admin/willingness']                     = 'admin/Services/willingness';
$route['admin/add-willingness']                 = 'admin/Services/addWillingness';
$route['admin/edit-willingness/(:any)']         = 'admin/Services/addWillingness/$1';

$route['admin/appearence']                     = 'admin/Services/appearence';
$route['admin/add-appearence']                 = 'admin/Services/addAppearence';
$route['admin/edit-appearence/(:any)']         = 'admin/Services/addAppearence/$1';


// Gifts
$route['admin/gifts'] = 'admin/Gift';
$route['admin/gifts/add'] = 'admin/Gift/add';
$route['admin/gifts/edit/(:any)'] = 'admin/Gift/edit/$1';


// Loyalty Plans
$route['admin/loyalty/plans']       = 'admin/Loyalty';
$route['admin/loyalty/add']         = 'admin/Loyalty/add';
$route['admin/loyalty/edit/(:any)'] = 'admin/Loyalty/edit/$1';