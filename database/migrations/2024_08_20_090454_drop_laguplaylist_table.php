<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropLaguPlaylistTable extends Migration
{
    public function up()
    {
        Schema::dropIfExists('laguplaylist');
    }

    public function down()
    {
        // Tidak perlu membuat kembali tabel jika hanya untuk menghapus
    }
}
