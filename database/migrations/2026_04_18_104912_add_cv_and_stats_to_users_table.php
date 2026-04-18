<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('cv')->nullable()->after('profile_image');
            $table->string('experience')->nullable()->after('cv');
            $table->integer('projects_count')->default(0)->after('experience');
            $table->integer('clients_count')->default(0)->after('projects_count');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['cv', 'experience', 'projects_count', 'clients_count']);
        });
    }
};
