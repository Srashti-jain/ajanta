<?php

/*
    |--------------------------------------------------------------------------
    | bin.php
    |--------------------------------------------------------------------------
    |
    | All Recycle Bin routes can be found here.
    |
*/

use App\Http\Controllers\Trashed\TrashController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => ['SellerAdminMix', 'isActive', 'IsInstalled', 'switch_lang', 'auth']], function () {
    
    Route::prefix('manage/trash')->group(function(){

        Route::get('/variant/products',[TrashController::class,'getTrashedVariantProduct'])->name('trash.variant.products');

        Route::delete('/variant/products/{id}',[TrashController::class,'forceDeleteVariantProduct'])->name('force.trash.variant.products');

        Route::post('restore/variant/products/{id}',[TrashController::class,'restorevariantProducts'])->name('restore.variant.products');

        Route::get('/simple/products',[TrashController::class,'getTrashedSimpleProduct'])->name('trash.simple.products');

        Route::post('restore/simple/products/{id}',[TrashController::class,'restoresimpleProducts'])->name('restore.simple.products');

        Route::delete('/simple/products/{id}',[TrashController::class,'forceDeleteSimpleProduct'])->name('force.trash.simple.products');

    });

});