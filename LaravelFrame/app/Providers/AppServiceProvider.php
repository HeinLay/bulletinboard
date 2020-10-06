<?php

namespace App\Providers;

use DB;
use Laravel\Passport\Passport;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Log;

class AppServiceProvider extends ServiceProvider
{
  /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];
  /**
   * Bootstrap any application services.
   *
   * @return void
   */
  public function boot()
  {
    $this->registerPolicies();

    Passport::routes();
    // Debug log for SQL
    DB::listen(
      function ($sql) {
        foreach ($sql->bindings as $i => $binding) {
          if ($binding instanceof \DateTime) {
            $sql->bindings[$i] = $binding->format('\'Y-m-d H:i:s\'');
          } else {
            if (is_string($binding)) {
              $sql->bindings[$i] = "'$binding'";
            }
          }
        }
        // Insert bindings into query
        $query = str_replace(array('%', '?'), array('%%', '%s'), $sql->sql);
        $query = vsprintf($query, $sql->bindings);
        Log::debug($query);
      }
    );
  }

  /**
   * Register any application services.
   *
   * @return void
   */
  public function register()
  {
    // Dao Registration
    $this->app->bind('App\Contracts\Dao\Auth\AuthDaoInterface', 'App\Dao\Auth\AuthDao');
    $this->app->bind('App\Contracts\Dao\User\UserDaoInterface', 'App\Dao\User\UserDao');

    // Business logic registration
    $this->app->bind('App\Contracts\Services\Auth\AuthServiceInterface', 'App\Services\Auth\AuthService');
    $this->app->bind('App\Contracts\Services\User\UserServiceInterface', 'App\Services\User\UserService');
  }
}
