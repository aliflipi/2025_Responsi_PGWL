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
         Schema::table('points_tables', function (Blueprint $table) {
            $table->string('tipe')->nullable()->after('description'); // sesuaikan posisi jika perlu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('points_tables', function (Blueprint $table) {
            $table->dropColumn('tipe');
        });
    }
};
