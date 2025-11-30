<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('challenges', function (Blueprint $table) {
            // Menambahkan kolom winner_artwork_id yang nullable (boleh kosong)
            // dan merupakan foreign key ke tabel artworks
            $table->foreignId('winner_artwork_id')
                  ->nullable()
                  ->after('end_date') // Letakkan setelah kolom end_date
                  ->constrained('artworks')
                  ->onDelete('set null'); // Jika artwork dihapus, kolom ini jadi null
        });
    }

    public function down()
    {
        Schema::table('challenges', function (Blueprint $table) {
            $table->dropForeign(['winner_artwork_id']);
            $table->dropColumn('winner_artwork_id');
        });
    }
};