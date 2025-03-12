<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('SignatureInq', function (Blueprint $table) {
            $table->id();
            $table->string('accountNo')->unique();
            $table->text('signArea');
            $table->string('remarks')->nullable();
            $table->string('imageSrlNum')->nullable();
            $table->string('entityCreFlg')->nullable();
            $table->string('solDesc')->nullable();
            $table->string('imageAccessCode')->nullable();
            $table->string('lchgUserId')->nullable();
            $table->timestamp('lchgTime')->nullable();
            $table->timestamp('rcreTime')->nullable();
            $table->string('delFlg')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('SignatureInq');
    }
};
