<?php

namespace Cms\Modules\Core\Commands;

use Cms\Modules\Core\Models\Role;
use Illuminate\Console\Command;

class AddRoleCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add:role';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add new role';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $roles = [
            [
                'name' => 'leader-manager',
                'display_name' => 'Leader Manager',
                'description' => 'Leader Manager'
            ],
            [
                'name' => 'leader-shipper',
                'display_name' => 'Leader Shipper',
                'description' => 'Leader Shipper'
            ]
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }

        $this->info('Create role success!');
    }
}
