<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Create the initial roles and permissions.
     *
     * @return void
     */
    public function run()
    {
        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permissions
        $permissions = [
            'register_role', 'edit_role', 'delete_role', 'register_user', 
            'edit_user', 'delete_user', 'register_product', 'edit_product', 
            'delete_product', 'show_wallet_price_product', 'register_wallet_price_product', 
            'edit_wallet_price_product', 'delete_wallet_price_product', 'register_clientes', 
            'edit_clientes', 'delete_clientes', 'valid_payments', 'reports_caja', 
            'record_contract_process', 'egreso', 'ingreso', 'close_caja', 
            'register_proforma', 'edit_proforma', 'delete_proforma', 'cronograma', 
            'comisiones', 'register_compra', 'edit_compra', 'delete_compra', 
            'register_transporte', 'edit_transporte', 'delete_transporte', 'despacho', 
            'movimientos', 'kardex', 'list_product'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['guard_name' => 'api', 'name' => $permission]);
        }

        // Create roles and assign existing permissions
        $role3 = Role::create(['guard_name' => 'api', 'name' => 'Super-Admin']);

        // Assign all permissions to Super-Admin role
        $role3->givePermissionTo(Permission::all()); // This will assign all created permissions to Super-Admin

        // Create demo Super Admin user
        $user = \App\Models\User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'super_admin_crm@gmail.com',
            'password' => bcrypt("12345678"),
        ]);
        $user->assignRole($role3); // Assign Super-Admin role to user
    }
}
