<?php

use App\Helpers\ChatManager\ChatManager;
use App\Room;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class RoomsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rooms')->insert([
        [
            'name' => 'piwnica',
            'path' => 'piwnica_367vsd3.json',
            'isPrivate' => true,
            'password' => Hash::make('12345678'),
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ],
        [
            'name' => 'melina',
            'path' => 'melina_765gfdgfd76.json',
            'isPrivate' => false,
            'password' => null,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ]
        ]);
        foreach (Room::all() as $room) {
            ChatManager::createRoomFile($room, 1);
        }
    }
}
