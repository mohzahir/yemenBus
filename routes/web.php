<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
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

Auth::routes();
Route::get('/wakeel', function () {
    return view('index');
})->name('index');

Route::get('/Fasttecket', "FormController@index");
Route::post('/Fasttecket', "FormController@post");


Route::get('/sucssesEmail', function () {
    return view('sucessIndex');
})->name('SendSuccesEmail');
Route::post('/marketer/email', 'HomeController@marketerEmail')->name('marketerEmail');

Route::get('/login/lab', 'Auth\LoginController@showLabLoginForm')->name('auth.login.lab');

Route::get('/login/admin', 'Auth\LoginController@showAdminLoginForm')->name('auth.login.admin');
Route::get('/login/marketer', 'Auth\LoginController@showmarketerLoginForm')->name('auth.login.maketer');
Route::get('/login/provider', 'Auth\LoginController@showProviderLoginForm')->name('auth.login.provider');
Route::get('/register/admin', 'Auth\RegisterController@showAdminRegisterForm');
Route::get('/register/marketer', 'Auth\RegisterController@showMarketerRegisterForm');
Route::get('/register/provider', 'Auth\RegisterController@showProviderRegisterForm');

Route::post('/login/lab', 'Auth\LoginController@labLogin');
Route::post('/login/admin', 'Auth\LoginController@adminLogin');
Route::post('/login/marketer', 'Auth\LoginController@marketerLogin')->name('login.marketer');
Route::post('/login/provider', 'Auth\LoginController@providerLogin');
Route::post('/register/admin', 'Auth\RegisterController@createAdmin');
Route::post('/register/marketer', 'Auth\RegisterController@createmarketer')->name('marketer.register');
Route::post('/register/provider', 'Auth\RegisterController@createProvider')->name('provider.register');;
Route::get('/roles', 'PermissionController@Permission');
Route::post('/logout', 'Auth\LoginController@logout')->name('logout');

Route::get('admin/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('admin.showResetForm');
Route::get('admin/resetemail', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('admin.showResetEmailForm');
Route::post('admin/reset', 'Auth\ResetPasswordController@reset')->name('admin.password.update');



Route::get('reset/passwordForm', 'Auth\ForgotPasswordPhoneController@showLinkRequestForm')->name('showResetPhoneForm');
Route::post('reset/password', 'Auth\ForgotPasswordPhoneController@sendPassword')->name('sendPassword');
Route::get('reset/redirect/{code}', 'Auth\ForgotPasswordPhoneController@signInMarketer')->name('signInMarketer');
Route::get('reset/redirect/provider/{id}', 'Auth\ForgotPasswordPhoneController@signInProvider')->name('signInProvider');
Route::get('reset/redirect/lab/{id}', 'Auth\ForgotPasswordPhoneController@signInLab')->name('signInLab');

/*Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

/*Route::post('/forgot-password/marketer', function (Request $request) {
    $request->validate(['phone' => 'required|email']);

    $status = Password::sendResetLink(
        $request->only('phone')
    );

    return $status === Password::RESET_LINK_SENT
                ? back()->with(['status' => __($status)])
                : back()->withErrors(['phone' => __($status)]);
})->middleware('guest')->name('password.email');

Route::get('/', 'HomeController@index')->name('home');
/*Route::get('/terms', function() {
    return view('terms');
})->name('terms');
*/
Route::get('/', 'HomeController@index')->name('home');


Route::post('/participate', 'ParticipantCompetitionController@store')->name('participant_competition.store');

Route::get('/pcrs_request', 'PcrsController@create')->name('pcrs_request');
Route::post('/pcrs_request/add', 'PcrsController@add')->name('pcrs_request.add');
Route::post('/pcrs_request', 'PcrsController@store')->name('pcrs_request.store');
/*Route::get('/terms', function() {
    return view('terms');
})->name('terms');
*/

Route::get('pcrs_request/get-lab-list', 'PcrsController@getLabList')->name('labs');




//Route::get('/admin', 'admin\AdminController@index')->middleware('auth');

Route::prefix('dashboard')->middleware('admin')->group(function () {
    Route::get('admin', 'admin\AdminController@index')->name('dashboard.admin.index');
    Route::get('admin/setting', 'admin\AdminController@admin')->name('dashboard.admin.setting');
    Route::post('admin/update', 'admin\AdminController@update')->name('dashboard.admin.update');

    //admin dashboard  manage lab
    Route::get('/labs', 'admin\AdminLabController@index')->name('admin.lab.index');
    Route::get('/labs/create', 'admin\AdminLabController@create')->name('admin.lab.create');
    Route::post('/labs/store', 'admin\AdminLabController@store')->name('admin.lab.store');
    Route::get('/labs/edit/{id}', 'admin\AdminLabController@edit')->name('admin.lab.edit');
    Route::put('/labs/update/{id}', 'admin\AdminLabController@update')->name('admin.lab.update');
    Route::get('/labs/delete/{id}', 'admin\AdminLabController@destroy')->name('admin.lab.delete');
    Route::get('/labs/sms/{id}', 'admin\AdminLabController@sms')->name('admin.lab.sms');
    Route::post('/labs/sms/store/{id}', 'admin\AdminLabController@smsSend')->name('admin.lab.smsSend');
    Route::get('admin/lab/share/{id}', 'admin\AdminLabController@formShared')->name('admin.lab.share');
    Route::Post('admin/lab/sharesend/{id}', 'admin\AdminLabController@share')->name('admin.lab.shareSend');

    //pcrs
    Route::get('/pcrs/{id?}', 'admin\AdminPcrsController@pcrs')->name('admin.pcrs');
    Route::get('/pcrs/sms/{id}', 'admin\AdminPcrsController@sms')->name('admin.pcrs.sms');
    Route::post('/pcrs/sms/store/{id}', 'admin\AdminPcrsController@smsSend')->name('admin.pcrs.smsSend');
    Route::get('/pcrs/share/{id}', 'admin\AdminPcrsController@formShared')->name('admin.pcrs.share');
    Route::Post('/pcrs/sharesend/{id}', 'admin\AdminPcrsController@share')->name('admin.pcrs.shareSend');


    Route::get('competitions', 'admin\AdminCompetitionsController@index')->name('dashboard.competitions.index');
    Route::get('competitions/create', 'admin\AdminCompetitionsController@create')->name('dashboard.competitions.create');
    Route::get('competitions/{competition}/edit', 'admin\AdminCompetitionsController@edit')->name('dashboard.competitions.edit');
    Route::patch('competitions/{competition}', 'admin\AdminCompetitionsController@update')->name('dashboard.competitions.update');
    Route::post('competitions', 'admin\AdminCompetitionsController@store')->name('dashboard.competitions.store');
    Route::delete('competitions/{competition}', 'admin\AdminCompetitionsController@destroy')->name('dashboard.competitions.destroy');
    Route::get('competitions/{competition}', 'admin\AdminCompetitionsController@show')->name('dashboard.competitions.show');

    Route::get('marketers/create', 'admin\AdminMarketersController@create')->name('dashboard.marketers.create');
    Route::post('marketers/store', 'admin\AdminMarketersController@store')->name('dashboard.marketers.store');
    Route::get('marketers/edit/{id}', 'admin\AdminMarketersController@edit')->name('dashboard.marketers.edit');
    Route::get('marketers/update/{id}', 'admin\AdminMarketersController@update')->name('dashboard.marketer.update');
    Route::get('marketers/index', 'admin\AdminMarketersController@index')->name('dashboard.marketers.index');
    Route::get('marketers/destroy/{id}', 'admin\AdminMarketersController@destroy')->name('dashboard.marketers.destroy');
    Route::get('marketers/{id}', 'admin\AdminMarketersController@show')->name('dashboard.marketers.show');
    Route::get('marketers/sms/{id}', 'admin\AdminMarketersController@smsMarketer')->name('dashboard.marketers.sendMsms');
    Route::post('marketers/sms/store', 'admin\AdminMarketersController@storeSmsM')->name('dashboard.marketers.sendMsms.store');
    Route::get('marketers/toActive/{id}', 'admin\AdminMarketersController@toActive')->name('dashboard.marketers.toActive');
    Route::get('marketers/toSuspend/{id}', 'admin\AdminMarketersController@toSuspend')->name('dashboard.marketers.toSuspend');
    Route::get('chargeForm/{id?}', 'admin\AdminChargeController@chargeForm')->name('dashboard.marketers.chargeForm');
    Route::post('marketers/charge', 'admin\AdminChargeController@charge')->name('dashboard.marketers.charge');

    Route::get('noms/index', 'admin\AdminProvidersController@noms')->name('admin.nom.index');


    Route::get('reservations/confirm/index', 'admin\AdminReservationController@confirm')->name('admin.reservations.confirmAll');
    Route::get('/downloadImage/{id}', 'admin\AdminReservationController@downloadImage')->name('admin.image.download');
    Route::get('reservation/admin/edit/{id}', 'admin\AdminReservationController@edit')->name('admin.reservations.edit');
    Route::post('reservation/admin/update/{id}', 'admin\AdminReservationController@update')->name('admin.reservations.update');

    Route::get('reservations/confirm', 'admin\AdminReservationController@confirm')->name('admin.reservations.confirm');
    Route::post('reservations/confirm', 'admin\AdminReservationController@storeConfirm')->name('admin.reservations.storeConfirm');

    Route::get('reservations/postpone/{id}', 'admin\AdminReservationController@postpone')->name('admin.reservations.postpone');
    Route::post('reservations/storePostpone', 'admin\AdminReservationController@storePostpone')->name('admin.reservations.storePostpone');

    Route::get('reservations/cancel/{id}', 'admin\AdminReservationController@cancel')->name('admin.reservations.cancel');
    Route::post('reservations/storeCancel', 'admin\AdminReservationController@storeCancel')->name('admin.reservations.storeCancel');

    Route::get('reservations/transfer/{id}', 'admin\AdminReservationController@transfer')->name('admin.reservations.transfer');
    Route::post('reservations/storeTransfer', 'admin\AdminReservationController@storetransfer')->name('admin.reservations.storetransfer');

    Route::get('sms/{id?}', 'admin\AdminReservationController@sms')->name('admin.sms');
    Route::post('sms/store', 'admin\AdminReservationController@storeSms')->name('admin.storeSms');

    Route::get('admin/reservation/date', 'admin\AdminReservationController@date')->name('admin.reservation.date');

    // AdminProvider_carController

    Route::get('providers/Provider_car', 'admin\AdminProvider_carController@provider_car')->name('dashboard.providers.provider_car');
    Route::get('providers/create_car', 'admin\AdminProvider_carController@create_car')->name('dashboard.providers.create_car');
    Route::Post('providers/store_car', 'admin\AdminProvider_carController@store_car')->name('dashboard.providers.store_car');
    Route::get('providers/edit_car/{id}', 'admin\AdminProvider_carController@edit_car')->name('dashboard.providers.edit_car');
    Route::get('providers/update_car/{id}', 'admin\AdminProvider_carController@update_car')->name('dashboard.providers.update_car');
    Route::delete('providers/destroy_car/{id}', 'admin\AdminProvider_carController@destroy')->name('dashboard.providers.destroy_car');
    Route::get('providers/sms_car/{id}', 'admin\AdminProvider_carController@smsProvider_car')->name('dashboard.providers.sendPsms_car');
    Route::post('providers/sms_car/store', 'admin\AdminProvider_carController@storeSmsP_car')->name('dashboard.providers.sendPsms_car.store');




    Route::get('providers/index', 'admin\AdminProvidersController@index')->name('dashboard.providers.index');

    Route::get('providers/create', 'admin\AdminProvidersController@create')->name('dashboard.providers.create');
    Route::get('providers/create_haj', 'admin\AdminProvidersController@create_haj')->name('dashboard.providers.create_haj');


    Route::Post('providers/store', 'admin\AdminProvidersController@store')->name('dashboard.providers.store');
    Route::Post('providers/store_haj', 'admin\AdminProvidersController@store_haj')->name('dashboard.providers.store_haj');

    Route::get('providers/edit/{id}', 'admin\AdminProvidersController@edit')->name('dashboard.providers.edit');
    Route::get('providers/update/{id}', 'admin\AdminProvidersController@update')->name('dashboard.providers.update');
    Route::delete('providers/destroy/{id}', 'admin\AdminProvidersController@destroy')->name('dashboard.providers.destroy');
    Route::get('providers/PermessionAgentRequest', 'admin\AdminProvidersController@pfar')->name('dashboard.providers.pfar');
    Route::get('providers/PermessionAgentRequest/{id}', 'admin\AdminProvidersController@destroyPfa')->name('dashboard.providers.pfar.delete');
    Route::get('providers/sms/{id}', 'admin\AdminProvidersController@smsProvider')->name('dashboard.providers.sendPsms');
    Route::post('providers/sms/store', 'admin\AdminProvidersController@storeSmsP')->name('dashboard.providers.sendPsms.store');


    Route::get('providers/trips', 'admin\AdminTripController@index')->name('dashboard.providers.trips');

    Route::post('providers/trip/filter', 'admin\AdminTripController@filter')->name('dashboard.provider.filter');
    Route::get('providers/trip/create', 'admin\AdminTripController@create')->name('dashboard.provider.trip.create');

    Route::get('providers/trip/destroy/{id}', 'admin\AdminTripController@destroy')->name('dashboard.provider.trip.delete');
    Route::get('providers/trip/activate/{id}', 'admin\AdminTripController@activate')->name('dashboard.provider.trip.activate');
    Route::get('providers/trip/date', 'admin\AdminTripController@date')->name('dashboard.provider.trip.date');
    Route::post('providers/trip/store', 'admin\AdminTripController@store')->name('dashboard.provider.trip.store');
    Route::get('providers/trip/edit/{id}', 'admin\AdminTripController@edit')->name('dashboard.provider.trip.edit');
    Route::put('providers/trip/update/{id}', 'admin\AdminTripController@update')->name('dashboard.provider.trip.update');

    Route::get('participants', 'admin\AdminParticipantController@index')->name('dashboard.participants.index');
    Route::get('participants/create', 'admin\AdminParticipantController@create')->name('dashboard.participants.create');
    Route::delete('participants/{participant}', 'admin\AdminParticipantController@destroy')->name('dashboard.participants.destroy');

    Route::get('smsMarketer/{id?}', 'admin\AdminMarketersController@sms')->name('admin.marketer.sms');
    Route::post('smsMarketer/store', 'admin\AdminMarketersController@storeSms')->name('admin.marketer.storeSms');
    Route::get('admin/search', 'admin\AdminController@search')->name('admin.search');

    // Admin mange Cities in dashboared
    Route::get('admin/cities', 'admin\CityController@index')->name('admin.city.index');
    Route::get('admin/saveCity', 'admin\CityController@create')->name('admin.city.create');
    Route::post('admin/storeCity', 'admin\CityController@store')->name('admin.city.store');
    Route::get('admin/editCity/{id}', 'admin\CityController@edit')->name('admin.city.edit');
    Route::put('admin/updateCity/{id}', 'admin\CityController@update')->name('admin.city.update');
    Route::delete('admin/deleteCity/{id}', 'admin\CityController@delete')->name('admin.city.delete');
    // Admin mange Passengers tickets and reservation in dashboared

    Route::get('admin/passengres/reservation', 'admin\TicketController@index')->name('admin.ticket.index');
    Route::get('admin/passengres/sms/{phone}/{country}', 'admin\TicketController@sendsms')->name('admin.passenger.sendsms');
    Route::post('admin/passengres/sms', 'admin\TicketController@storesms')->name('admin.passenger.storesms');
});

Route::prefix('marketers')->middleware('marketer')->group(function () {
    Route::get('services', 'MarketersController@services')->name('dashboard.marketer.services');
    Route::get('archive', 'MarketersController@archive')->name('dashboard.marketer.index');
    Route::get('dashboard', 'MarketersController@showAccountInfo')->name('dashboard.marketer.showAccountInfo');
    Route::get('dashboard/setting', 'MarketersController@updateAccountInfoForm')->name('dashboard.marketer.updateAccountInfoForm');
    Route::get('dashboard/setting/MarketersController', 'MarketersController@UpdateAccountInfo')->name('dashboard.marketer.UpdateAccountInfo');

    Route::get('/download/{id}', 'ReservationsController@downloadImage')->name('image.download');

    // Route::get('settings', 'MarketersController@settings')->name('dashboard.marketer.setting');

    Route::get('reservations/confirm', 'ReservationsController@confirm')->name('dashboard.reservations.confirm');
    Route::post('reservations/confirm', 'ReservationsController@storeConfirm')->name('dashboard.reservations.storeConfirm');

    Route::get('/reservations/confirm/postpone/{id}', 'ReservationsController@postpone');
    Route::get('/reservations/confirm/cancel/{id}', 'ReservationsController@cancel');

    Route::get('reservation/date', 'ReservationsController@date')->name('reservation.date');
    Route::get('reservation/edit/{id}', 'ReservationsController@edit')->name('dashboard.reservations.edit');
    Route::post('reservation/update/{id}', 'ReservationsController@update')->name('dashboard.reservations.update');


    Route::get('reservations/postpone/{id}', 'ReservationsController@postpone')->name('dashboard.reservations.postpone');
    Route::post('reservations/storePostpone', 'ReservationsController@storePostpone')->name('dashboard.reservations.storePostpone');

    Route::get('reservations/cancel/{id}', 'ReservationsController@cancel')->name('dashboard.reservations.cancel');
    Route::post('reservations/storeCancel', 'ReservationsController@storeCancel')->name('dashboard.reservations.storeCancel');



    Route::get('reservations/confirm/index', 'MarketersController@confirm')->name('marketer.reservations.confirmAll');
    Route::get('reservations/postpone/index', 'MarketersController@postpone')->name('marketer.reservations.postponeAll');
    Route::get('reservations/postpone/index', 'MarketersController@postpone')->name('marketer.reservations.postponeAll');
    Route::get('reservations/cancel/index', 'MarketersController@cancel')->name('marketer.reservations.cancelAll');


    Route::get('trips', 'MarketersController@trips')->name('marketer.trips');


    Route::get('/search', 'MarketersController@search')->name('search');



    Route::get('sms/{id?}', 'MarketersController@sms')->name('dashboard.marketer.sms');
    Route::get('reservations/confirm/sms/{id?}', 'MarketersController@sms');
    Route::post('sms/store', 'MarketersController@storeSms')->name('dashboard.marketer.storeSms');
});
Route::prefix('provider')->middleware('provider')->group(function () {
    Route::get('dashboard', 'ProviderController@showAccountInfo')->name('dashboard.provider.showAccountInfo');
    Route::get('dashboard/carInfo', 'ProviderController@updateCarInfoForm')->name('dashboard.provider.updateCarInfoForm');

    Route::get('dashboard/setting', 'ProviderController@updateAccountInfoForm')->name('dashboard.provider.updateAccountInfoForm');
    Route::get('dashboard/setting/UpdateAccountInfo', 'ProviderController@UpdateAccountInfo')->name('dashboard.provider.UpdateAccountInfo');
    Route::get('dashboard/raiseOnMap/index', 'RaisOnMapController@index')->name('dashboard.raiseOnMap.index');
    Route::post('dashboard/raiseOnMap/store', 'RaisOnMapController@store')->name('dashboard.raiseOnMap.store');
    Route::delete('dashboard/raiseOnMap/delete/{id}', 'RaisOnMapController@destroy')->name('dashboard.raiseOnMap.destroy');
    Route::get('dashboard/raiseOnMap/share/{id}', 'RaisOnMapController@formShared')->name('dashboard.raiseOnMap.formShared');
    Route::post('dashboard/raiseOnMap/shareSend/{id}', 'RaisOnMapController@share')->name('dashboard.raiseOnMap.share');
    Route::get('dashboard/financialSetting/index', 'FinancialPermessionController@index')->name('dashboard.financialSetting.index');
    Route::post('dashboard/financialSetting/store', 'FinancialPermessionController@store')->name('dashboard.financialSetting.store');
    Route::delete('dashboard/financialSetting/delete/{id}', 'FinancialPermessionController@destroy')->name('dashboard.financialSetting.destroy');

    Route::get('reservations/confirm/index', 'ProviderController@confirm')->name('provider.reservations.confirmAll');
    Route::get('reservations/posts/index', 'ProviderController@posts')->name('provider.reservations.posts');
    Route::get('reservations/cancle_All/index', 'ProviderController@cancle_All')->name('provider.reservations.cancle_All');
    Route::get('reservations/confirm_car/index', 'ProviderController@confirm_car')->name('provider.reservations.confirmAll_car');

    Route::post('reservations/confirm', 'ProviderController@storeConfirm')->name('provider.reservations.storeConfirm');

    Route::get('reservations/postpone/{id}', 'ProviderController@postpone')->name('provider.reservations.postpone');
    Route::get('reservations/postpone_car/{id}', 'ProviderController@postpone_car')->name('provider.reservations.postpone_car');
    Route::post('reservations/storePostpone', 'ProviderController@storePostpone')->name('provider.reservations.storePostpone');
    Route::post('reservations/storePostpone_car', 'ProviderController@storePostpone_car')->name('provider.reservations.storePostpone_car');

    Route::get('reservations/cancel/{id}', 'ProviderController@cancel')->name('provider.reservations.cancel');
    Route::get('reservations/cancel_car/{id}', 'ProviderController@cancel_car')->name('provider.reservations.cancel_car');
    Route::post('reservations/storeCancel', 'ProviderController@storeCancel')->name('provider.reservations.storeCancel');
    Route::post('reservations/storeCancel_car', 'ProviderController@storeCancel_car')->name('provider.reservations.storeCancel_car');

    Route::get('reservations/transfer/{id}', 'ProviderController@transfer')->name('provider.reservations.transfer');
    Route::get('reservations/transfer_car/{id}', 'ProviderController@transfer_car')->name('provider.reservations.transfer_car');
    Route::post('reservations/storeTransfer', 'ProviderController@storetransfer')->name('provider.reservations.storetransfer');
    Route::post('reservations/storeTransfer_car', 'ProviderController@storetransfer_car')->name('provider.reservations.storetransfer_car');
    Route::get('provider/reservation/edit/{id}', 'ProviderController@edit')->name('provider.reservations.edit');
    Route::get('provider/reservation/passengers-list/{id}', 'ProviderController@passengersList')->name('provider.reservations.passengersList');
    Route::post('provider/reservation/savePassengersTickets', 'ProviderController@savePassengersTickets')->name('provider.reservations.savePassengersTickets');
    Route::post('provider/reservation/update/{id}', 'ProviderController@update')->name('provider.reservations.update');



    Route::get('sms/{id?}', 'ProviderController@sms')->name('provider.sms');
    Route::post('sms/store', 'ProviderController@storeSms')->name('provider.storeSms');


    Route::get('date', 'TripController@date')->name('date');

    Route::get('trips', 'TripController@index')->name('provider.trip.index');
    Route::get('trips_haj', 'TripController@haj')->name('provider.trip.haj');
    Route::get('trip/create', 'TripController@create')->name('provider.trip.create');
    Route::get('trip/create_haj', 'TripController@create_haj')->name('provider.trip.create_haj');
    Route::post('trip/store', 'TripController@store')->name('provider.trip.store');
    Route::post('trip/store_haj', 'TripController@store_haj')->name('provider.trip.store_haj');
    Route::get('trip/edit/{id}', 'TripController@edit')->name('provider.trip.edit');
    Route::put('trip/update/{id}', 'TripController@update')->name('provider.trip.update');
    Route::get('trip/delete/{id}', 'TripController@destroy')->name('provider.trip.destroy');
    Route::post('trip/filter', 'TripController@filter')->name('filter');
    Route::post('trip/filter_haj', 'TripController@filter_haj')->name('filter_haj');
    Route::get('provider/date', 'ProviderController@date')->name('provider.date');
    Route::get('/downloadImage/{id}', 'ProviderController@downloadImage')->name('provider.image.download');

    Route::get('dashboard/noms/index', 'FinancialPermessionController@noms')->name('provider.nom.index');
    Route::post('dashboard/noms/store', 'FinancialPermessionController@storeNoms')->name('provider.nom.store');
    Route::delete('dashboard/noms/delete/{id}', 'FinancialPermessionController@destroyNoms')->name('provider.nom.delete');
});

Route::prefix('dashboard')->middleware('lab')->group(function () {
    Route::get('lab/index', 'LabController@index')->name('dashboard.lab.index');
    Route::get('lab/pcrs', 'LabController@pcrs')->name('dashboard.lab.pcrs');
    Route::get('lab/dateTime/{id}', 'LabController@dateTime')->name('dashboard.lab.dateTime');
    Route::get('lab/checkedDate/{id}', 'LabController@checkedDate')->name('dashboard.lab.checkedDate');

    Route::get('lab/pcrsSuspend', 'LabController@pcrsSuspend')->name('dashboard.lab.pcrsSuspend');

    Route::get('lab/checkedForm/{id}', 'LabController@checkedForm')->name('dashboard.lab.checkedForm');
    Route::put('lab/checked/{id}', 'LabController@checked')->name('dashboard.lab.checked');
    Route::get('lab/setting', 'LabController@setting')->name('dashboard.lab.setting');
    Route::get('lab/takeForm/{id}', 'LabController@takeForm')->name('dashboard.lab.takeForm');
    Route::put('lab/take/{id}', 'LabController@take')->name('dashboard.lab.take');

    Route::put('lab/update', 'LabController@UpdateAccountInfo')->name('dashboard.lab.update');
    Route::get('lab/sms/{id}', 'LabController@sms')->name('dashboard.lab.sms');
    Route::post('lab/storeSms', 'LabController@storeSms')->name('dashboard.lab.storeSms');

    Route::get('/lab/share/{id}', 'LabController@formShared')->name('dashboard.lab.share');
    Route::Post('/lab/sharesend/{id}', 'LabController@share')->name('dashboard.lab.shareSend');
});

/* ----------------------- Passenger Section ------------------------*/


Route::get('/login/passenger', 'Auth\LoginController@showPassengerLoginForm')->name('login.passenger');
Route::get('/register/passenger', 'Auth\RegisterController@showPassengerRegisterForm')->name('register.passenger');

Route::post('/login/passenger', 'Auth\LoginController@passengerLogin');
Route::post('/register/passenger', 'Auth\RegisterController@createPassenger')->name('passenger.register');

// For Social login 
Route::get('passenger/login/{provider}', 'SocialController@redirect');
Route::get('passengers/login/{provider}/callback', 'SocialController@Callback');

// routes for non registed users
Route::prefix('passengers')->as('passengers.')->namespace('Passenger')->group(function () {
    Route::get('/', 'PassengerController@cards')->name('cards');
    // Route::get('/car', 'PassengerController@trips_car')->name('car');
    Route::get('/{slug}', 'PassengerController@index')->name('home');
    Route::get('/haj/{id}/details', 'PassengerController@hajDetails')->name('hajDetails');
    Route::get('/haj/{id}/checkout', 'TripCheckoutController@hajCheckout')->name('hajCheckout');
    Route::post('/haj/{id}/storeCheckout', 'TripCheckoutController@storeHajCheckout')->name('storeHajCheckout');
    Route::get('/haj/hajPayment/{reservationId}', 'TripCheckoutController@hajPayment')->name('hajPayment');
    Route::post('/haj/storeHajPayment/{reservationId}', 'TripCheckoutController@storeHajPayment')->name('storeHajPayment');
    Route::get('/haj/hajPaymentGateway/{reservationId}', 'TripCheckoutController@hajPaymentGateway')->name('hajPaymentGateway');
    Route::post('/haj/storeHajBankPayment/{reservationId}', 'TripCheckoutController@storeHajBankPayment')->name('storeHajBankPayment');
    // Route::get('/msg', 'PassengerController@trips_msg')->name('msg');
    // Route::get('/haj', 'PassengerController@trips_haj')->name('haj');
    Route::get('/searchTrips', 'PassengerController@searchTrips')->name('searchTrips');
    Route::get('/searchTrips_msg', 'PassengerController@searchTrips_msg')->name('searchTrips_msg');
    Route::get('/searchTrips_car', 'PassengerController@searchTrips_car')->name('searchTrips_car');
    Route::get('/searchTrips_haj', 'PassengerController@searchTrips_haj')->name('searchTrips_haj');

    Route::get('/reserveTrips/{id}', 'PassengerController@reserveTrips')->name('reserveTrips');
    Route::get('/reserveTrips_haj/{id}/{ticketNo}', 'PassengerController@reserveTrips_haj')->name('reserveTrips_haj');
    Route::post('/reserveTripOrder/{id}', 'TripCheckoutController@myTripOrder')->name('tripOrder');
    Route::get('/tripOrderPayments/{trip}/{reservation}', 'TripCheckoutController@tripPayment')->name('tripPayment');

    Route::get('/order/{id}', 'PassengerController@orderDetails')->name('orderDetails');

    Route::post('/TripsCheckout/{id}', 'TripCheckoutController@tripCheckout')->name('tripCheckout');
});

/// routes for registred users 

Route::prefix('passengers')->as('passengers.')->namespace('Passenger')
    ->middleware('passenger')->group(function () {

        // redirect to pay with telr payment gateway

    });

// For Payment with telr routes
Route::get('/handle-payment/success', 'Passenger\TripCheckoutController@success')->name('telr.success');
Route::get('/handle-payment/cancel', 'Passenger\TripCheckoutController@cancel')->name('telr.cancel');
Route::get('/handle-payment/declined', 'Passenger\TripCheckoutController@declined')->name('telr.declined');
