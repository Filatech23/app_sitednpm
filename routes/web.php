<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailController;
use App\Http\Controllers\HomeController;
use App\Mail\TestMail;
use App\Models\User;
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

//Contrôler du site

Route::get('/',[App\Http\Controllers\SiteController::class, 'index']);

// Route::get('/registerUsager',[App\Http\Controllers\SiteController::class, 'registre_usager']);
// Route::get('/logoutAgent',[App\Http\Controllers\SiteController::class, 'LogoutAgent']);
//
Route::get('/clear', function(){
	Artisan::call('config:cache');
	Artisan::call('route:clear');
});

Auth::routes();

// Route::get('/', function () {return redirect()->route('home');}); // redirection vers la page home si la ligne delete 

// Route::get('/',[App\Http\Controllers\SiteController::class, 'index']);
Route::get('weberror',[App\Http\Controllers\GiwuController::class, 'weberror']);

Route::post('contact',[App\Http\Controllers\ContactController::class, 'store']);

Route::get('{contain}uwig{code}',[App\Http\Controllers\SiteController::class, 'recupcode']);
Route::match(['get','post'],'loginagent',[App\Http\Controllers\SiteController::class, 'connexionAgent']);
Route::match(['get','post'],'inscriagent',[App\Http\Controllers\SiteController::class, 'InscriptionAgent']);

Route::group(['middleware' =>'App\Http\Middleware\GiwuMiddleware'],function(){
	
	Route::get('mypage',[App\Http\Controllers\SiteController::class, 'espaceAgent']);
	Route::get('createdoss/{id}/{type}',[App\Http\Controllers\SiteController::class, 'Aff_CreateDossier']);
	Route::post('AddDossier',[App\Http\Controllers\SiteController::class, 'Aff_CreateAddDossier']);
	
	Route::get('ParcoursDossier/{id}',[App\Http\Controllers\SiteController::class, 'Aff_ParcoursDossier']);
	Route::match(['get','post'],'dossierAgent',[App\Http\Controllers\SiteController::class, 'CreateDossierAgent']);

});


Route::group(['middleware' => 'auth'],function(){
    Route::get('manuel', [App\Http\Controllers\GiwuController::class, 'AfficherAideGiwu']);

    Route::get('home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::get('myprofile',[App\Http\Controllers\GiwuController::class, 'AfficherProfile']);
    Route::get('mysociety',[App\Http\Controllers\GiwuController::class, 'AfficherMySociete']);
    Route::match(['get','post'],'mysociety/updatepage',[App\Http\Controllers\GiwuController::class, 'UpdatePageSoc']);

    Route::match(['get','post'],'updateprofil',[App\Http\Controllers\GiwuController::class, 'UpdatePageProfile']);
    Route::match(['get','post'],'updatemdp',[App\Http\Controllers\GiwuController::class, 'UpdatePageMotDpas']);
    //User
    Route::get('users/AffichePopDelete/{code}',[App\Http\Controllers\UserController::class, 'AffichePopDelete']);
    Route::get('users/exporterExcel',[App\Http\Controllers\UserController::class, 'exporterExcel']);
    Route::get('users/exporterPdf',[App\Http\Controllers\UserController::class, 'exporterPdf']);
    //Menu
    Route::get('menu/AffichePopDelete/{id}',[App\Http\Controllers\MenuController::class, 'AffichePopDelete']);
    Route::get('menu/AffichePopAction/{id}',[App\Http\Controllers\MenuController::class, 'AffichePopAction']);
    Route::post('menu/actionUpdate',[App\Http\Controllers\MenuController::class, 'AjouterGiwuAction']);
    Route::post('menu/actionDelete',[App\Http\Controllers\MenuController::class, 'DeleteGiwuAction']);
    //Role
    Route::get('role/AffichePopDelete/{code}',[App\Http\Controllers\RoleController::class, 'AffichePopDelete']);
    //Trace
    Route::get('trace/exporterExcel',[App\Http\Controllers\SaveTraceController::class, 'exporterExcel']);
	Route::get('trace/exporterPdf',[App\Http\Controllers\SaveTraceController::class, 'exporterPdf']);
    
	/*
	|--------------------------------------------------------------------------
	|   MENUSITE
	|--------------------------------------------------------------------------
	*/
	Route::get('menusite/AffichePopDelete/{id}',[App\Http\Controllers\MenusiteController::class, 'AffichePopDelete']);
	Route::get('menusite/exporterExcel',[App\Http\Controllers\MenusiteController::class, 'exporterExcel']);
	Route::get('menusite/exporterPdf',[App\Http\Controllers\MenusiteController::class, 'exporterPdf']);
	Route::post('menusite/actionUpdate',[App\Http\Controllers\MenusiteController::class, 'MotifGiwuAction']);
	Route::get('menusite/AffichePopAction/{id}',[App\Http\Controllers\MenusiteController::class, 'AffichePopAction']);
	Route::get('menusite/valide{type}/{id}',[App\Http\Controllers\MenusiteController::class, 'show_Validation']);
	Route::post('menusite/affect{type}/{id}',[App\Http\Controllers\MenusiteController::class, 'Validation']);

	/*
	|--------------------------------------------------------------------------
	|   ACTIVITE
	|--------------------------------------------------------------------------
	*/
	Route::get('activite/AffichePopDelete/{id}',[App\Http\Controllers\ActiviteController::class, 'AffichePopDelete']);
	Route::get('activite/exporterExcel',[App\Http\Controllers\ActiviteController::class, 'exporterExcel']);
	Route::get('activite/exporterPdf',[App\Http\Controllers\ActiviteController::class, 'exporterPdf']);
	Route::post('activite/actionUpdate',[App\Http\Controllers\ActiviteController::class, 'MotifGiwuAction']);
	Route::get('activite/AffichePopAction/{id}',[App\Http\Controllers\ActiviteController::class, 'AffichePopAction']);
	Route::get('activite/valide{type}/{id}',[App\Http\Controllers\ActiviteController::class, 'show_Validation']);
	Route::post('activite/affect{type}/{id}',[App\Http\Controllers\ActiviteController::class, 'Validation']);

	/*
	|--------------------------------------------------------------------------
	|   CONTACT
	|--------------------------------------------------------------------------
	*/
	Route::get('contact/AffichePopDelete/{id}',[App\Http\Controllers\ContactController::class, 'AffichePopDelete']);
	Route::get('contact/exporterExcel',[App\Http\Controllers\ContactController::class, 'exporterExcel']);
	Route::get('contact/exporterPdf',[App\Http\Controllers\ContactController::class, 'exporterPdf']);

	/*
	|--------------------------------------------------------------------------
	|   DOCUMENT
	|--------------------------------------------------------------------------
	*/
	Route::get('docu/AffichePopDelete/{id}',[App\Http\Controllers\DocumentController::class, 'AffichePopDelete']);
	Route::get('docu/exporterExcel',[App\Http\Controllers\DocumentController::class, 'exporterExcel']);
	Route::get('docu/exporterPdf',[App\Http\Controllers\DocumentController::class, 'exporterPdf']);
	Route::post('docu/actionUpdate',[App\Http\Controllers\DocumentController::class, 'MotifGiwuAction']);
	Route::get('docu/AffichePopAction/{id}',[App\Http\Controllers\DocumentController::class, 'AffichePopAction']);
	Route::get('docu/valide{type}/{id}',[App\Http\Controllers\DocumentController::class, 'show_Validation']);
	Route::post('docu/affect{type}/{id}',[App\Http\Controllers\DocumentController::class, 'Validation']);

	//add-route-cms
    Route::resource('contact',App\Http\Controllers\ContactController::class, ['only' => ['index','create','destroy','edit','update','show']]);
    Route::resources([
        'users'=>App\Http\Controllers\UserController::class,
        'menu'=>App\Http\Controllers\MenuController::class,
        'role'=>App\Http\Controllers\RoleController::class,
        'trace'=>App\Http\Controllers\SaveTraceController::class,
		'menusite'=>App\Http\Controllers\MenusiteController::class,
		'activite'=>App\Http\Controllers\ActiviteController::class,
		'docu'=>App\Http\Controllers\DocumentController::class,
		//resources-giwu
    ]);
});

