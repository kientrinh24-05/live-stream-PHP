<?php

namespace App\Providers;

use App\Http\View\Composers\MenuComposer;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;


class ViewServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(MenuComposer::class);
    }

    public function boot()
    {
        View::composer([
            'admin.layout.sidebarMain',
            'admin.apps.*',
            'admin.news.new_tutorial.add',
            'admin.news.new_tutorial.edit',
            'admin.data.*'
        ], MenuComposer::class);
    }
}
