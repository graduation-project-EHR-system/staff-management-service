<?php

use App\Models\Specialization;
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
        Schema::create('doctors', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('national_id');
            $table->string('first_name' , 50);
            $table->string('last_name' , 50);
            $table->string('email' , 100);
            $table->string('phone' , 30);
            $table->foreignUuid('specialization_id')->constrained('specializations');
            $table->boolean('is_active')->default(true);
            $table->string('profile_picture_path')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};
