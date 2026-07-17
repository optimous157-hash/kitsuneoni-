<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        Blade::directive('datetime', function ($expression) {
            return "<?php echo \\Carbon\\Carbon::parse($expression)->format('M d, Y H:i'); ?>";
        });
    }
}
