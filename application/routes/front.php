<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['db-bak']                                    = 'DB/backup';
$route['login']                                     = 'Auth';
$route['set-age']                                   = 'Auth/setAge';
$route['signup']                                    = 'Auth/signUp';
$route['do-registration']                           = 'Auth/doRegistration';
$route['do-login']                                  = 'Auth/doLogin';
$route['logout']                                    = 'Auth/logOut';


$route['landing']                                   = 'Home/landing';
$route['profile']                                   = 'Home/profile';
$route['profile-update']                            = 'Home/profileUpdate';
$route['personal-details']                          = 'Home/personalDetails';
$route['account-settings']                          = 'Home/accountSettings';
$route['verification']                              = 'Home/verification';


$route['dashboard']                                 = 'Home/dashBoard';

$route['performer/(:any)/(:any)']                   = 'Home/viewProfile/$1/$2/';
$route['filter-performer']                          = 'Home/filterPerformer';


$route['subs-cribe']                                = 'Service/subscribe';
$route['vote']                                      = 'Service/vote';
$route['subscriptions-list']                        = 'Service/subscriptionsList';
$route['subs-suggestion']                           = 'Service/subsSuggestion';
$route['awards']                                    = 'Service/awards';
$route['my-shows']                                  = 'Service/myShows';
$route['my-subscriptions']                          = 'Service/mySubscriptions';
$route['upload-video']                              = 'Service/uploadVideo';


$route['content']                                   = 'Service/content';
$route['manage-users']                              = 'Service/manageUsers';
$route['financial']                                 = 'Service/financial';
$route['my-network']                                = 'Service/myNetwork';
$route['loyalty']                                   = 'Service/loyalty';
$route['help']                                      = 'Service/help';






$route['chat-lists']                                = 'Chat';
$route['full-chat-details']                         = 'Chat/fullChatDetails';
$route['delete-chat']                               = 'Chat/deleteChat';
$route['send-chat']                                 = 'Chat/sendChat';
$route['check-new-msg']                             = 'Chat/checkNewMsg';
$route['search-user']                               = 'Chat/searchUser';



$route['video-chat']                                = 'Videochat';
$route['start-video-chat']                          = 'Videochat/videoChatStart';
$route['check-new-video-chat-request']              = 'Videochat/checkNewVideoChatRequest';
$route['cancel-video-chat']                         = 'Videochat/cancelVideoChat';
$route['accept-video-chat']                         = 'Videochat/acceptVideoChat';
$route['check-video-chat-status']                   = 'Videochat/checkVideoChatStatus';
$route['check-video-chat-status-performer']         = 'Videochat/checkVideoChatStatusPerformer';
$route['hangup-video-chat']                         = 'Videochat/hangupVideoChat';
$route['vc-send-chat']                              = 'Videochat/vcSendChat';
$route['vc-check-new-text']                         = 'Videochat/vcCheckNewText';
$route['check-webcam-performer']                    = 'Videochat/checkWebcamPerformer';



// Gifts
$route['gifts']     = 'front/Gift/received';
$route['send-gift'] = 'front/Gift/send';


// Paypal payment
$route['process-payment/(:any)'] = 'front/Paypalpayment/process/$1';
$route['payment-success']        = 'front/Paypalpayment/success';
$route['payment-cancel']         = 'front/Paypalpayment/cancel';
$route['payment-cancelled']      = 'front/Paypalpayment/cancelled';
$route['payment-completed']      = 'front/Paypalpayment/completed';
$route['view-invoice/(:any)']    = 'front/Paypalpayment/view_invoice/$1';