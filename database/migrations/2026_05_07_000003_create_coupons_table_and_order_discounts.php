<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('coupons', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->string('type')->default('percent');
            $table->decimal('value', 10, 2);
            $table->decimal('minimum_order', 10, 2)->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->string('coupon_code')->nullable()->after('shipping');
            $table->decimal('discount', 10, 2)->default(0)->after('coupon_code');
        });

        DB::table('coupons')->insert([
            [
                'code' => 'SPHERE10',
                'description' => '10% off marketplace launch coupon',
                'type' => 'percent',
                'value' => 10,
                'minimum_order' => 1000,
                'expires_at' => now()->addMonth(),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'code' => 'FREESHIP',
                'description' => 'Flat Rs. 99 discount for shipping relief',
                'type' => 'fixed',
                'value' => 99,
                'minimum_order' => 500,
                'expires_at' => now()->addMonth(),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['coupon_code', 'discount']);
        });

        Schema::dropIfExists('coupons');
    }
};
