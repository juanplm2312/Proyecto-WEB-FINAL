<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGiftsTable extends Migration
{
    public function up()
    {
        Schema::create('gifts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('creator_id')->constrained('users')->onDelete('cascade'); // quien creó el gift
            $table->string('title');
            $table->text('description')->nullable();
            $table->decimal('suggested_price', 8, 2)->nullable();
            $table->string('image_path')->nullable(); // almacenamiento
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('gifts');
    }
}
