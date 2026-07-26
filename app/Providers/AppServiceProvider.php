<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Only when served behind a tunnel/proxy (e.g. ngrok), rewrite asset()/url() to the
        // forwarded host + scheme so mobile devices can load assets. Direct local access
        // (127.0.0.1:8000) is left untouched so the port is preserved.
        $request = $this->app['request'];
        $forwardedHost = $request->header('X-Forwarded-Host');

        if ($forwardedHost) {
            $scheme = $request->header('X-Forwarded-Proto') === 'https' || $request->isSecure() ? 'https' : 'http';
            URL::forceScheme($scheme);
            URL::forceRootUrl($scheme . '://' . $forwardedHost);
        }

        Blade::directive('datetime', function ($expression) {
            return "<?php echo \\Carbon\\Carbon::parse($expression)->format('M d, Y H:i'); ?>";
        });
    }
}
