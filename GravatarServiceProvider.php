<?php namespace NetForce\Gravatar;

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
            return new \NetForce\Gravatar\Gravatar($app);
        });

        // Booting
        $this->app->booting(function () {
            $loader = \Illuminate\Foundation\AliasLoader::getInstance();
            $loader->alias('Gravatar', '\NetForce\Gravatar\Facades\Gravatar');
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