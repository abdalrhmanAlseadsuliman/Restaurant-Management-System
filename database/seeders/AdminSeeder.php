<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    protected $model = Admin::class;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Admin::factory()->count(3)->create();
    }
}
