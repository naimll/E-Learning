<?php

namespace Database\Seeders;

use App\Entities\{ Permission, User};
use App\Repositories\Contracts\{ PermissionRepositoryInterface, RoleRepositoryInterface, UserRepositoryInterface};
use Illuminate\Database\Seeder;

class RoleAndPermissionSeeder extends Seeder
{

    /**
     * @var PermissionRepositoryInterface
     */
    private $permissionRepository;
    /**
     * @var RoleRepositoryInterface
     */
    private $roleRepository;
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    public function __construct(PermissionRepositoryInterface $permissionRepository, RoleRepositoryInterface $roleRepository, UserRepositoryInterface $userRepository)
    {
        $this->permissionRepository = $permissionRepository;
        $this->roleRepository = $roleRepository;
        $this->userRepository = $userRepository;
    }

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {

            $this->command->call('migrate:refresh');
            $this->command->warn("Data cleared, starting from blank database.");

        $permissions = Permission::defaultPermissions();

        foreach ($permissions as $perms) {
            $this->permissionRepository->create(['name' => $perms]);
        }

            $input_roles = 'Admin,Teacher,User';
            $roles_array = explode(',', $input_roles);

            foreach($roles_array as $role) {
                $role = $this->roleRepository->create(['name' => trim($role)]);

                if( $role->name == 'Admin' ) {
                    $role->syncPermissions($this->permissionRepository->all());
                    $this->command->info('Admin granted all the permissions');
                } else {
                    $role->syncPermissions($this->permissionRepository->where('name', 'LIKE', 'view_%'));
                }

                $this->createUser($role);
            }

            $this->command->info('Roles ' . $input_roles . ' added successfully');



    }


    private function createUser($role)
    {
        $user = User::factory()->make();
        $user->assignRole($role->name);
        $user->save();

            $this->command->info('Example users');
            $this->command->warn($user->email);
            $this->command->warn($user->username);
            $this->command->warn('Password is "password"');

    }
}
