
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('courts', function (Blueprint $table) {
            $table->id();

            // Informasi lapangan
            $table->string('name');
            $table->string('venue_name');
            $table->string('city');
            $table->string('province');
            $table->text('address')->nullable();

            // Informasi harga dan fasilitas
            $table->decimal('price_per_hour', 12, 2);
            $table->string('image')->nullable();
            $table->text('description')->nullable();

            // Status lapangan
            $table->enum('status', ['active', 'inactive'])
                  ->default('active');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('courts');
    }
};
