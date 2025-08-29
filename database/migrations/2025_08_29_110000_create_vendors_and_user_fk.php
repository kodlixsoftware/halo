<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('vendors')) {
            Schema::create('vendors', function (Blueprint $t) {
                $t->id();
                $t->string('name');
                $t->string('slug')->unique();
                $t->json('settings')->nullable();
                $t->timestamps();
            });
        }

        if (Schema::hasTable('users') && !Schema::hasColumn('users', 'vendor_id')) {
            Schema::table('users', function (Blueprint $t) {
                $t->foreignId('vendor_id')->nullable()->after('id')
                  ->constrained('vendors')->nullOnDelete();
            });
        }
    }

    public function down(): void {
        if (Schema::hasTable('users') && Schema::hasColumn('users','vendor_id')) {
            Schema::table('users', function (Blueprint $t) {
                $t->dropConstrainedForeignId('vendor_id');
            });
        }
        if (Schema::hasTable('vendors')) {
            Schema::dropIfExists('vendors');
        }
    }
};
