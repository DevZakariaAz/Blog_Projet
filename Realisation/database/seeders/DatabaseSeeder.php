<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);
        $this->runModuleSeeders();
    }

    protected function runModuleSeeders(): void
    {
        $modulesPath = base_path('modules');
        $modules = File::directories($modulesPath);

        foreach ($modules as $module) {
            if (basename($module) === 'Core') {
                continue;
            }

            $seederFile = $module . '/Database/Seeders/' . Str::studly(basename($module)) . 'Seeder.php';

            if (File::exists($seederFile)) {
                $seederClass = 'Modules\\' . Str::studly(basename($module)) . '\\Database\\Seeders\\' . Str::studly(basename($module)) . 'Seeder';
                $this->call($seederClass);
            }
        }
    }
}
