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
            $table->rename('name', 'first_name');
            $table->string('last_name')->nullable()->after('first_name');
            $table->tinyInteger('usertype')->default(0)->after('password')->index('usertype');
            $table->tinyInteger('status')->default(User::getStatusActive())->after('usertype')->index('status');
            $table->unsignedBigInteger('created_by')->default(0)->after('created_at');
            $table->unsignedBigInteger('updated_by')->default(0)->after('updated_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->rename('first_name', 'name');
            $table->dropColumn(['last_name', 'usertype', 'status', 'created_by', 'updated_by']);
        });
    }
};
