<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveLastUserAtFromPersonalAccessTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Pastikan kolom `last_user_at` ada sebelum mencoba menghapusnya
            if (Schema::hasColumn('personal_access_tokens', 'last_user_at')) {
                $table->dropColumn('last_user_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('personal_access_tokens', function (Blueprint $table) {
            // Anda dapat menambahkan kode untuk menambahkan kembali kolom jika perlu
            $table->timestamp('last_user_at')->nullable();
        });
    }
}
