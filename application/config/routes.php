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
|	https://codeigniter.com/userguide3/general/routing.html
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
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;



$route['members'] = 'controllermembershipinfo101';
$route['members/search'] = 'controllermembershipinfo101/findprofileinfo';  
$route['members/add'] = 'controllermembershipinfo101/savetransactioninfo'; 
$route['members/update'] = 'controllermembershipinfo101/updatetransactioninfo'; 
$route['members/updateinfo'] = 'controllermembershipinfo101/updatetransactionaddress'; 
$route['members/updateinfo2'] = 'controllermembershipinfo101/updatemasoninfo'; 
$route['members/delete'] = 'controllermembershipinfo101/deletetransactioninfo'; 
$route['members/show/(:any)'] = 'controllermembershipinfo101/individual_details/$1';


$route['members/remarks/table/(:any)'] = 'controllermembershipinfo101/remarks/table/$1';
$route['members/remarks/delete'] = 'controllermembershipinfo101/remarks/delete';
$route['members/remarks/add'] = 'controllermembershipinfo101/remarks/add';

$route['members/officerrecord/table/(:any)'] = 'controllermembershipinfo101/officerrecord/table/$1';
$route['members/officerrecord/delete'] = 'controllermembershipinfo101/officerrecord/delete';
$route['members/officerrecord/add'] = 'controllermembershipinfo101/officerrecord/add';



$route['members/print/docs/(:any)'] = 'controllermembershipinfo101/print/docs/$1'; 


//$route['members/remarks/(:any)/(:any)'] = 'controllermembershipinfo101/remarks/$1/$1';
//$route['members/remarks/(:any)'] = 'controllermembershipinfo101/remarks/$1';
$route['members/uploadImage'] = 'controllermembershipinfo101/uploadImage'; 



$route['contribution'] = 'Controllercontributionreport101';
$route['contribution/search'] = 'Controllercontributionreport101/findinfo';  
$route['contribution/search/(:any)'] = 'Controllercontributionreport101/findinfo/$1';  
$route['contribution/save'] = 'Controllercontributionreport101/savetransactioninfo'; 
$route['contribution/delete'] = 'Controllercontributionreport101/deletetransactioninfo'; 

$route['contribution/collection'] = 'Controllercontributionreport101/collection';
$route['contribution/search/collection'] = 'Controllercontributionreport101/findinfo/collection';  
$route['contribution/collection/profilecollectionlist'] = 'Controllercontributionreport101/collection/profilecollectionlist';
$route['contribution/collection/synccollection'] = 'Controllercontributionreport101/collection/synccollection';


$route['cashiering'] = 'Controllercashiermodule101';
$route['cashiering/search'] = 'Controllercashiermodule101/findinfo';  
$route['cashiering/save'] = 'Controllercashiermodule101/savetransactioninfo'; 
$route['cashiering/loadbalance'] = 'Controllercashiermodule101/loadRemainingBalance'; 
$route['cashiering/checkornumber'] = 'Controllercashiermodule101/checkornumber';
$route['cashiering/paymenttransaction'] = 'Controllercashiermodule101/paymenttransaction';
$route['cashiering/reports'] = 'Controllercashiermodule101/transactionreport';


$route['attendance'] = 'Controllerattendanceinfo101';
$route['attendance/search'] = 'Controllerattendanceinfo101/findprofileinfo';  
$route['attendance/view_attendance/(:any)'] = 'Controllerattendanceinfo101/view_attendance/$1'; 
$route['attendance/search_attendies/(:any)'] = 'Controllerattendanceinfo101/findprofileinfoAttendee/$1'; 
$route['attendance/save'] = 'Controllerattendanceinfo101/savetransactioninfo'; 
$route['attendance/check_attendance'] = 'Controllerattendanceinfo101/check_attendance'; 



$route['login'] = 'Controllerlogin101';
$route['login/check_credentials'] = 'Controllerlogin101/searchaccount';


$route['accounting'] = 'Controlleraccountinginfo101';
$route['accounting/assessment'] = 'Controlleraccountinginfo101/individual_assessment';
$route['accounting/ledger'] = 'Controlleraccountinginfo101/individual_ledger';
$route['accounting/ledger/(:any)'] = 'Controlleraccountinginfo101/individual_ledger/$1';
$route['accounting/getledgerentries'] = 'Controlleraccountinginfo101/loadGetLedgerEntries';
$route['accounting/getassessmententries'] = 'Controlleraccountinginfo101/loadGetAssestmentEntries';
$route['accounting/getListofPaymenttoAdd'] = 'Controlleraccountinginfo101/getListofPaymenttoAdd';
$route['accounting/insertnewpayment'] = 'Controlleraccountinginfo101/insertnewpayment';
$route['accounting/removeListofPayment'] = 'Controlleraccountinginfo101/removeListofPayment';
$route['accounting/updateListofPayment'] = 'Controlleraccountinginfo101/updateListofPayment';

$route['account'] = 'controlleraccountinfo101';
$route['account/search'] = 'controlleraccountinfo101/findprofileinfo';  
$route['account/save'] = 'controlleraccountinfo101/savetransactioninfo'; 
$route['account/update'] = 'controlleraccountinfo101/updatetransactioninfo'; 
$route['account/delete'] = 'controlleraccountinfo101/deletetransactioninfo'; 
$route['account/unlock'] = 'controlleraccountinfo101/accountunlockinfo'; 
$route['account/resetpass'] = 'controlleraccountinfo101/accountchangenewpasswordinfo'; 



$route['announcement'] = 'controllerannouncementinfo101';
$route['announcement/search'] = 'controllerannouncementinfo101/findinfo';  
$route['announcement/save'] = 'controllerannouncementinfo101/savetransactioninfo'; 
$route['announcement/update'] = 'controllerannouncementinfo101/updatetransactioninfo'; 
$route['announcement/delete'] = 'controllerannouncementinfo101/deletetransactioninfo'; 
