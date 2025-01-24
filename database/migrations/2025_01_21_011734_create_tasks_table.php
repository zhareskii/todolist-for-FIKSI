<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('tasks', function (Blueprint $table) {
        $table->id();
        $table->foreignId('id')->constrained()->onDelete('cascade'); // Relasi ke tabel users
        $table->string('title');
        $table->text('description')->nullable();
        $table->date('due_date');
        $table->boolean('status')->default(false); // Checkbox untuk status selesai
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
