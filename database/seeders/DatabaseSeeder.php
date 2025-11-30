<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        \App\Models\User::factory(10)->create()->each(function($user){
            \App\Models\Gift::factory(rand(1,3))->create(['creator_id'=>$user->id]);
        });

        $users = \App\Models\User::all();
        $gifts = \App\Models\Gift::all();

        foreach (range(1,15) as $i) {
            $sender = $users->random();
            $receiver = $users->where('id','!=',$sender->id)->random();
            $gift = $gifts->random();
            \App\Models\Exchange::create([
                'sender_id' => $sender->id,
                'receiver_id' => $receiver->id,
                'gift_id' => $gift->id,
                'status' => 'pending',
                'message' => '¡Hola! me gustaría enviarte este regalo.'
            ]);
        }

        foreach ($users as $user) {
            $user->wishlist()->sync(
                $gifts->random(rand(0,3))->pluck('id')->toArray()
            );
        }
    }
}
