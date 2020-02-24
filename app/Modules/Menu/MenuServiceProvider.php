<?php


namespace App\Modules\Menu;

use App\Domain\Menu\Menu;
use App\Modules\Menu\Persistence\EloquentItemRepository;
use App\Modules\Menu\Persistence\EloquentMenuRepository;
use App\Modules\Menu\Persistence\RedisMenuRepository;
use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Menu::class, function () {
            $menuCacheRepository = new RedisMenuRepository(new EloquentMenuRepository());
            return new Menu(
                $menuCacheRepository,
                new EloquentItemRepository($menuCacheRepository),
                new UniqueIdIdentityGenerator()
            );
        });
    }
}
