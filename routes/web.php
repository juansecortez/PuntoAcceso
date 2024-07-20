<?php

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

use App\Http\Controllers\UsoPuertaController;
use App\Http\Controllers\OrganizacionController;
Route::get('/', function () {
    return redirect('login');
});

Route::get('/clear-cache', function() {
    Artisan::call('config:clear');
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
    Artisan::call('config:cache');
    Artisan::call('route:cache');
    Artisan::call('view:clear');
    Artisan::call('view:cache');
    Artisan::call('optimize');
    Artisan::call('optimize:clear');
    return "Cache is cleared and optimize";
});

Auth::routes();

Route::get('home', 'DashboardController@index')->name('home');
Route::get('mapa_checadas', 'UsoPuertaController@mapaChecadas')->name('mapa_checadas');
Route::get('uso_puerta', 'UsoPuertaController@index')->name('uso_puerta.index');
Route::get('uso_puerta/export', [UsoPuertaController::class, 'export'])->name('uso_puerta.export');

Route::group(['middleware' => 'guest'], function() {
    Route::get('pricing', 'PageController@pricing')->name('page.pricing');
    Route::get('lock', 'PageController@lock')->name('page.lock');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('organizacion', [OrganizacionController::class, 'edit'])->name('organizacion.edit')->middleware('can:update,App\Organization');
    Route::put('organizacion', [OrganizacionController::class, 'update'])->name('organizacion.update')->middleware('can:update,App\Organization');
});



Route::group(['middleware' => 'auth'], function () {
    Route::resource('role', 'RoleController', ['except' => ['show', 'destroy']]);
    Route::resource('user', 'UserController', ['except' => ['show']]);
    Route::resource('empleado', 'EmpleadoController', ['except' => ['show']]);
    Route::resource('puertas', 'PuertaController', ['except' => ['show']]);
    Route::resource('contrato', 'ContratoController', ['except' => ['show']]);

    Route::get('profile', ['as' => 'profile.edit', 'uses' => 'ProfileController@edit']);
    Route::put('profile', ['as' => 'profile.update', 'uses' => 'ProfileController@update']);
    Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'ProfileController@password']);

    Route::get('maps/{page}', ['as' => 'page.maps', 'uses' => 'PageController@maps']);
    Route::get('components/{page}', ['as' => 'page.components', 'uses' => 'PageController@components']);
    Route::get('forms/{page}', ['as' => 'page.forms', 'uses' => 'PageController@forms']);
    Route::get('pages/{page}', ['as' => 'page.pages', 'uses' => 'PageController@pages']);
    Route::get('tables/{page}', ['as' => 'page.tables', 'uses' => 'PageController@tables']);
    Route::get('{page}', ['as' => 'page.index', 'uses' => 'PageController@index']);

    Route::get('empleados/{empleado}/assign_puertas', 'UsoPuertaController@assignPuertaToEmpleado')->name('empleados.assign_puertas');
    Route::post('empleados/{empleado}/assign_puerta/{puerta}', 'UsoPuertaController@storePuertaToEmpleado')->name('empleados.assign_puerta');
    Route::delete('empleados/{empleado}/unassign_puerta/{puerta}', 'UsoPuertaController@unassignPuertaToEmpleado')->name('empleados.unassign_puerta');
    Route::post('empleados/{empleado}/assign_all_puertas', 'UsoPuertaController@assignAllPuertasToEmpleado')->name('empleados.assign_all_puertas');
    Route::delete('empleados/{empleado}/unassign_all_puertas', 'UsoPuertaController@unassignAllPuertasToEmpleado')->name('empleados.unassign_all_puertas');

    Route::get('puertas/{puerta}/assign_empleados', 'UsoPuertaController@assignEmpleadoToPuerta')->name('puertas.assign_empleados');
    Route::post('puertas/{puerta}/assign_empleado/{empleado}', 'UsoPuertaController@storeEmpleadoToPuerta')->name('puertas.assign_empleado');
    Route::delete('puertas/{puerta}/unassign_empleado/{empleado}', 'UsoPuertaController@unassignEmpleadoToPuerta')->name('puertas.unassign_empleado');
    Route::post('puertas/{puerta}/assign_all_empleados', 'UsoPuertaController@assignAllEmpleadosToPuerta')->name('puertas.assign_all_empleados');
    Route::delete('puertas/{puerta}/unassign_all_empleados', 'UsoPuertaController@unassignAllEmpleadosToPuerta')->name('puertas.unassign_all_empleados');
    Route::post('puertas/assign_selected_to_all', 'UsoPuertaController@assignSelectedPuertasToAll')->name('puertas.assign_selected_to_all');
});
