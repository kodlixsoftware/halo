<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('manual_fitments')) {
            Schema::create('manual_fitments', function(Blueprint $t){
                $t->id();
                if (Schema::hasTable('products')) {
                    $t->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                } else {
                    $t->unsignedBigInteger('product_id')->index();
                }
                if (Schema::hasTable('vehicles')) {
                    $t->foreignId('vehicle_id')->nullable()->constrained('vehicles');
                } else {
                    $t->unsignedBigInteger('vehicle_id')->nullable()->index();
                }
                $t->string('fitment_text')->nullable();   // "VW Golf 7 2013-2020 1.6TDI"
                $t->json('restrictions')->nullable();     // axle / body / transmission vs.
                $t->timestamps();
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('manual_fitments');
    }
};
