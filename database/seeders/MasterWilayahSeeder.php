<?php

namespace Database\Seeders;

use App\Models\MasterCity;
use App\Models\MasterProvince;
use App\Models\MasterWilayah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class MasterWilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MasterWilayah::truncate();
        MasterProvince::truncate();
        MasterCity::truncate();

        $sqlContent = Storage::disk('local')->get('wilayah.sql');

        $sql = explode(';',$sqlContent);
        foreach ($sql as $query) {
            if (!empty(trim($query))) {
                DB::unprepared($query);
            }
        }
    }
}
