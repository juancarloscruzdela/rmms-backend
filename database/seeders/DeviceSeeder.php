<?php

namespace Database\Seeders;

use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('devices')->delete();
        $data = [
            [
                'ip' => 'Device 1',
                'archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'ip' => 'Device 2',
                'archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ],
            [
                'ip' => 'Device 3',
                'archived' => false,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]
        ];
        Device::insert($data);

        // Testing Dummy Devices
        Device::factory(100)->create();
    }
}
