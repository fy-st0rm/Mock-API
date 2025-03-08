<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ComplienceScreeningAPI', function (Blueprint $table) {
            $table->id();
            $table->string('sno')->nullable();
            $table->string('ofac_key')->nullable();
            $table->string('ent_num')->nullable();
            $table->string('name')->nullable();
            $table->string('typeV')->nullable();
            $table->string('address')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip')->nullable();
            $table->string('country')->nullable();
            $table->text('remarks')->nullable();
            $table->string('type_sort')->nullable();
            $table->string('from_file')->nullable();
            $table->string('source')->nullable();
            $table->string('manual_ofac_id')->nullable();
            $table->string('intEnt')->nullable();
            $table->string('name2')->nullable();
            $table->date('DOB')->nullable();
            $table->string('Metaphone')->nullable();
            $table->string('Alternative_Script')->nullable();
            $table->string('SoundexAplha')->nullable();
            $table->string('DOB_YEAR')->nullable();
            $table->string('DOB_MONTH')->nullable();
            $table->string('Other_Name')->nullable();
            $table->timestamp('insertion_time')->nullable();
            $table->timestamp('modification_time')->nullable();
            $table->timestamp('ACCUITY_UPDATE')->nullable();
            $table->boolean('is_deleted')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ComplienceScreeningAPI');
    }
};
