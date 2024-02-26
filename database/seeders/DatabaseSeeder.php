<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use App\Models\Permission;
use App\Models\RedeemHistory;
use App\Models\Rewards;
use App\Models\Role;
use App\Models\Voucher;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $adminRole = Role::create(['name' => 'Admin']);
        $employeeRole = Role::create(['name' => 'Employee']);


        $userView = Permission::create(['name' => 'userView', 'description' => 'Allow users to view all users']);
        $userCreate = Permission::create(['name' => 'userCreate', 'description' => 'Allow users to create new users']);
        $userEdit = Permission::create(['name' => 'userEdit', 'description' => 'Allow users to edit existing users']);
        $userDelete = Permission::create(['name' => 'userDelete', 'description' => 'Allow users to delete users']);

        $roleView = Permission::create(['name' => 'roleView', 'description' => 'Allow users to view roles']);
        $roleCreate = Permission::create(['name' => 'roleCreate', 'description' => 'Allow users to create new roles']);
        $roleEdit = Permission::create(['name' => 'roleEdit', 'description' => 'Allow users to edit existing roles']);
        $roleDelete = Permission::create(['name' => 'roleDelete', 'description' => 'Allow users to delete roles']);

        $permissionView = Permission::create(['name' => 'permissionView', 'description' => 'Allow users to view permissions']);
        $permissionCreate = Permission::create(['name' => 'permissionCreate', 'description' => 'Allow users to create new permissions']);
        $permissionEdit = Permission::create(['name' => 'permissionEdit', 'description' => 'Allow users to edit existing permissions']);
        $permissionDelete = Permission::create(['name' => 'permissionDelete', 'description' => 'Allow users to delete permissions']);

        $rewardsView = Permission::create(['name' => 'rewardsView', 'description' => 'Allow users to view all rewards']);
        $rewardsCreate = Permission::create(['name' => 'rewardsCreate', 'description' => 'Allow users to create new rewards']);
        $rewardsEdit = Permission::create(['name' => 'rewardsEdit', 'description' => 'Allow users to edit existing rewards']);
        $rewardsDelete = Permission::create(['name' => 'rewardsDelete', 'description' => 'Allow users to delete rewards']);

        $redeemHistoryView = Permission::create(['name' => 'redeemHistoryView', 'description' => 'Allow users to view all redeemHistorys']);
        $redeemHistoryEdit = Permission::create(['name' => 'redeemHistoryEdit', 'description' => 'Allow users to edit existing redeemHistorys']);
        $redeemHistoryDelete = Permission::create(['name' => 'redeemHistoryDelete', 'description' => 'Allow users to delete redeemHistorys']);

        $voucherView = Permission::create(['name' => 'voucherView', 'description' => 'Allow users to view all voucher']);
        $voucherCreate = Permission::create(['name' => 'voucherCreate', 'description' => 'Allow users to create new vouchers']);
        $voucherEdit = Permission::create(['name' => 'voucherEdit', 'description' => 'Allow users to edit existing vouchers']);
        $voucherDelete = Permission::create(['name' => 'voucherDelete', 'description' => 'Allow users to delete vouchers']);



        $adminRole->givePermissionTo($userView);
        $adminRole->givePermissionTo($userCreate);
        $adminRole->givePermissionTo($userEdit);
        $adminRole->givePermissionTo($userDelete);
        $adminRole->givePermissionTo($roleView);
        $adminRole->givePermissionTo($roleCreate);
        $adminRole->givePermissionTo($roleEdit);
        $adminRole->givePermissionTo($roleDelete);
        $adminRole->givePermissionTo($permissionView);
        $adminRole->givePermissionTo($permissionCreate);
        $adminRole->givePermissionTo($permissionEdit);
        $adminRole->givePermissionTo($permissionDelete);
        $adminRole->givePermissionTo($rewardsView);
        $adminRole->givePermissionTo($rewardsCreate);
        $adminRole->givePermissionTo($rewardsEdit);
        $adminRole->givePermissionTo($rewardsDelete);
        $adminRole->givePermissionTo($redeemHistoryView);
        $adminRole->givePermissionTo($redeemHistoryEdit);
        $adminRole->givePermissionTo($redeemHistoryDelete);
        $adminRole->givePermissionTo($voucherView);
        $adminRole->givePermissionTo($voucherCreate);
        $adminRole->givePermissionTo($voucherEdit);
        $adminRole->givePermissionTo($voucherDelete);

        $employeeRole->givePermissionTo($rewardsView);
        $employeeRole->givePermissionTo($redeemHistoryView);
        $employeeRole->givePermissionTo($voucherView);


        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $user = User::create([
            'name' => 'Stephen Gustilo',
            'email' => 'stephen.gustilo@teamspan.com',
            'password' => bcrypt('admin'),
            'account' => 'Marketing',
            'points' => 999999,
        ]);
        $user->assignRole('Admin');
        $user2 = User::create([
            'name' => 'Employee 1',
            'email' => 'employee1@teamspan.com',
            'password' => bcrypt('guest'),
            'account' => 'Guest',
            'points' => 1500,
        ]);
        $user2->assignRole('Employee');

        $user3 = User::create([
            'name' => 'Employee 2',
            'email' => 'employee2@teamspan.com',
            'password' => bcrypt('guest'),
            'account' => 'Guest',
        ]);
        $user3->assignRole('Employee');

        $user4 = User::create([
            'name' => 'Employee 3',
            'email' => 'employee3@teamspan.com',
            'password' => bcrypt('guest'),
            'account' => 'Guest',
        ]);
        $user4->assignRole('Employee');

        $faker = Faker::create();

        $items = [
            'Teamspan T-Shirt', 'Aqua Flask', 'Coffe Mug', 'Book', 'Voucher', 'Eco Bag', 'Journal'
        ];

        foreach($items as $item){
            $points = $faker->randomElement([500, 1000, 1500, 2000]);
            $quantity = $faker->numberBetween(0, 10);

            Rewards::create([
                'rewards_name' => $item,
                'rewards_points' => $points,
                'rewards_quantity' => $quantity,
            ]);
        }

        $redeemRecord = RedeemHistory::create([
            'redeemed_name' => 'Notebook and Pen',
            'redeemed_points' => 750,
        ]);

        $voucher1 = Voucher::create([
            'voucher_code' => 'TSV0UC43R3000',
            'voucher_points' => 3000,
        ]);

        $voucher2 = Voucher::create([
            'voucher_code' => 'TSV0UC43R2000',
            'voucher_points' => 2000,
        ]);
        
    }
}
