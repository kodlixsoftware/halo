<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        // shops ve products zaten var sayıyorum (senin projede var)
        if (!Schema::hasTable('vendor_listings')) {
            Schema::create('vendor_listings', function (Blueprint $t) {
                $t->id();
                $t->foreignId('product_id')->constrained('products')->cascadeOnDelete();
                $t->foreignId('shop_id')->constrained('shops')->cascadeOnDelete(); // satıcı mağazası
                $t->string('sku')->nullable();
                $t->decimal('price', 12, 2)->nullable();
                $t->integer('stock')->default(0);
                $t->boolean('is_active')->default(true)->index();
                $t->timestamps();

                $t->unique(['product_id','shop_id']); // aynı ürünü aynı mağazaya ikinci kez ekleme
            });
        }
    }

    public function down(): void {
        Schema::dropIfExists('vendor_listings');
    }
};
