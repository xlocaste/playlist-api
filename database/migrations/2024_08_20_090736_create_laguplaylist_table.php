<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLaguplaylistTable extends Migration
{
    public function up()
    {
        Schema::create('laguplaylist', function (Blueprint $table) {
            $table->id();
            $table->foreignId('lagu_id')->constrained('lagu')->onDelete('cascade');
            $table->foreignId('playlist_id')->constrained('playlist')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('laguplaylist');
    }
};
