<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('product_stats')) {
            Schema::create('product_stats', function(Blueprint $t){
                if (Schema::hasTable('products')) {
                    $t->foreignId('product_id')->primary()->constrained('products')->cascadeOnDelete();
                } else {
                    $t->unsignedBigInteger('product_id')->primary();
                }
                $t->unsignedInteger('active_offers_count')->default(0);
                $t->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('product_stats');
    }
};
