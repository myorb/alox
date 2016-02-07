<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use Ivory\GoogleMap\Map;
use Ivory\GoogleMap\MapTypeId;

Route::get('/', function () {
    return view('welcome');
});

Route::get('map', function () {
    $map = new Map();

    $map->setPrefixJavascriptVariable('map_');
    $map->setHtmlContainerId('map_canvas');

    $map->setAsync(false);
    $map->setAutoZoom(false);

    $map->setCenter(0, 0, true);
    $map->setMapOption('zoom', 3);

    $map->setBound(-2.1, -3.9, 2.6, 1.4, true, true);

    $map->setMapOption('mapTypeId', MapTypeId::ROADMAP);
    $map->setMapOption('mapTypeId', 'roadmap');

    $map->setMapOption('disableDefaultUI', true);
    $map->setMapOption('disableDoubleClickZoom', true);
    $map->setMapOptions(array(
        'disableDefaultUI'       => true,
        'disableDoubleClickZoom' => true,
    ));

    $map->setStylesheetOption('width', '300px');
    $map->setStylesheetOption('height', '300px');
    $map->setStylesheetOptions(array(
        'width'  => '300px',
        'height' => '300px',
    ));

    $map->setLanguage('en');
    return view('map',['map'=>$map]);

});

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    //
});
