<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Favicon;
use App\Models\FooterSetting;
use App\Models\Item;
use App\Models\Logo;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;


class GeneralDataServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Fetch header and footer data
        $gs = FooterSetting::first() ?? null;
        $gl = Logo::first() ?? null;
        $gf = Favicon::first() ?? null;
        $categories = Category::with('subcategories.childcategories')->get() ?? collect(); // Return empty collection
        $all = Item::all() ?? collect(); // Return empty collection
    
        // Share the data with all views
        View::share('gs', $gs);
        View::share('gl', $gl);
        View::share('categories', $categories);
        View::share('all', $all);
        View::share('gf', $gf);
    }
    

    
}
