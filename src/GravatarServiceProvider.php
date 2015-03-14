<?php namespace NetForce\Common\Gravatar;

use Illuminate\Foundation\AliasLoader;

class GravatarServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Registrar provider
        $this->app->singleton('gravatar', function ($app) {
            return new \NetForce\Common\Gravatar\Gravatar($app);
        });

        // Booting
        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Gravatar', '\NetForce\Common\Gravatar\Facades\Gravatar');
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['gravatar'];
    }
}