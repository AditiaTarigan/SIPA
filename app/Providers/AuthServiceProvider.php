<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate; // Uncomment jika perlu Gate::define
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\RequestJudul; // Import Model
use App\Policies\RequestJudulPolicy; // Import Policy

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy', // Format default
        RequestJudul::class => RequestJudulPolicy::class,   // Tambahkan baris ini
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Gate::define(...); // Jika Anda menggunakan Gate juga
    }
}
