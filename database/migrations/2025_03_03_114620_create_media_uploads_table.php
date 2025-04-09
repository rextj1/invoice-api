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
        Schema::create('media_uploads', function (Blueprint $table) { 
            $table->id();
            $table->string('original_name');
            $table->string('stored_path')->unique(); // Unique file path
            $table->string('hash')->unique()->index(); // Unique hash to prevent duplicate uploads
            $table->unsignedInteger('size');
            // $table->unsignedBigInteger('size'); // Supports files larger than 4GB
            $table->timestamps();
    
            // ✅ Add index for better performance on duplicate checks
            // $table->index('hash');
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('media_uploads');
    }
};
