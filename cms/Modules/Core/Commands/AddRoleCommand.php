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
    protected $signature = 'cms:role {--name=} {--display_name=} {--description=}';

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
        $name = $this->option('name');
        $display_name = $this->option('display_name');
        $description = $this->option('description');
        if (empty($name) || empty($display_name) || empty($description)) {
            $this->error('All options must be provided');
        }

        $newRole = Role::create([
            'name' => $name,
            'display_name' => $display_name,
            'description' => $description
        ]);

        $this->info('Create role '. $name . ' success!');
    }
}
