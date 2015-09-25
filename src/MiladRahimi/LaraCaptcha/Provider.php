<?php namespace MiladRahimi\LaraCaptcha;

use Illuminate\Support\ServiceProvider;
use Response;
use Route;
use Session;
use Validator;

/**
 * Class Provider
 * Provider class is the service provider which developer must add to project providers
 *
 * @package MiladRahimi\LaraCaptcha
 * @author  Milad Rahimi "info@miladrahimi.com"
 */
class Provider extends ServiceProvider {
    
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        app()->bind('LaraCaptcha', function () {
            return new Captcha();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
        // Add Route
        $captcha = new Captcha();
        Route::get($captcha->getRoute(), function () use($captcha) {
            $captcha->draw();
        });
        /** @noinspection PhpUnusedParameterInspection */
        Validator::extend('laracaptcha', function ($attribute, $value, $parameters) {
            return (Session::get('laracaptcha') == strtoupper($value));
        });
    }
}