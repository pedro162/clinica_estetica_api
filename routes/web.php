<?php

use App\Application\Handlers\CreateNotificationHandler;
use App\Application\Services\NotificationApplicationService;
use App\Infrastructure\Persistence\Eloquent\EloquentNotificationRepository;
use App\Jobs\SendNotification;
use App\Mail\DefaultEmailHandler;
use App\Parametro;
use App\ParametroCampo;
use App\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;


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


Route::get('/test/sendemail', function () {

	$parameter = Parametro::where('key', '=', 'email')->where('type', '=', 'default')->where('active', '=', 'yes')->first();
	$fileds = $parameter->parametroCampo;
	$configParameters = [
		'mail.mailers.mailgun.transport' => null,
		'mail.mailers.mailgun.domain' => null,
		'mail.mailers.mailgun.secret' => null,
		'services.mailgun.domain' => null,
		'services.mailgun.secret' => null,

	];
	foreach ($fileds as $field) {
		$currentKey = $field->key;
		$currentValue = $field->parametroUser()->where('active', '=', 'yes')->first();
		switch (trim($currentKey)) {
			case 'transport':
				$configParameters['mail.mailers.mailgun.transport'] = $currentValue->p_value;
				break;
			case 'domain':
				$configParameters['mail.mailers.mailgun.domain'] = $currentValue->p_value;
				$configParameters['services.mailgun.domain'] = $currentValue->p_value;
				break;
			case 'secret':
				$configParameters['mail.mailers.mailgun.secret'] = $currentValue->p_value;
				$configParameters['services.mailgun.secret'] = $currentValue->p_value;
				break;
			default:
		}
	}

	config($configParameters);

	$resp = Mail::to('phedroclooney@gmail.com')
		->send(new DefaultEmailHandler());
	dd($resp);
});

Route::get('/metrics', function () {
	$metrics = [];

	// Exemplo 1: contador de requisições
	$metrics[] = '# HELP app_requests_total Total de requisições HTTP';
	$metrics[] = '# TYPE app_requests_total counter';
	$metrics[] = 'app_requests_total{method="GET",route="/"} 1';

	// Exemplo 2: usuários ativos
	$userCount = User::count();
	$metrics[] = '# HELP app_users_total Número total de usuários';
	$metrics[] = '# TYPE app_users_total gauge';
	$metrics[] = "app_users_total $userCount";

	// Exemplo 3: tempo atual do servidor
	$timestamp = time();
	$metrics[] = '# HELP app_server_time Timestamp atual do servidor';
	$metrics[] = '# TYPE app_server_time gauge';
	$metrics[] = "app_server_time $timestamp";

	return response(implode("\n", $metrics), 200)
		->header('Content-Type', 'text/plain; version=0.0.4');
});
