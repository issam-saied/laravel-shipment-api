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
        Schema::create('shipment_options', function (Blueprint $table) {
            $table->id();

            // Foreign keys
            $table->foreignId('carrier_id')->constrained()->OnDelete('cascade');
            $table->foreignId('package_id')->constrained()->OnDelete('cascade');
            $table->foreignId('region_id')->constrained()->OnDelete('cascade');

            // Business rule fields
            $table->boolean('weekends')->default(false);
            $table->decimal('price', 6, 2)->default(0);

            $table->timestamps();
            $table->unique(
                ['carrier_id', 'package_id', 'region_id', 'weekends'],
                'unique_shipment_options'
            );
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipment_options');
    }
};
