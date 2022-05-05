<?php

namespace TypiCMS\Modules\Cases\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use TypiCMS\Modules\Core\Facades\TypiCMS;
use TypiCMS\Modules\Core\Observers\SlugObserver;
use TypiCMS\Modules\Cases\Composers\SidebarViewComposer;
use TypiCMS\Modules\Cases\Facades\Casecategories;
use TypiCMS\Modules\Cases\Facades\Cases;
use TypiCMS\Modules\Cases\Models\Casecategory;
use TypiCMS\Modules\Cases\Models\Caseitem;

class ModuleServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'typicms.casecategories');
        $this->mergeConfigFrom(__DIR__.'/../config/permissions.php', 'typicms.permissions');

        $modules = $this->app['config']['typicms']['modules'];
        $this->app['config']->set('typicms.modules', array_merge(['cases' => ['linkable_to_page']], $modules));

        $this->loadViewsFrom(null, 'casecategories');
        $this->loadViewsFrom(null, 'cases');


        AliasLoader::getInstance()->alias('Casecategories', Casecategories::class);
        AliasLoader::getInstance()->alias('Cases', Cases::class);

               // Observers
               Casecategory::observe(new SlugObserver());
               Caseitem::observe(new SlugObserver());

               

        $this->publishes([
            __DIR__.'/../database/migrations/create_cases_table.php.stub' => getMigrationFileName('create_cases_table'),
        ], 'migrations');

        $this->publishes([
            __DIR__.'/../../resources/views' => resource_path('views/vendor/cases'),
        ], 'views');


 
        /*
         * Sidebar view composer
         */
        $this->app->view->composer('core::admin._sidebar', SidebarViewComposer::class);

        /*
         * Add the page in the view.
         */
        $this->app->view->composer('cases::public.*', function ($view) {
            $view->page = TypiCMS::getPageLinkedToModule('cases');
        });
    }

    public function register()
    {
        $app = $this->app;

        /*
         * Register route service provider
         */
        $app->register(RouteServiceProvider::class);

        $app->bind('Casecategories', Casecategory::class);
        $app->bind('Cases', Caseitem::class);
    }
}
