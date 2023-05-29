<?php

use App\Http\Controllers\admin\BannerController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\ContentLanguageController;
use App\Http\Controllers\admin\DashboardController;
use App\Http\Controllers\admin\NewsController;
use App\Http\Controllers\admin\ImageUploadController;
use App\Http\Controllers\admin\PageController;
use App\Http\Controllers\admin\RecruimentController;
use App\Http\Controllers\admin\UserController;
use App\Http\Controllers\admin\ColorController;
use App\Http\Controllers\admin\FontController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ConcatController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AboutController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\NewsController as ControllersNewsController;
use App\Http\Controllers\RecruitmentController;

use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/


Route::prefix('/')->middleware('Localization')->group(function () {
    Route::get('/', [HomeController::class,'index'])->name('home');
    Route::get('change-language/{language}', [HomeController::class, 'changeLanguage'])->name('change-language');
    Route::get('/', [HomeController::class,'index'])->name('home');

    Route::get('/about-us', [AboutController::class, 'index'])->name('about-us');

    Route::get('/contact-us', [ConcatController::class, 'index'])->name('concat');
    Route::post('/contact-us', [EmailController::class,'sendEmail'])->name('sendMail');

    Route::get('service', [ServiceController::class, 'index'])->name('service');
    
    Route::prefix('/news')->group( function () { 
        Route::get('/', [ControllersNewsController::class, 'index'])->name('news');
        Route::get('/?page={page}', [ControllersNewsController::class, 'index'])->name('news.paginate');
        Route::get('/{id}/{slug}', [ControllersNewsController::class, 'showDetail'])->name('news.detail');
    });
    Route::prefix('/recruitment')->group( function () {
        Route::get('/', [RecruitmentController::class, 'index'])->name('recruitment');
        Route::get('/?page={page}', [RecruitmentController::class, 'show'])->name('recruitment.paginate');
        Route::post('/recruitment/{id}', [EmailController::class, 'sendMailRecruitment'])->name('recruitment.sendMail');
        Route::get('/{id}/{recruitment}', [RecruitmentController::class, 'showDetail'])->name('recruitment.detail');
    });
});


Route::get('/login', [LoginController::class, 'index'])->name('admin.login');

Route::prefix('admin')->middleware('auth')->group(function () {
    
    Route::prefix('dashboard')->middleware('RoleAuthor')->group(function(){

        Route::get('/',[DashboardController::class, 'index'])->name('admin.dashboard');

        // Route::get('/user-data' , [demoController::class, 'index'])->name('demo.list');
        // Route::get('/user-data/get', [demoController::class, 'getData'])->name('demo.data');
      
        Route::prefix('manager-user')->middleware('RoleAdmin')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('admin.users');
            Route::get('/get-data', [UserController::class, 'getDataUser'])->name('admin.getDataUser');
            Route::get('/add', [UserController::class, 'showAddUser'])->name('admin.showaddUser');
            Route::post('/add', [UserController::class, 'store'])->name('admin.addUser');
            Route::get('/edit/{id}', [UserController::class, 'show'])->name('admin.getOnlyUser');
            Route::post('/update/{id}', [UserController::class, 'edit'])->name('admin.patchUser');
            Route::delete('/delete', [UserController::class, 'destroy'])->name('admin.destroy');

            //trash
            Route::get('/trash', [UserController::class, 'showTrash'])->name('admin.showTrashUser');
            Route::get('/trash-get-data', [UserController::class, 'getDataTrash'])->name('admin.dataTrashUser');
            Route::post('/trash/restore', [UserController::class, 'restoreTrash'])->name('admin.restoreTrashUser');
            Route::delete('/trash/permanent', [UserController::class, 'permanentTrash'])->name('admin.permanentTrashUser');
        });
        
        Route::prefix('manager-category')->middleware('RoleAdmin')->group(function() {
            Route::get('/', [CategoryController::class, 'index'])->name('admin.category');
            Route::get('/get-data', [CategoryController::class, 'getData'])->name('admin.getDataCategory');
            Route::get('/add', [CategoryController::class, 'show'])->name('admin.showAddCategory');
            Route::post('/add', [CategoryController::class, 'store'])->name('admin.addCategory');
            Route::get('/edit/{slug}/{id}', [CategoryController::class, 'edit'])
                    ->where('slug', '[a-zA-Z0-9-_]+')
                    ->where('id', '[a-zA-Z0-9-_]+')
                    ->name('admin.showedit');
            // Route::patch('/edit/{slug}/{id}', [CategoryController::class, 'update'])->name('admin.patchCategory');
            Route::patch('/edit/{id}', [CategoryController::class, 'update'])->name('admin.patchCategory');
            Route::delete('/delete', [CategoryController::class, 'destroy'])->name('admin.destroyCategory');
        });
        
        Route::prefix('manager-banner')->middleware('RoleAdmin')->group(function () {
            Route::get('/', [BannerController::class, 'index'])->name('admin.banner');
            Route::get('/get-data', [BannerController::class, 'getData'])->name('admin.getDataBanner');
            Route::get('/add', [BannerController::class, 'show'])->name('admin.showAddBanner');
            Route::post('/add', [BannerController::class, 'store'])->name('admin.addBanner');
            Route::get('/edit/{id}', [BannerController::class, 'edit'])
                    ->where('id', '[a-zA-Z0-9-_]+')
                    ->name('admin.bannerEdit');
            Route::post('/edit/{id}', [BannerController::class, 'update'])->name('admin.bannerUpdate');
            Route::delete('/delete', [BannerController::class, 'destroy'])->name('admin.destroyBanner');
        });

        Route::prefix('manager-news')->middleware('RoleAuthor')->group(function () {
            Route::get('/',[NewsController::class, 'index'])->name('admin.news');
            Route::get('/get-data', [NewsController::class, 'getData'])->name('admin.getDataNews');
            Route::get('/add', [NewsController::class, 'create'])->name('admin.showAddNew');
            Route::post('image-upload', [ImageUploadController::class, 'storeImage'])->name('image.upload');
            Route::post('/add', [NewsController::class, 'store'])->name('admin.addNew');
            Route::get('edit/{id}', [NewsController::class, 'edit'])->name('admin.newEdit');
            Route::post('edit/{id}', [NewsController::class, 'update'])->name('admin.newEdit');
            Route::delete('/delete', [NewsController::class, 'destroy'])->name('admin.destroyNews');
        });
        Route::prefix('manager-recruitments')->middleware('RoleAuthor')->group(function () {
            Route::get('/', [RecruimentController::class, 'index'])->name('admin.recruiment');
            Route::get('/get-data', [RecruimentController::class, 'getData'])->name('admin.getDataRecruitment');
            Route::get('/add', [RecruimentController::class, 'create'])->name('admin.showAddRecruitment');
            Route::post('/add', [RecruimentController::class, 'store'])->name('admin.addRecruitment');
            Route::get('/edit/{id}', [RecruimentController::class, 'edit'])->name('admin.recruitmentEdit');
            Route::patch('/edit/{id}', [RecruimentController::class, 'update'])->name('admin.recruitmentUpdate');
            Route::delete('/delete',[RecruimentController::class, 'destroy'])->name('admin.destroyRecruitment');

            //trash
            Route::get('/trash', [RecruimentController::class, 'showTrash'])->name('admin.showTrash');
            Route::post('/trash/restore', [RecruimentController::class, 'restoreTrash'])->name('admin.restoreTrash');
            Route::delete('/trash/permanent', [RecruimentController::class, 'permanentTrash'])->name('admin.permanentTrash');
        });

        Route::prefix('manager-languager')->middleware('RoleAdmin')->group(function () {
            Route::get('/', [ContentLanguageController::class, 'index'])->name('admin.ManagerContextLang');
            Route::get('/get-data', [ContentLanguageController::class, 'getData'])->name('admin.getDataContextLang');
            Route::get('/add', [ContentLanguageController::class, 'showAddContextLanguage'])->name('admin.showAddContextLang');
            Route::post('/add', [ContentLanguageController::class, 'store'])->name('admin.addContextLang');
            Route::get('edit/{id}', [ContentLanguageController::class, 'edit'])->name('admin.contentLanguageEdit');
            Route::patch('edit/{id}', [ContentLanguageController::class, 'update'])->name('admin.contentLanguageUpdate');
            Route::delete('/delete', [ContentLanguageController::class, 'destroy'])->name('admin.destroyContentLang');
            Route::post('/save-language', [ContentLanguageController::class, 'save'])->name('admin.saveContent');
            
            // Route::save('/save', [ContentLanguageController::class, 'save'])->name('admin.saveData');
        });

        Route::prefix('manager-page')->middleware('RoleAdmin')->group(function () {
            Route::get('/', [PageController::class, 'index'])->name('page');
            Route::get('/getData', [PageController::class, 'getData'])->name('page.getDataTable');
            Route::get('/add', [PageController::class, 'create'])->name('page.showAddPage');
            Route::post('/add', [PageController::class, 'store'])->name('page.handleAddPage');
            Route::get('/pageEdit/{id}', [PageController::class, 'edit'])->name('page.editPage');
            Route::post('/pageEdit/{id}', [PageController::class, 'update'])->name('page.handleEditContent');
            Route::delete('/delete', [PageController::class, 'destroy'])->name('page.deletePage');
        });

        Route::prefix('manager-color')->middleware('RoleAdmin')->group(function () {
            Route::get('/', [ColorController::class, 'index'])->name('admin.color');
            Route::post('/edit', [ColorController::class, 'updateColor'])->name('admin.updateColor');
        });


        Route::prefix('manager-font')->middleware('RoleAdmin')->group(function () {
            Route::get('/', [FontController::class, 'index'])->name('admin.font');
            Route::post('/update-font', [FontController::class, 'update'])->name('admin.updateFont');
            Route::get('/add', [FontController::class, 'create'])->name('admin.showCreate');
            Route::post('/add', [FontController::class, 'store'])->name('admin.addFont');
        });

    })->name('admin.dashboard');

});

require __DIR__.'/auth.php';
