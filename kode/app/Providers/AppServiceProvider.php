<?php

namespace App\Providers;

use App\Enums\StatusEnum;
use App\Models\Category;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str; 
use Illuminate\Pagination\Paginator;
use App\Models\Language;
use App\Models\Menu;
use App\Models\Page;
use App\Models\SupportTicket;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Set memory and time limits
        ini_set('memory_limit', '-1');
        set_time_limit(0);


       
        try {
            // Check database connection
            DB::connection()->getPdo();

            // Use Bootstrap for pagination
            Paginator::useBootstrap();

            // Share variables with all views
            view()->share([
                'languages' => Language::where('status',(StatusEnum::true)->status())->get(),
            ]);

            $menus = Menu::orderBy('serial_id')->active()->get();
            $pages = Page::active()->latest()->get();

            view()->composer('frontend.partials.footer', function ($view) use($menus,$pages)  {
         
                $view->with([
                    'pages'           => $pages,
                    'menus'           => $menus->where('show_in_footer',StatusEnum::true->status()),
                    'quick_menus'           => $menus->where('show_in_quick_link',StatusEnum::true->status())
                ]);
            });

            view()->composer('user.auth.register', function ($view) use($menus,$pages)  {
         
                $view->with([
                    'pages'           => $pages,
                ]);
            });

            view()->composer('frontend.partials.header', function ($view) use($menus)  {

                $view->with([
                    'menus'           => $menus->where('show_in_header',StatusEnum::true->status())
                ]);
            });
            view()->composer('frontend.section.support', function ($view)   {
                $view->with([
                    'categories'      => Category::active()->latest()->get()
                ]);
            });

            view()->composer('admin.partials.sidebar', function ($view)   {

                $view->with([
                    'pending_tickets' => SupportTicket::withOutGlobalScope('autoload')->agent()->pending()->count()
                ]);
            });

        } catch (\Exception $ex) {
            // Handle exceptions if needed
        }
    }

}
