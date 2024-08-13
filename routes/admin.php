<?php

use App\Http\Controllers\Admin\AccountController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BanksController;
use App\Http\Controllers\Admin\CountryController ;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\OrdersController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\ProgramsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CurranciesController;
use App\Http\Controllers\Admin\FieldsController;
use App\Http\Controllers\Admin\OrderStatusController;
use App\Http\Controllers\Admin\PeriodGlobalController;
use App\Http\Controllers\Admin\InterestCalcsController;
use App\Http\Controllers\Admin\PaymentController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    [
        'prefix' => LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){
        Route::prefix('/dashboard')->group(function(){
        Route::get('/',[DashboardController::class,'index'])->name('dashboard.index');



        Route::prefix('period/global')->group(function(){
            Route::get('/index',[PeriodGlobalController::class,'index'])->name('period.global.index');
            Route::get('/dataTable',[PeriodGlobalController::class,'getData'])->name('period.global.dataTable');
            Route::get('/create',[PeriodGlobalController::class,'create'])->name('period.global.create');
            Route::post('/store',[PeriodGlobalController::class,'store'])->name('period.global.store');
            Route::get('/edit/{PeroidGlobel}',[PeriodGlobalController::class,'edit'])->name('period.global.edit');
            Route::post('/update',[PeriodGlobalController::class,'update'])->name('period.global.update');
            Route::get('/archive/{PeroidGlobel}',[PeriodGlobalController::class,'archive'])->name('period.global.archive');
            Route::get('/archiveList',[PeriodGlobalController::class,'archiveList'])->name('period.global.archived');
            Route::get('/getArchived',[PeriodGlobalController::class,'getArchived'])->name('period.global.archivedData');
            Route::get('/restore/{id}',[PeriodGlobalController::class,'restore'])->name('period.global.restore');
        });
        Route::prefix('interest/calculator')->group(function(){
            Route::get('/index',[InterestCalcsController::class,'index'])->name('interest.calculator.index');
            Route::get('/dataTable',[InterestCalcsController::class,'getData'])->name('interest.calculator.dataTable');
            Route::post('/store',[InterestCalcsController::class,'store'])->name('interest.calculator.store');
            Route::post('/update',[InterestCalcsController::class,'update'])->name('interest.calculator.update');
            Route::get('/delete/{InterestCalc}',[InterestCalcsController::class,'delete'])->name('interest.calculator.delete');
        });

        Route::prefix('programs')->group(function(){
            ////////types start
            Route::prefix('types')->group(function(){
                Route::get('/list',[ProgramsController::class,'types_index'])->name('programs.types.index');
                Route::get('/dataTable',[ProgramsController::class,'types_getData'])->name('programs.types.dataTable');
                Route::post('/store',[ProgramsController::class,'types_store'])->name('programs.types.store');
                Route::post('/update',[ProgramsController::class,'types_update'])->name('programs.types.update');
                Route::get('/delete/{ProgramTypes}',[ProgramsController::class,'types_delete'])->name('programs.types.delete');
            });

            ////types end

            ////fields end

            ////start programs
            Route::get('/index',[ProgramsController::class,'index'])->name('programs.index');
            Route::get('/dataTable',[ProgramsController::class,'getData'])->name('programs.dataTable');
            Route::get('/create',[ProgramsController::class,'create'])->name('programs.create');
            Route::post('/store',[ProgramsController::class,'store'])->name('programs.store');
            Route::get('/edit/{program}',[ProgramsController::class,'edit'])->name('programs.edit');
            Route::post('/update',[ProgramsController::class,'update'])->name('programs.update');
            Route::get('/archive/{program}',[ProgramsController::class,'archive'])->name('programs.archive');
            Route::get('/archiveList',[ProgramsController::class,'archiveList'])->name('programs.archived');
            Route::get('/getArchived',[ProgramsController::class,'getArchived'])->name('programs.archivedData');
            Route::get('/restore/{id}',[ProgramsController::class,'restore'])->name('programs.restore');

            ////program period start
            Route::get('/periods/list/{program}',[ProgramsController::class,'period_list'])->name('period.list');
            Route::get('/periods/dataTable/{id}',[ProgramsController::class,'period_getData'])->name('period.dataTable');
            Route::post('/period/store',[ProgramsController::class,'period_store'])->name('period.store');
            Route::post('/period/update',[ProgramsController::class,'period_update'])->name('period.update');
            Route::get('/delete/{Program_period}',[ProgramsController::class,'period_delete'])->name('period.delete');

            //// program period end
            //// contract start
            Route::get('/contract/list/{program}',[ProgramsController::class,'contract_list'])->name('contract.list');
            Route::get('/contract/dataTable/{id}',[ProgramsController::class,'contract_getData'])->name('contract.dataTable');
            Route::post('/contract/store',[ProgramsController::class,'contract_store'])->name('contract.store');
            Route::post('/contract/update',[ProgramsController::class,'contract_update'])->name('contract.update');
            Route::get('/contract/delete/{ContractProgram}',[ProgramsController::class,'contract_delete'])->name('contract.delete');




            //// contract end


            //end programs


        });
        Route::prefix('currency')->group(function(){
            Route::get('/list',[CurranciesController::class,'index'])->name('currency.index');
            Route::get('/dataTable',[CurranciesController::class,'getData'])->name('currency.dataTable');
            Route::post('/store',[CurranciesController::class,'store'])->name('currency.store');
            Route::post('/update',[CurranciesController::class,'update'])->name('currency.update');
            Route::get('/delete/{currency}',[CurranciesController::class,'delete'])->name('currency.delete');
            Route::put('/status/change', [CurranciesController::class, 'status'])->name('currency.status');

        });
        Route::prefix('country')->group(function(){
            Route::get('/list',[CountryController::class,'index'])->name('country.index');
            Route::get('/dataTable',[CountryController::class,'getData'])->name('country.dataTable');
            Route::post('/store',[CountryController::class,'store'])->name('country.store');
            Route::post('/update',[CountryController::class,'update'])->name('country.update');
            Route::get('/delete/{country}',[CountryController::class,'delete'])->name('country.delete');
            Route::put('/status/change', [CountryController::class, 'status'])->name('country.status');

        });
        ////////////////
        Route::prefix('Banks')->group(function(){
            Route::get('/list',[BanksController::class,'index'])->name('Banks.index');
            Route::get('/dataTable',[BanksController::class,'getData'])->name('Banks.dataTable');
            Route::post('/store',[BanksController::class,'store'])->name('Banks.store');
            Route::post('/update',[BanksController::class,'update'])->name('Banks.update');
            Route::put('/status/change', [BanksController::class, 'status'])->name('Banks.status');

        });


        Route::prefix('Payment')->group(function(){
            Route::get('/list',[PaymentController::class,'index'])->name('Payment.index');
            Route::get('/dataTable',[PaymentController::class,'getData'])->name('Payment.dataTable');
            Route::post('/store',[PaymentController::class,'store'])->name('Payment.store');
            Route::post('/update',[PaymentController::class,'update'])->name('Payment.update');
            Route::put('/status/change', [PaymentController::class, 'status'])->name('Payment.status');

        });
        ///////////////////////
        Route::prefix('Account')->group(function(){
            Route::get('/list',[AccountController::class,'index'])->name('Account.index');
            Route::get('/dataTable',[AccountController::class,'getData'])->name('Account.dataTable');
            Route::post('/store',[AccountController::class,'store'])->name('Account.store');
            Route::post('/update',[AccountController::class,'update'])->name('Account.update');
            Route::put('/status/change', [AccountController::class, 'status'])->name('Account.status');
            Route::get('/Withdrawals/{account_id}',[AccountController::class,'Withdrawals'])->name('Account.Withdrawals');
            Route::get('/Withdrawals/datatable/{account_id}',[AccountController::class,'withdrawals_data'])->name('Account.Withdrawals.datatable');
            Route::post('/update/status/Withdrawals',[AccountController::class,'update_status'])->name('Account.updateStatus');
            Route::post('/add/to/walit/by/admin',[AccountController::class,'add_to_walit_by_admin'])->name('Account.add.to.walit.by.admin');
            ////demo
            Route::get('/demo',[AccountController::class,'demo'])->name('Account.demo');
            Route::get('/demo/dataTable',[AccountController::class,'getData_demo'])->name('Account.dataTable.demo');
        });

        Route::prefix('fields')->group(function(){
            Route::get('/list',[FieldsController::class,'index'])->name('fields.index');
            Route::get('/dataTable',[FieldsController::class,'datatable'])->name('fields.dataTable');
            Route::post('/store',[FieldsController::class,'store'])->name('fields.store');
            Route::post('/update',[FieldsController::class,'update'])->name('fields.update');
            Route::get('/countries',[FieldsController::class,'countries'])->name('fields.countirs');
            Route::get('/countries/fields/{id}',[FieldsController::class,'countries_fields'])->name('fields.countirs_fields');
            Route::get('/countries/fields/datatable/{id}',[FieldsController::class,'countries_fields_datatable'])->name('fields.countries_fields_datatable');
            Route::post('/store/fields/country',[FieldsController::class,'store_fields_country'])->name('store.fields.country');
            Route::put('/status/change', [FieldsController::class, 'status'])->name('fields.status');

        });
        // Route::prefix('order/status')->group(function(){
        //     Route::get('/list',[OrderStatusController::class,'index'])->name('order.status.index');
        //     Route::get('/dataTable',[OrderStatusController::class,'getData'])->name('order.status.dataTable');
        //     Route::post('/store',[OrderStatusController::class,'store'])->name('order.status.store');
        //     Route::post('/update',[OrderStatusController::class,'update'])->name('order.status.update');
        //     Route::get('/delete/{orderStatu}',[OrderStatusController::class,'delete'])->name('order.status.delete');
        // });


        // Route::prefix('orders')->group(function(){
        //     Route::get('/list',[OrdersController::class,'index'])->name('orders.index');
        //     Route::get('/dataTable/{id?}',[OrdersController::class,'getData'])->name('order.dataTable');
        //     Route::get('/details/{id}', [OrdersController::class, 'order_details'])->name('order.details');
        //     Route::post('/change/status/order/{id}',[OrdersController::class, 'order_status'])->name('order.status');
        //     Route::get('/month/installment',[OrdersController::class,'installment'])->name('get.month.installment');
        //     Route::get('/month/installmen/datatable',[OrdersController::class,'installment_datatable'])->name('get.month.installment.datatable');
        //     Route::get('/month/installmen/status/{id}',[OrdersController::class,'installment_status'])->name('get.month.installment.status');
        //     Route::get('/installmen/History',[OrdersController::class,'installment_history'])->name('get.installment.history');
        //     Route::get('/installmen/History/datatable',[OrdersController::class,'installment_history_datatable'])->name('get.installment.datatable.history');

        // });
        Route::prefix('Customer')->group(function(){
            Route::get('/list',[CustomerController::class,'index'])->name('customer.index');
            Route::get('/dataTable/{id?}',[CustomerController::class,'getData'])->name('customer.dataTable');
            Route::get('/is_verified/{id}', [CustomerController::class, 'is_verified'])->name('customer.is_verified');
            Route::get('/is_approve_id/{id}', [CustomerController::class, 'is_approve_id'])->name('customer.is_approve_id');
            Route::get('/verifications/{customer}',[CustomerController::class,'verifications'])->name('customer.verifications');
            Route::post('/status/update/{id}', [CustomerController::class, 'updateStatus'])->name('customer.verifications.status.update');

        });

        Route::prefix('User')->group(function(){
            Route::get('/list',[UsersController::class,'index'])->name('user.index');
            Route::get('/dataTable/{id?}',[UsersController::class,'getData'])->name('user.dataTable');
            Route::put('/status/change', [UsersController::class, 'status'])->name('user.status');
            Route::post('/store',[UsersController::class,'store'])->name('user.store');
            Route::post('/update',[UsersController::class,'update'])->name('user.update');

        });



        });

    });
