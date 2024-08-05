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
            $table->string('username')->after('email_verified_at')->nullable();
            $table->string('photo')->nullable()->after('password');
            $table->string('about')->nullable()->after('photo');
            $table->longText('links')->nullable()->after('about');
            $table->string('occupation')->nullable()->after('links');
            $table->unsignedBigInteger('language')->after('occupation');
            $table->foreign('language')->references('id')->on('languages')
                ->onDelete('cascade');
            $table->string('darkmode')->default(0)->after('language');
            $table->enum('active', [1, 0])->default(1)->after('darkmode');
            $table->timestamp('banned_at')->nullable()->after('active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('username');
            $table->dropColumn('photo');
            $table->dropColumn('about');
            $table->dropColumn('links');
            $table->dropColumn('occupation');
            $table->dropForeign(['language']);
            $table->dropColumn('language');
            $table->dropColumn('darkmode');
            $table->dropColumn('active');
            $table->dropColumn('banned_at');

        });
    }
};
