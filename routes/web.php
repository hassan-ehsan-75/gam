<?php
use App\Http\Controllers\AgentController;
use App\Http\Controllers\CandinateController;
use App\Http\Controllers\GatheringController;
use App\Http\Controllers\ImportController;
use App\Http\Controllers\ImportFileController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

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




Route::group(['middleware'=>['guest']],function(){
    Route::get('/login', [UsersController::class,'loginPage'])->name('login');
    Route::post('/login',[UsersController::class,'login']);
});
Route::middleware(['auth'])->group(function () {
    Route::get('/logout',[UsersController::class,'logout']);
    //no need for middleware in the route
    Route::get('/home', function () {
        return view('welcome');
    })->name('home');

    Route::middleware(['role:admin'])->group(function () {
        Route::resource('roles', RolesController::class)->except(['show']);
        Route::resource('users', UsersController::class);
    });
    Route::middleware(['role:admin|Employee|user2'])->group(function () {
        Route::get('user/profile', [UsersController::class,'profile'])->name('users.profile');
        Route::get('importt/{gathering?}', [ImportFileController::class,'index'])->name('import.home');
        Route::get('import/create', [ImportFileController::class,'importForm'])->name('import.create');
        Route::post('import', [ImportFileController::class,'import'])->name('import.store');
        Route::get('stockss/{gathering?}/{bank?}/{branch?}', [ImportController::class,'index'])->name('import.index');
        Route::get('agentss/{gathering?}', [AgentController::class,'index'])->name('agent.index');
        Route::get('agents/create/{type?}', [AgentController::class,'create'])->name('agent.create');
        Route::post('agents/store/{type}', [AgentController::class,'store'])->name('agent.store');
        Route::get('stocks/{id}/edit', [ImportController::class,'edit'])->name('stock.edit');
        Route::put('stocks/{id}', [ImportController::class,'update'])->name('stock.update');
        Route::post('stocks/present-status/{id?}/{type?}', [ImportController::class,'changePresentStatus'])->name('stock.present-status');
        Route::get('stocks/print/{id}/{type?}', [ImportController::class,'printStock'])->name('stock.print');
        Route::get('stocks/enter', [ImportController::class,'enterStockForm'])->name('stock.enterForm');
        Route::get('stocks/answer', [ImportController::class,'answerForm'])->name('stock.answerForm');
        Route::resource('gatherings', GatheringController::class);
        Route::post('gatherings-close/{id?}', [GatheringController::class,'closeGathering'])->name('gathering.close');
        Route::resource('settings', SettingController::class);
        Route::resource('candidates', CandinateController::class)->middleware('permission:candidate');
        Route::get('candidates-vote', [CandinateController::class,'candidatesVotesForm'])->name('candidates.votes')->middleware('permission:candidate-answer');
        Route::resource('records', \App\Http\Controllers\RecordController::class)->middleware('permission:records');
        Route::resource('reasons', \App\Http\Controllers\ReasonController::class)->middleware('permission:records');
        Route::view('/main','main')->name('main');
        Route::get('/test',function (){
            $id=1;
           foreach (\App\Models\Stock::all() as $stock){
               if ($id!=($stock->id)) {
                   \Log::info($stock->id);
               }
               $id++;
            }
        });
    });
    
});


Route::get('export', [AgentController::class,'export']);