<?php

namespace App\Providers;

use App\Tag;
use App\Item;
use App\Role;
use App\User;
use App\Empleado;
use App\Category;
use App\Puerta;
use App\Contrato;
use App\Organizacion;
use App\Policies\TagPolicy;
use App\Policies\ItemPolicy;
use App\Policies\RolePolicy;
use App\Policies\UserPolicy;
use App\Policies\CategoryPolicy;
use App\Policies\EmpleadoPolicy;
use App\Policies\PuertaPolicy;
use App\Policies\ContratoPolicy;
use App\Policies\OrganizationPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
        Category::class => CategoryPolicy::class,
        Item::class => ItemPolicy::class,
        Role::class => RolePolicy::class,
        Tag::class => TagPolicy::class,
        Empleado::class => EmpleadoPolicy::class,
        Puerta::class => PuertaPolicy::class,
        Contrato::class => ContratoPolicy::class,
        Organization::class => OrganizationPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('manage-items', 'App\Policies\UserPolicy@manageItems');
        Gate::define('manage-users', 'App\Policies\UserPolicy@manageUsers');
        Gate::define('manage-empleados', 'App\Policies\EmpleadoPolicy@manageEmpleados');
        Gate::define('manage-puertas', 'App\Policies\PuertaPolicy@managePuertas');
        Gate::define('manage-contratos', 'App\Policies\ContratoPolicy@manageContratos');
        Gate::define('manage-organizations', 'App\Policies\OrganizationPolicy@manageOrganizations');
     
      
    }
}
