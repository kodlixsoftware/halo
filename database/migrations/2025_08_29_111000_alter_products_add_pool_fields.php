<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (!Schema::hasTable('vendors')) {
            Schema::create('vendors', function (Blueprint $t) {
                $t->id();
                $t->string('name');
                $t->string('slug')->unique();
                $t->json('settings')->nullable();
                $t->timestamps();
            });
        }

        if (Schema::hasTable('users') && !Schema::hasColumn('users','vendor_id')) {
            Schema::table('users', function (Blueprint $t) {
                $t->foreignId('vendor_id')->nullable()->after('id')
                  ->constrained('vendors')->nullOnDelete();
            });
        }

        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $t) {
                if (!Schema::hasColumn('products','source')) {
                    $t->enum('source', ['tecdoc','manual'])->default('tecdoc')->index();
                }
                if (!Schema::hasColumn('products','pool_status')) {
                    $t->enum('pool_status', ['draft','pending','approved'])->default('approved')->index();
                }
                if (!Schema::hasColumn('products','created_by_vendor_id')) {
                    $t->foreignId('created_by_vendor_id')->nullable()
                      ->after('user_id')->constrained('vendors')->nullOnDelete();
                }
                if (!Schema::hasColumn('products','is_pool')) {
                    $t->boolean('is_pool')->default(true)->index();
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('products')) {
            Schema::table('products', function (Blueprint $t) {
                if (Schema::hasColumn('products','created_by_vendor_id')) $t->dropConstrainedForeignId('created_by_vendor_id');
                if (Schema::hasColumn('products','source')) $t->dropColumn('source');
                if (Schema::hasColumn('products','pool_status')) $t->dropColumn('pool_status');
                if (Schema::hasColumn('products','is_pool')) $t->dropColumn('is_pool');
            });
        }

        if (Schema::hasTable('users') && Schema::hasColumn('users','vendor_id')) {
            Schema::table('users', function (Blueprint $t) {
                $t->dropConstrainedForeignId('vendor_id');
            });
        }

        Schema::dropIfExists('vendors');
    }
};
