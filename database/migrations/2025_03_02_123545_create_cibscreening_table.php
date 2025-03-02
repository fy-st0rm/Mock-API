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
        Schema::create('cibscreening_datas', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->date('dob');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('father_name');
            $table->string('citizenship_number')->unique();
            $table->date('citizenship_issued_date');
            $table->string('citizenship_issued_district');
            $table->string('passport_number')->nullable()->unique();
            $table->date('passport_expiry_date')->nullable();
            $table->string('driving_license_number')->nullable()->unique();
            $table->date('driving_license_issued_date')->nullable();
            $table->string('voter_id_number')->nullable()->unique();
            $table->date('voter_id_issued_date')->nullable();
            $table->string('pan')->nullable()->unique();
            $table->date('pan_issued_date')->nullable();
            $table->string('pan_issued_district')->nullable();
            $table->string('indian_embassy_number')->nullable()->unique();
            $table->date('indian_embassy_reg_date')->nullable();
            $table->string('sector')->nullable();
            $table->string('blacklist_number')->nullable()->unique();
            $table->date('blacklisted_date')->nullable();
            $table->string('blacklist_type')->nullable();
            $table->string('pan_number')->nullable()->unique();
            $table->string('company_reg_number')->nullable()->unique();
            $table->date('company_reg_date')->nullable();
            $table->string('company_reg_auth')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cibscreening_datas');
    }
};
