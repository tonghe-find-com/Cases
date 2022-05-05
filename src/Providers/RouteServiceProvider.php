<?php

namespace TypiCMS\Modules\Cases\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Cases\Http\Controllers\Category\AdminController as CategoryAdminController;
use TypiCMS\Modules\Cases\Http\Controllers\Item\AdminController;
use TypiCMS\Modules\Cases\Http\Controllers\Category\ApiController as CategoryApiController;
use TypiCMS\Modules\Cases\Http\Controllers\Item\ApiController;
use TypiCMS\Modules\Cases\Http\Controllers\PublicController;

class RouteServiceProvider extends ServiceProvider
{
    public function map()
    {
        /*
         * Front office routes
         */
        if ($page = TypiCMS::getPageLinkedToModule('cases')) {
            $middleware = $page->private ? ['public', 'auth'] : ['public'];
            foreach (locales() as $lang) {
                if ($page->isPublished($lang) && $uri = $page->uri($lang)) {
                    Route::middleware($middleware)->prefix($uri)->name($lang.'::')->group(function (Router $router) {
                        $router->get('/', [PublicController::class, 'index'])->name('index-cases');
                        $router->get('{slug}', [PublicController::class, 'show'])->name('case');
                    });
                }
            }
        }


        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('casecategories', [CategoryAdminController::class, 'index'])->name('index-casecategories')->middleware('can:read casecategories');
            $router->get('casecategories/export', [CategoryAdminController::class, 'export'])->name('admin::export-casecategories')->middleware('can:read casecategories');
            $router->get('casecategories/create', [CategoryAdminController::class, 'create'])->name('create-casecategory')->middleware('can:create casecategories');
            $router->get('casecategories/{casecategory}/edit', [CategoryAdminController::class, 'edit'])->name('edit-casecategory')->middleware('can:read casecategories');
            $router->post('casecategories', [CategoryAdminController::class, 'store'])->name('store-casecategory')->middleware('can:create casecategories');
            $router->put('casecategories/{casecategory}', [CategoryAdminController::class, 'update'])->name('update-casecategory')->middleware('can:update casecategories');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('casecategories', [CategoryApiController::class, 'index'])->middleware('can:read casecategories');
            $router->patch('casecategories/{casecategory}', [CategoryApiController::class, 'updatePartial'])->middleware('can:update casecategories');
            $router->delete('casecategories/{casecategory}', [CategoryApiController::class, 'destroy'])->middleware('can:delete casecategories');
        });

        /*
         * Admin routes
         */
        Route::middleware('admin')->prefix('admin')->name('admin::')->group(function (Router $router) {
            $router->get('cases', [AdminController::class, 'index'])->name('index-cases')->middleware('can:read cases');
            $router->get('cases/export', [AdminController::class, 'export'])->name('admin::export-cases')->middleware('can:read cases');
            $router->get('cases/create', [AdminController::class, 'create'])->name('create-case')->middleware('can:create cases');
            $router->get('cases/{case}/edit', [AdminController::class, 'edit'])->name('edit-case')->middleware('can:read cases');
            $router->post('cases', [AdminController::class, 'store'])->name('store-case')->middleware('can:create cases');
            $router->put('cases/{case}', [AdminController::class, 'update'])->name('update-case')->middleware('can:update cases');
        });

        /*
         * API routes
         */
        Route::middleware(['api', 'auth:api'])->prefix('api')->group(function (Router $router) {
            $router->get('cases', [ApiController::class, 'index'])->middleware('can:read cases');
            $router->patch('cases/{case}', [ApiController::class, 'updatePartial'])->middleware('can:update cases');
            $router->delete('cases/{case}', [ApiController::class, 'destroy'])->middleware('can:delete cases');
        });
    }
}
