<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Gift;
use App\Models\Exchange;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Crear usuarios con regalos asociados
        User::factory(10)->create()->each(function ($user) {
            Gift::factory(rand(1, 3))->create([
                'creator_id' => $user->id
            ]);
        });

        $users = User::all();
        $gifts = Gift::all();

        // Crear intercambios aleatorios
        foreach (range(1, 15) as $i) {

            $sender = $users->random();

            // evitar que receiver sea el mismo user
            $receiver = $users->where('id', '!=', $sender->id)->random();

            $gift = $gifts->random();

            Exchange::create([
                'sender_id'   => $sender->id,
                'receiver_id' => $receiver->id,
                'gift_id'     => $gift->id,
                'status'      => 'pending',
                'message'     => '¡Hola! Me gustaría enviarte este regalo.'
            ]);
        }

        // Wishlist (tabla pivote)
        foreach ($users as $user) {
            $user->wishlist()->sync(
                $gifts->random(rand(0, 3))->pluck('id')->toArray()
            );
        }
    }
}
