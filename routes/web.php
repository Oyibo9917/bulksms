<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;

// Route::get('/', function () {
//     return view('welcome');
// });

// Route::redirect('/', '/admin');

Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('key:generate');
    $exitCode = Artisan::call('config:clear');
    $exitCode = Artisan::call('cache:clear');
	$exitCode = Artisan::call('view:clear');
    $exitCode = Artisan::call('config:cache');
    return redirect('/');
});

Route::get('/prime/console/maintenance/mode', function() {
    $exitCode = Artisan::call('down');
    return redirect('/');
});

Route::get('/prime/console/site/suspend', function() {
    $exitCode = Artisan::call('down', [
        "--message" => "Sorry! This site has been suspended by the developer till... We apologize for any inconveniences"
    ]);
    return redirect('/');
});

Route::get('/prime/console/site/up', function() {
	$exitCode = Artisan::call('up');
	@unlink(storage_path().'/framework/down');
	return redirect('/');
});

Route::get('/prime/console/db/fresh', function() {
    $exitCode = Artisan::call('migrate:fresh');
    // $exitCode += Artisan::call('db:seed'); // Run seeders after refreshing migrations
    return redirect('/');
});

Route::get('/prime/console/db/run-sql', function() {
    // Path to your SQL files directory
    $sqlFilesDirectory = storage_path('app/public/query_bkp'); // Adjust this path as per your directory structure

    // Get all SQL files from the directory
    $sqlFiles = File::glob($sqlFilesDirectory . '/*.sql');

    foreach ($sqlFiles as $sqlFile) {
        // Read SQL file content
        $sql = File::get($sqlFile);

        // Execute SQL queries
        DB::unprepared($sql);
    }

    return redirect('/');
});