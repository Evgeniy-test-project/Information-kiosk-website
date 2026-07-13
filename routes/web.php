<?php

use App\Http\Controllers\KioskController;
use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;

Route::get('/', [KioskController::class, 'index'])->name('kiosk.index');

//категории
Route::get('/category/{category}', [KioskController::class, 'category'])->name('kiosk.category');

//документы
Route::get('/document/{document}', [KioskController::class, 'document'])->name('kiosk.document');
Route::get('/document/{document}/page/{page}', [KioskController::class, 'document'])
    ->where('page', '[0-9]+')
    ->name('kiosk.document.page');

//обратная связь
Route::get('/feedback', [KioskController::class, 'feedback'])->name('kiosk.feedback');
Route::post('/feedback', [KioskController::class, 'submitFeedback'])->name('kiosk.feedback.submit');
Route::get('/feedback/thanks', [KioskController::class, 'feedbackThanks'])->name('kiosk.feedback.thanks');

//pdf файл
//Route::get('/pdf/{filename}', [PdfController::class, 'showPdf'])->name('pdf.show');


Route::get('/test', function () { return view('test'); })->name('test');
