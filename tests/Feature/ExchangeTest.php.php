<?php

public function test_create_exchange_sends_mail_and_db_record()
{
    Mail::fake();
    $sender = User::factory()->create();
    $receiver = User::factory()->create();
    $gift = Gift::factory()->create();

    $this->actingAs($sender);
    $response = $this->post(route('exchanges.store'), [
        'gift_id'=>$gift->id,
        'receiver_id'=>$receiver->id,
        'message'=>'hola'
    ]);

    $response->assertRedirect();
    $this->assertDatabaseHas('exchanges',['sender_id'=>$sender->id,'receiver_id'=>$receiver->id,'gift_id'=>$gift->id]);

    Mail::assertSent(\App\Mail\ExchangeCreated::class);
}
