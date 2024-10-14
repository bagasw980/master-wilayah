<?php

namespace App\Http\Controllers;

use App\Models\MasterCity;
use App\Models\MasterDistricts;
use App\Models\MasterProvince;
use App\Models\MasterWilayah;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class WelcomeController extends Controller
{
    function index()
    {

        $client = new Client();

        $provinces = MasterWilayah::whereRaw('LENGTH(kode) = 2')
            ->selectRaw('LEFT(kode, 2) as id, nama as name')
            ->get();
        $data = MasterWilayah::whereRaw('LENGTH(kode) = 5')
            ->selectRaw('(concat(LEFT(kode, 2), RIGHT(kode, 2))) as id, LEFT(kode, 2) as province_id, nama as name')
            ->take(10)->get();

        $provinces = MasterProvince::all();
        $districts = MasterDistricts::all();

        $listProvince = [];
        foreach ($provinces as $province) {
            $listProvince[] =[
                'id' => $province->id,
                'name' => $province->name
            ];
            $cities =   MasterCity::where('province_id', $province->id)->get();
            $listCity = [];
            foreach ($cities as $city) {
                $listCity[] =[
                        'id' => $city->id,
                        'province_id' => $city->province_id,
                        'name' => $city->name
                ];
                // $city_id = substr($city->id, 2);
                // $city_id = str_replace('0', '', $city_id);

                $districts = MasterDistricts::where('city_id', $city->id)->get();
                $listDistrict = [];
                foreach ($districts as $district) {
                    $listDistrict[] = [
                        'id' => intval($city->id.$district->id),
                        'city_id' => $city->id,
                        'name' => $district->name
                    ];
                }
                // dd($listDistrict);
                $response = $client->post('http://localhost:5050/admin/districts', [
                    'json' => $listDistrict
                ]);
            }
            // dd($listCity);
            // $response = $client->post('http://localhost:5050/admin/cities', [
            //     'json' => $listCity
            // ]);
        }

        // $response = $client->post('http://localhost:5050/admin/provinces', [
        //     'json' => $listProvince
        // ]);




        if ($response->getStatusCode() == 200) {
            $responseData = json_decode($response->getBody(), true);
            // Process the response data
            dd($responseData);
        } else {
            // Handle the error
            dd('Error: ' . $response->getStatusCode());
        }


        dd(json_encode($districts));
    }
}
