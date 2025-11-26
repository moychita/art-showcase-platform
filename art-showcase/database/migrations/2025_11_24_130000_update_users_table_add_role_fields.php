<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('member')->after('email');
            $table->string('avatar')->nullable()->after('role');
            $table->text('bio')->nullable()->after('avatar');
            $table->json('external_links')->nullable()->after('bio');
            $table->string('status')->default('active')->after('external_links');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'avatar', 'bio', 'external_links', 'status']);
        });
    }
};

