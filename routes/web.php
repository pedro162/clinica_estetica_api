<?php

use App\Application\Handlers\CreateNotificationHandler;
use App\Application\Services\NotificationApplicationService;
use App\Infrastructure\Persistence\Eloquent\EloquentNotificationRepository;
use App\Jobs\SendNotification;
use Illuminate\Support\Facades\Route;

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

Route::get('/test/sendont', function () {

	$objRepo = new EloquentNotificationRepository();
	$objCreatHandler = new CreateNotificationHandler($objRepo);
	$objServiceNotification = new NotificationApplicationService($objCreatHandler);
	$resp = $objServiceNotification->sendNotificationOfId(11);
	dd($resp);
});
Route::get('/test/rabbitmq', function () {
	$resp = SendNotification::dispatch('fafafafafafa')->onQueue('notifications');
	dd($resp);
});
Route::get('/', ['as' => 'site.home', 'uses' => 'Site\SiteController@index']);
