<?php

namespace Cms\Modules\Core\Commands;

use Illuminate\Console\Command;

class CmsSetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cms:setup {--auth-seed} {--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup CMS';

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
        $options = $this->options();

        // CMS CORE MIGRATIONS MIGRATE
        $this::call('migrate', [
            '--path' => 'cms/Modules/Core/database/migrations',
            '--force' => true,
        ]);

        if ($options['all']) {
            // MODULE MIGRATIONS MIGRATE
            $this::call('migrate', [
                '--force' => true,
            ]);
        }

        if ($options['auth-seed']) {
            // SAMPLE AUTH SEEDER SEED
            $this::call('db:seed', [
                '--class' => 'Cms\Modules\Core\Database\Seeds\SampleAuthSeeder',
                '--force' => true,
            ]);
        }
    }
}
