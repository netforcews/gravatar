<?php namespace NetForce\Common\Gravatar;

use Illuminate\Foundation\AliasLoader;

class GrvatarServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Preprar framework
     */
    public function boot()
    {
        // Publicar configuracao
        //$this->publishes([ __DIR__ . self::configFile => config_path('gravatar.php')], 'config');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        // Mesclar config, se definido
        //$this->mergeConfigFrom(__DIR__ . self::configFile, 'gravatar');

        // Registrar provider
        $this->app->singleton('gravatar', function ($app) {
            return new \NetForce\Common\Gravatar\Gravatar($app);
        });

        // Booting
        $this->app->booting(function () {

            // Registrar alias de Facades
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