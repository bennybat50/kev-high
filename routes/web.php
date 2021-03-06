<?php

use Illuminate\Support\Facades\Route;
use Admin\UserController;
use Admin\DashboardController;
use Admin\PaymentsController;
use Admin\PaymentsMethodController;
use Admin\PaymentsHistoryController;
use Admin\WithdrawalController;
use Admin\WithdrawalHistoryController;
use Admin\WithdrawalMethodController;
use Admin\UserInvestmentsController;
use Admin\InvestPackagesController;
use Admin\UserBondController;
use Admin\BondPackagesController;
use Admin\TraderController;
use Admin\MessagesController;
use Admin\ActivitiesController;
use User\UserDashboard;
use User\Profile;
use User\Kyc;
use User\EditPassword;
use User\Activity;
use User\ViewPortfolios;
use User\UsersInvestmentsView;
use User\WithdrawalRequest;
use User\WithdrawalHistory;
use User\InvestmentsHistory;
use User\TwoFactor;
use User\Message;
use User\ReferredUsers;
use User\ReferralBonus;
use User\UserPayment;
use User\ConfirmPayment;
use User\ReinvestContoller;
use HomeController as Home;
use CompoundInterest as Compound;
use CreateActivities as Activities;
use ActivatePortfolios as ActivatePortfolios;
use App\Mail\UserRegisteredMail;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// public page routes Start
Route::resource('/', Home::class);
Route::resource('/home', Home::class);

Route::get('/account-approval', function () {
    return view('auth.account-approval');
});
Route::get('/account-suspended', function () {
    return view('auth.account-suspend');
});

Route::get('/what-we-do', function () {
    return view('what-we-do');
});

Route::get('/email', function () {
    return new UserRegisteredMail([
        'title' => 'Please Verify your email address',
        'url' => 'https://www.itsolutionstuff.com',
        'descp' => 'In order to transact on your behalf, we need to verify a way of communicating with you. To verify your email address with us, please click the following secure link:',
        'action-text'=>'Verify Now',
        'img'=>'assets/images/emails/verification-banner.jpg'
    ]);
});

Route::get('/investment-approach', function () {
    return view('investment-approach');
});
Route::get('/investment-capabilities', function () {
    return view('investment-capabilities');
});
Route::get('/our-culture', function () {
    return view('our-culture');
});
Route::get('/esg-investment', function () {
    return view('esg-investment');
});



Route::get('/blog', function () {
    return view('blog');
});
Route::get('/about-us', function () {
    return view('about-us');
});
Route::get('/diversity', function () {
    return view('diversity');
});
Route::get('/sustainable', function () {
    return view('sustainable');
});
Route::get('/mission-and-values', function () {
    return view('mission-and-values');
});

Route::get('/clients-programs', function () {
    return view('clients-programs');
});

Route::get('/benefits', function () {
    return view('benefits');
});

Route::get('/how-we-are-different', function () {
    return view('how-we-are-different');
});

Route::get('/what-we-offer', function () {
    return view('what-we-offer');
});

Route::get('/research', function () {
    return view('research');
});

Route::get('/contact', function () {
    return view('contact');
});

Route::get('/understanding-whales-market-movers', function () {
    return view('understanding-whales-market-movers');
});

Route::get('/common-trading-mistakes', function () {
    return view('common-trading-mistakes');
});
Route::get('/diversification', function () {
    return view('diversification');
});
Route::get('/smart-contracts', function () {
    return view('smart-contracts');
});

Route::get('/swing-trading', function () {
    return view('swing-trading');
});

Route::get('/circulating-total-supply', function () {
    return view('circulating-total-supply');
});
Route::get('/market-cap', function () {
    return view('market-cap');
});
Route::get('/mindset-for-crypto', function () {
    return view('mindset-for-crypto');
});
Route::get('/trader-analyst', function () {
    return view('trader-analyst');
});




// public page routes End

//User Registration Routes
Route::get('register/user-email', function () {
    return view('auth.user.user-email');
});
Route::get('register/user-password', function () {
    return view('auth.user.user-password');
});
Route::get('register/user-names', function () {
    return view('auth.user.user-names');
});
Route::get('register/user-phone', function () {
    return view('auth.user.user-phone');
});
Route::get('register/user-agreement', function () {
    return view('auth.user.user-agreement');
});

// Business Registration Routes
Route::get('register/business-name', function () {
    return view('auth.business.b-name');
});
Route::get('register/business-location', function () {
    return view('auth.business.b-location');
});
Route::get('register/business-email', function () {
    return view('auth.business.b-email');
});
Route::get('register/business-reg-no', function () {
    return view('auth.business.b-reg-no');
});
Route::get('register/business-phone', function () {
    return view('auth.business.b-phone');
});
Route::get('register/business-password', function () {
    return view('auth.business.b-password');
});
Route::get('register/business-upload', function () {
    return view('auth.business.b-upload');
});


Route::resource('/compound-interest', Compound::class);
Route::resource('/create-activities', Activities::class);
Route::resource('/payment', UserPayment::class);
Route::resource('/activate-portfolio', ActivatePortfolios::class);


//User Routes
//WE ARE HERE
Route::prefix('user')->middleware(['auth', 'verified','approved'])->name('user.')->group(function (){
    Route::resource('/dashboard', UserDashboard::class);
    Route::resource('/profile', Profile::class);
    Route::resource('/kyc', Kyc::class);
    Route::resource('/message', Message::class);
    Route::resource('/two-factor', TwoFactor::class);
    Route::resource('/change-password', EditPassword::class);
    Route::resource('/activity', Activity::class);
    Route::resource('/referred-users', ReferredUsers::class);
    Route::resource('/referral-bonus', ReferralBonus::class);
    Route::resource('/view-investments-portfolio', ViewPortfolios::class);
    Route::resource('/user-investments', UsersInvestmentsView::class);
    Route::resource('/withdrawal-request', WithdrawalRequest::class);
    Route::resource('/withdrawal-history', WithdrawalHistory::class);
    Route::resource('/investment-history', InvestmentsHistory::class);
    Route::resource('/get-payment', UserPayment::class);
    Route::resource('/confirm-payment', ConfirmPayment::class);
    Route::resource('/reinvest', ReinvestContoller::class);

});
//Admin Routes
Route::prefix('admin')->middleware(['auth', 'auth.isAdmin'])->name('admin.')->group(function (){
    Route::resource('/dashboard', DashboardController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/activities', ActivitiesController::class);
    Route::resource('/messsages', MessagesController::class);
    Route::resource('/payments', PaymentsController::class);
    Route::resource('/payment-methods', PaymentsMethodController::class);
    Route::resource('/payment-history', PaymentsHistoryController::class);
    Route::resource('/withdrawal-request', WithdrawalController::class);
    Route::resource('/withdrawal-history', WithdrawalHistoryController::class);
    Route::resource('/withdrawal-method', WithdrawalMethodController::class);
    Route::resource('/users-investments', UserInvestmentsController::class);
    Route::resource('/investment-packages', InvestPackagesController::class);
    Route::resource('/users-bond', UserBondController::class);
    Route::resource('/bond-packages', BondPackagesController::class);
    Route::resource('/traders', TraderController::class);
    Route::get('/impersonate/user/{id}', 'Admin\ImpersonateController@index')->name('impersonate');
});
Route::get('/admin/impersonate/destroy', 'Admin\ImpersonateController@destroy')->name('admin.impersonate.destroy');


Route::get('generate-sitemap', function(){
    // create new sitemap object
    $sitemap = App::make("sitemap");


    // add items to the sitemap (url, date, priority, freq)
    $sitemap->add(URL::to('home'), '2012-08-25T20:10:00+02:00', '1.0', 'daily');
    $sitemap->add(URL::to('investment'), '2012-08-25T20:10:00+02:00', '0.9', 'daily');
    $sitemap->add(URL::to('responsible-investing'), '2012-08-25T20:10:00+02:00', '0.5', 'daily');
    $sitemap->add(URL::to('esg'), '2012-08-25T20:10:00+02:00', '0.9', 'daily');
    $sitemap->add(URL::to('diversity-and-inclusion'), '2012-08-25T20:10:00+02:00', '0.5', 'daily');
    $sitemap->add(URL::to('private-equity'), '2012-08-25T20:10:00+02:00', '0.5', 'daily');
    $sitemap->add(URL::to('sustainability'), '2012-08-25T20:10:00+02:00', '0.5', 'daily');
    $sitemap->add(URL::to('overview'), '2012-08-25T20:10:00+02:00', '0.8', 'daily');
    $sitemap->add(URL::to('real-estate'), '2012-08-25T20:10:00+02:00', '0.8', 'daily');
    $sitemap->add(URL::to('insurance-solutions'), '2012-08-25T20:10:00+02:00', '0.5', 'daily');
    $sitemap->add(URL::to('renewable-power'), '2012-08-25T20:10:00+02:00', '0.5', 'daily');
    $sitemap->add(URL::to('infrastructure'), '2012-08-25T20:10:00+02:00', '0.5', 'daily');
    $sitemap->add(URL::to('corporate-governance'), '2012-08-25T20:10:00+02:00', '0.5', 'daily');
    $sitemap->add(URL::to('contact'), '2012-08-25T20:10:00+02:00', '1.0', 'daily');


    // generate your sitemap (format, filename)
    $sitemap->store('xml', 'sitemap');
    // this will generate file mysitemap.xml to your public folder
   return  redirect(url('sitemap.xml'));

});
