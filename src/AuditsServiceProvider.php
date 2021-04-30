<?php

namespace Pharaonic\Laravel\Audits;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\ServiceProvider;

class AuditsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // Auditable on Create/Update
        Blueprint::macro('auditable', function ($precision = 0) {
            $this->string('created_by')->nullable();
            $this->timestamp('created_at', $precision)->nullable();

            $this->string('updated_by')->nullable();
            $this->timestamp('updated_at', $precision)->nullable();
        });

        // Auditable on Create/Update/SoftDelete
        Blueprint::macro('auditableWithSoftDeletes', function ($precision = 0) {
            $this->string('created_by')->nullable();
            $this->timestamp('created_at', $precision)->nullable();

            $this->string('updated_by')->nullable();
            $this->timestamp('updated_at', $precision)->nullable();

            $this->string('deleted_by')->nullable();
            $this->timestamp('deleted_at', $precision)->nullable();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publishes
        $this->publishes([
            __DIR__ . '/config.php' => config_path('Pharaonic/auditable.php'),
        ], ['pharaonic', 'laravel-auditable']);
    }
}
