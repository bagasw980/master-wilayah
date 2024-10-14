<?php

namespace Database\Seeders;

use App\Models\MasterCity;
use App\Models\MasterDistricts;
use App\Models\MasterProvince;
use App\Models\MasterWilayah;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WilayahSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        MasterProvince::truncate();
        MasterCity::truncate();
        MasterDistricts::truncate();
        $provinces = MasterWilayah::whereRaw('LENGTH(kode) = 2')
            ->selectRaw('LEFT(kode, 2) as id, nama as name')
            ->get();
        $cities = MasterWilayah::whereRaw('LENGTH(kode) = 5')
            ->selectRaw('(concat(LEFT(kode, 2), RIGHT(kode, 2))) as id, LEFT(kode, 2) as province_id, nama as name')
            ->get();
            $districts = MasterWilayah::whereRaw('LENGTH(kode) = 8')
            ->selectRaw('CONCAT(LEFT(kode, 2), SUBSTRING(kode, 4, 2)) as city_id, SUBSTRING(kode, 7, 2) as id, CONCAT(SUBSTRING(kode, 4, 2), SUBSTRING(kode, 7, 2)) as combined_id, nama as name')
            ->get();
        // Insert data ke tabel master_provinces
        foreach ($provinces as $data) {
            DB::table('master_provinces')->insert(
                [
                    'id' => $data->id,
                    'name'=>$data->name
                ]
            );
        }
        foreach ($cities as $data) {
            DB::table('master_cities')->insert(
                [
                    'id' => $data->id,
                    'province_id' => $data->province_id,
                    'name'=>$data->name
                ]
            );
        }
        foreach ($districts as $data){
            DB::table('master_districts')->insert(
                [
                    'city_id' => $data->city_id,
                    'name' => $data->name
                ]
            );
        }
    }
}
