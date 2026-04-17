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
            $table->string('profession')->nullable()->after('email');
            $table->text('bio')->nullable()->after('profession');
            $table->string('phone')->nullable()->after('bio');
            $table->string('gender')->nullable()->after('phone');
            $table->string('address')->nullable()->after('gender');
            $table->date('birth_date')->nullable()->after('address');
            $table->string('profile_image')->nullable()->after('birth_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'profession', 'bio', 'phone', 'gender',
                'address', 'birth_date', 'profile_image'
            ]);
        });
    }
};
