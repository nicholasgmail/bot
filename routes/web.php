<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BotController;
use App\Http\Controllers\Bot\{SettingController, TelegramController};
use \App\Http\Controllers\{GameController,
    StorylineController,
    CategoryController,
    MessageController,
    ImageController,
    VideoController,
    CubeController,
    VariableController,
    KitController,
    DialogTelegramController
};
use App\Jobs\TelergamMessage;

//use Telegram;
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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/register', function () {
    return view('welcome');
});


Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::get('/bot', [BotController::class, 'index'])->name('bot');
    Route::get('/kits', [KitController::class, 'index'])->name('kits');
    Route::get('/dialog_telegram', [DialogTelegramController::class, 'index'])->name('dialog_telegram');

    Route::post('/setting/store', [SettingController::class, 'store'])->name('setting.store');
    Route::post('settings/setwebhook', [BotController::class, 'setwebhook'])->name('setting.setwebhook');
    Route::post('settings/getwebhookinfo', [BotController::class, 'getwebhookinfo'])->name('setting.getwebhookinfo');
    Route::get('settings/testTocken', [BotController::class, 'testTocken'])->name('testTocken');
    //создание и формирование игры
    Route::prefix('game')->group(function () {
        Route::get('/list', [GameController::class, 'index'])->name('games');
        Route::get('/{id}', [GameController::class, 'edit'])->name('game_edit');
    });

    //создание и формирования сюжета
    Route::prefix('storylines')->group(function () {
        Route::get('/list', [StorylineController::class, 'index'])->name('storyline');
        Route::get('/{id}', [StorylineController::class, 'edit'])->name('storyline_edit');
        Route::get('/{id}/update', [StorylineController::class, 'update'])->name('storyline_update');
    });
    //создание клеток
    Route::prefix('categories')->group(function () {
        Route::get('/list', [CategoryController::class, 'index'])->name('categories');
        Route::get('/{id}', [CategoryController::class, 'edit'])->name('category_edit');
    });
    //создание клеток
    Route::prefix('cube')->group(function () {
        Route::get('/list', [CubeController::class, 'index'])->name('dices');
        Route::get('/{id}', [CubeController::class, 'edit'])->name('dice_edit');
    });
    //редактирование сообщений
    Route::get('/message/{id}', [MessageController::class, 'edit'])->name('message_edit');
    Route::get('/image/{id}/{type}', [ImageController::class, 'edit'])->name('image_edit');
    Route::get('/video/{id}', [VideoController::class, 'edit'])->name('video_edit');

    //создание клеток
    Route::prefix('variable')->group(function () {
        Route::get('/list', [VariableController::class, 'index'])->name('variables_index');
        Route::get('/{id}', [VariableController::class, 'edit'])->name('variable_edit');
    });
});

Route::post(Telegram::getAccessToken() . '/webhook', [TelegramController::class, 'webhook'])->middleware('will.stop');


/*Route::get(Telegram::getAccessToken() . '/webhook', function (){
   // app('App\Http\Controllers\Bot\TelegramConrtoller')->webhook();
    TelergamMessage::dispatch('Test Message');
});*/
/*Route::post(Telegram::getAccessToken() . '/webhook', function(){
    $update = Telegram::commandsHandler(true);
    return 1;
});*/

/*Route::get('/updated-activity', [BotController::class, 'updatedActivity']);
Route::get('/test', [GameController::class, 'test'])->name('test');
Route::get('/test2', [GameController::class, 'test2'])->name('test2');*/


