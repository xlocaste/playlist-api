<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropPlaylistTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('playlist');
    }

    public function down()
    {
        Schema::create('playlist', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->timestamps();
        });
    }
};
