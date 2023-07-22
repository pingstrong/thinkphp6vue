<?php

use think\facade\Route;
use app\common\middleware\AllowCrossDomain;
use app\apiadmin\middleware\AuthCheckToken;

Route::group(function () {
    Route::post('login', 'Login/login');
    Route::get('captcha', 'Login/verify');
    Route::get('loginout', 'Login/logout');
})->middleware([AllowCrossDomain::class]);

Route::group('member', function () {
    Route::get('/info', 'system.Member/info');
    Route::post('/add', 'system.Member/add');
    Route::post('/index', 'system.Member/index');
    Route::get('/del', 'system.Member/del');
    Route::post('/edit', 'system.Member/edit');
    Route::get('/findMemberRole', 'system.Member/findMemberRole');

    Route::post('/updateProfile', 'system.Member/updateProfile');
    Route::post('/changePwd', 'system.Member/changePwd');
})->middleware([AllowCrossDomain::class, AuthCheckToken::class]);


Route::group('menu', function () {
    Route::get('/router', 'system.Menu/getRouter');
    Route::get('/tree', 'system.Menu/menuTree');
    Route::post('/add', 'system.Menu/add');
    Route::post('/edit', 'system.Menu/edit');
    Route::get('/changeStatus', 'system.Menu/changeStatus');
    Route::post('/changeOrder', 'system.Menu/changeOrder');
    Route::get('/del', 'system.Menu/del');
})->middleware([AllowCrossDomain::class, AuthCheckToken::class]);


Route::group('role', function () {
    Route::post('/index', 'system.Role/index');
    Route::post('/add', 'system.Role/add');
    Route::get('/del', 'system.Role/del');
    Route::post('/edit', 'system.Role/edit');
    Route::get('/selectRoleMenuId', 'system.Role/selectRoleMenuId');
    Route::get('/changeStatus', 'system.Menu/changeStatus');
    Route::post('/changeOrder', 'system.Menu/changeOrder');
    Route::get('/selectRole', 'system.Role/selectRole');
})->middleware([AllowCrossDomain::class, AuthCheckToken::class]);


Route::group('datas', function () {
    Route::post('/index', 'data.Datas/index');
})->middleware([AllowCrossDomain::class, AuthCheckToken::class]);


Route::group('console', function () {
    Route::post('/getStatis', 'data.Console/getStatis');
    Route::post('/getChart', 'data.Console/getChart');
})->middleware([AllowCrossDomain::class, AuthCheckToken::class]);

Route::group('setting', function () {
    Route::any('/getListByKey', 'data.Setting/getListByKey');
    Route::post('/setItem', 'data.Setting/setItem');
    Route::get('/getTab', 'data.Setting/getTab');
})->middleware([AllowCrossDomain::class, AuthCheckToken::class]);


Route::group('generate', function () {
    Route::get('/selectTable', 'generate.Generate/selectTable');
    Route::post('/selectCloums', 'generate.Generate/selectCloums');
})->middleware([AllowCrossDomain::class, AuthCheckToken::class]);


Route::group('dept', function () {

    Route::get('/tree', 'system.Dept/deptTree');
    Route::post('/add', 'system.Dept/add');
    Route::post('/edit', 'system.Dept/edit');
    Route::post('/changeOrder', 'system.Dept/changeOrder');
    Route::get('/del', 'system.Dept/del');
})->middleware([AllowCrossDomain::class, AuthCheckToken::class]);


Route::group('files', function () {
    Route::post('/addset', 'files.Fileset/add');
    Route::get('/indexset', 'files.Fileset/index');
    Route::post('/index', 'files.Files/index');
    Route::get('/del', 'files.Files/del');
    Route::post('/batchRemove', 'files.Files/batchRemove');
})->middleware([AllowCrossDomain::class, AuthCheckToken::class]);


Route::rule('Uploads/index', 'Upload/uploads')
    ->middleware([AllowCrossDomain::class, AuthCheckToken::class]);


Route::group('generate', function () {
    Route::post('/getData', 'generate.Generate/getData');
    Route::post('/genEdit', 'generate.Generate/index');
    Route::post('/add', 'generate.Generate/add');
})->middleware([AllowCrossDomain::class, AuthCheckToken::class]);


Route::group('article', function () {
    Route::post('/category/index', 'article.Category/index');
    Route::post('/category/add', 'article.Category/add');
    Route::post('/category/edit', 'article.Category/edit');
    Route::post('/category/delete', 'article.Category/del');
    Route::post('/category/getAll', 'article.Category/getAll');
    Route::post('/category/getUpdateInfo', 'article.Category/getUpdateInfo');


    Route::post('/content/index', 'article.Content/index');
    Route::post('/content/add', 'article.Content/add');
    Route::post('/content/edit', 'article.Content/edit');
    Route::post('/content/delete', 'article.Content/del');
    Route::post('/content/updateExt', 'article.Content/updateExt');
    Route::post('/content/getUpdateInfo', 'article.Content/getUpdateInfo');
})->middleware([AllowCrossDomain::class, AuthCheckToken::class]);
