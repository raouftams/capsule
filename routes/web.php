<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/locale', function (Illuminate\Http\Request $request) {
    $locale = $request->input('locale');
    if (! in_array($locale, ['en','ar'])) {
        abort(400);
    }
    session(['locale' => $locale]);

    return back();
})->name('locale.switch')->middleware('web');