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
        Schema::create('mediagables', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('media_id');  // İlişkilendirilen medyanın ID'si
            $table->unsignedBigInteger('mediagable_id');  // İlişkilendirilen modelin ID'si
            $table->string('mediagable_type', 191);  // İlişkilendirilen modelin türü
            $table->timestamps();

             // Medyaları ilişkilendirme alanlarını ekler
             $table->index(['mediagable_id', 'mediagable_type']);
               // Media tablosuna referanslar
            $table->foreign('media_id')->references('id')->on('medias')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mediagables');
    }
};
