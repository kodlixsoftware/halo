<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('manual_product_specs')) {
            Schema::create('manual_product_specs', function(Blueprint $t){
                $t->id();
                if (Schema::hasTable('products')) {
                    $t->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                } else {
                    $t->unsignedBigInteger('product_id')->index(); // fallback
                }
                $t->string('vin_masked')->nullable();
                $t->string('chassis_no')->nullable();
                if (Schema::hasTable('makes'))  $t->foreignId('make_id')->nullable()->constrained('makes');
                else                           $t->unsignedBigInteger('make_id')->nullable()->index();
                if (Schema::hasTable('models')) $t->foreignId('model_id')->nullable()->constrained('models');
                else                            $t->unsignedBigInteger('model_id')->nullable()->index();
                $t->string('year_from')->nullable();
                $t->string('year_to')->nullable();
                $t->string('engine_code')->nullable();
                $t->string('fuel')->nullable();
                $t->json('extra')->nullable();
                $t->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('manual_product_specs');
    }
};
