<?php

use Illuminate\Support\Facades\Route;
use Wave\Http\Controllers\TwilioController;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\SocialiteController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\DesignController;
Route::get('auth/google', [SocialiteController::class, 'redirectToGoogle'])->name('google.auth');
Route::get('auth/google/call-back', [SocialiteController::class, 'handleGoogleCallback']);
Route::impersonate();

Route::get('/', '\Wave\Http\Controllers\HomeController@index')->name('wave.home');
Route::get('@{username}', '\Wave\Http\Controllers\ProfileController@index')->name('wave.profile');


Route::get('/phpinfo', function () {
    phpinfo();
});


// Documentation routes
Route::view('docs/{page?}', 'docs::index')->where('page', '(.*)');

// Additional Auth Routes
Route::get('logout', '\Wave\Http\Controllers\Auth\LoginController@logout')->name('wave.logout');
Route::get('user/verify/{verification_code}', '\Wave\Http\Controllers\Auth\RegisterController@verify')->name('verify');
Route::post('register/complete', '\Wave\Http\Controllers\Auth\RegisterController@complete')->name('wave.register-complete');

Route::get('blog', '\Wave\Http\Controllers\BlogController@index')->name('wave.blog');
Route::get('blog/{category}', '\Wave\Http\Controllers\BlogController@category')->name('wave.blog.category');
Route::get('blog/{category}/{post}', '\Wave\Http\Controllers\BlogController@post')->name('wave.blog.post');

Route::view('install', 'wave::install')->name('wave.install');

/***** Pages *****/
Route::get('p/{page}', '\Wave\Http\Controllers\PageController@page');

/***** Pricing Page *****/
Route::view('pricing', 'theme::pricing')->name('wave.pricing');

/***** Billing Routes *****/
Route::post('paddle/webhook', '\Wave\Http\Controllers\WebhookController');
// Route::post('checkout', '\Wave\Http\Controllers\SubscriptionController@checkout')->name('checkout');

Route::get('test', '\Wave\Http\Controllers\SubscriptionController@test');

Route::group(['middleware' => 'wave'], function () {
	Route::get('dashboard', '\Wave\Http\Controllers\DashboardController@index')->name('wave.dashboard');
});

Route::group(['middleware' => 'auth'], function(){
    //user profile
	Route::get('profile','\Wave\Http\Controllers\SettingsController@profile')->name('user.settings.profile');
	Route::get('security','\Wave\Http\Controllers\SettingsController@security')->name('user.settings.security');
	Route::get('plan','\Wave\Http\Controllers\SettingsController@plan')->name('user.settings.plane');


	Route::get('settings/{section?}', '\Wave\Http\Controllers\SettingsController@index')->name('wave.settings');

	Route::post('settings/profile', '\Wave\Http\Controllers\SettingsController@profilePut')->name('wave.settings.profile.put');
	Route::put('settings/security', '\Wave\Http\Controllers\SettingsController@securityPut')->name('wave.settings.security.put');

	Route::post('settings/api', '\Wave\Http\Controllers\SettingsController@apiPost')->name('wave.settings.api.post');
	Route::put('settings/api/{id?}', '\Wave\Http\Controllers\SettingsController@apiPut')->name('wave.settings.api.put');
	Route::delete('settings/api/{id?}', '\Wave\Http\Controllers\SettingsController@apiDelete')->name('wave.settings.api.delete');

	// Route::get('settings/invoices/{invoice}', '\Wave\Http\Controllers\SettingsController@invoice')->name('wave.invoice');

	Route::get('notifications', '\Wave\Http\Controllers\NotificationController@index')->name('wave.notifications');
	Route::get('announcements', '\Wave\Http\Controllers\AnnouncementController@index')->name('wave.announcements');
	Route::get('announcement/{id}', '\Wave\Http\Controllers\AnnouncementController@announcement')->name('wave.announcement');
	Route::post('announcements/read', '\Wave\Http\Controllers\AnnouncementController@read')->name('wave.announcements.read');
	Route::get('notifications', '\Wave\Http\Controllers\NotificationController@index')->name('wave.notifications');
	Route::post('notification/read/{id}', '\Wave\Http\Controllers\NotificationController@delete')->name('wave.notification.read');

    /********** Checkout/Billing Routes ***********/
    Route::post('cancel', '\Wave\Http\Controllers\SubscriptionController@cancel')->name('wave.cancel');
    // Route::view('checkout/welcome', 'theme::welcome');

    Route::post('subscribe', '\Wave\Http\Controllers\SubscriptionController@subscribe')->name('wave.subscribe');
	Route::view('trial_over', 'theme::trial_over')->name('wave.trial_over');
	Route::view('cancelled', 'theme::cancelled')->name('wave.cancelled');
    Route::post('switch-plans', '\Wave\Http\Controllers\SubscriptionController@switchPlans')->name('wave.switch-plans');




    Route::post('/check-coupon/{id}', [CouponController::class, 'checkCoupon'])->name('coupon.code_example');
});

Route::group(['middleware' => 'admin.user'], function(){

    // Route::view('admin/do', 'wave::do');
    // route::get('/admin/stripeAPi',    '\Wave\Http\Controllers\stripeController@stripeApi' )->name('stripe.api');
    // route::Post('/admin/stripeStore',    '\Wave\Http\Controllers\stripeController@stripeStore' )->name('stripe.store');
        /**************** campaingns **************/

        Route::get('/admin/campaigns', '\Wave\Http\Controllers\CampaignController@index')->name('campaigns.index');
        Route::post('/admin/email/send', '\Wave\Http\Controllers\CampaignController@sendEmail')->name('Send.email');

        Route::get('/admin/email-inbox', '\Wave\Http\Controllers\CampaignController@EmailInbox')->name('campaigns.Email.inbox');
        Route::get('/admin/SMS-inbox', '\Wave\Http\Controllers\CampaignController@SMSInbox')->name('campaigns.SMS.inbox');
        Route::get('/admin/campaign/inbox','\Wave\Http\Controllers\CampaignController@inbox')->name('campaign.inbox');
        Route::post('/admin/campaign/edit','\Wave\Http\Controllers\CampaignController@campaign_create')->name('edit_campaign');
        Route::get('/admin/campaign/create','\Wave\Http\Controllers\CampaignController@campaign_index')->name('edit_index');
        Route::get('/admin/campaign/open/{id}','\Wave\Http\Controllers\CampaignController@campaign_open_email')->name('open.email');
        Route::get('/admin/website','\App\Http\Controllers\WebsiteController@index')->name('websites.index');


	Route::get('/admin/dashboard', '\Wave\Http\Controllers\DashboardController@dashboard')->name('wave.admin.dashboard');
    Route::post('/admin/apply-coupon', 'CouponController@applyCoupon');
    Route::post('/admin/remove-coupon', 'CouponController@removeCoupon');

    Route::get('/mailbuilder', '\Wave\Http\Controllers\CampaignController@Mailbuilder')->name('mailbuilder.index');

    Route::get('/admin/campaigns/sent','\Wave\Http\Controllers\CampaignController@sent')->name('campaigns.sent');
    Route::get('/admin/campaigns/draft', '\Wave\Http\Controllers\CampaignController@draft')->name('campaigns.draft');
    Route::post('/update-campaign-title', '\Wave\Http\Controllers\CampaignController@update_campaign_title');

        Route::get('/admin/to', [\Wave\Http\Controllers\TwilioController::class, 'sendSMSpage'])->name("to.SMS");

        Route::post('/admin/send-sms', [\Wave\Http\Controllers\TwilioController::class, 'sendSMS'])->name("send-sms");
        Route::get('/admin/send-whatsapp', [\Wave\Http\Controllers\TwilioController::class, 'sendWhatsAppMessage']);
       Route::post('/admin/tickets/update', '\Wave\Http\Controllers\TicketController@updateStatus')->name('ticket.status.update');
       Route::get('/admin/tickets', '\Wave\Http\Controllers\TicketController@adminTickets')->name('voyager.admin.tickets');
       Route::get('/admin/invoices', '\Wave\Http\Controllers\SettingsController@admininvoices')->name('admin.invoice');
        
    });
    
        
    

Route::get('/getCities/{id}','\Wave\Http\Controllers\SettingsController@getCities');
Route::get('/getStates/{id}','\Wave\Http\Controllers\SettingsController@getStates');
    Route::post('/create-payment-intent', '\Wave\Http\Controllers\stripeController@create')->name('create.payment');
    Route::get('/stripeForm/{id}', '\Wave\Http\Controllers\stripeController@stripeform')->name('stripe.form');
    // Route::get('/create-invoice', '\Wave\Http\Controllers\stripeController@createInvoice')->name('create.invoice');






Route::get('/tickets', '\Wave\Http\Controllers\TicketController@index')->name('tickets.index');
Route::get('/tickets/create', '\Wave\Http\Controllers\TicketController@create')->name('tickets.create');
Route::post('/tickets', '\Wave\Http\Controllers\TicketController@store')->name('ticket.store');
Route::get('/tickets/{id}', '\Wave\Http\Controllers\TicketController@show')->name('tickets.user');


Route::get('/test1', function (){
return view('invoices');
} );

Route::get('/templates/{id}/editor/{campaignid}', [DesignController::class, 'showEditor'])->name('template.editor');
Route::get('/templates/{id}', [DesignController::class, 'index'])->name('template.index');
Route::post('/save-design', [DesignController::class, 'saveDesign'])->name('save_design');
route::get('/emailbulder/{campaignid}' , function (){
    return view('emailbulder');
})->name("emailbulder");
