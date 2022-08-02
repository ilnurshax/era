<?php
/**
 * Created by PhpStorm.
 * User: Nur
 * Date: 11.07.2019
 * Time: 9:16
 */

namespace Ilnurshax\Era\Database;


use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class DatabaseAdditionalSettingsServiceProvider extends ServiceProvider
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

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        if (env('APP_DEBUG') && env('DB_ENABLE_LOG')) {
            DB::listen(function (QueryExecuted $query) {
                logger()->warning('['.$query->connection.'] (' . $query->time . ' ms) ' . $query->sql, ['bindings' => $query->bindings]);
            });
        }
    }
}
