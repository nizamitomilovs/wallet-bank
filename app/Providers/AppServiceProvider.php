<?php

namespace App\Providers;

use App\Repositories\CurrenciesRepositories\CurrenciesRepositoryInterface;
use App\Repositories\CurrenciesRepositories\LatvijasBankRepository;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    public function boot()
    {
        Blade::directive('convertMoney', function ($money) {
            return "<?php echo number_format($money / 100, 2); ?>";
        });

        $this->app->bind(CurrenciesRepositoryInterface::class, LatvijasBankRepository::class);
    }
}
