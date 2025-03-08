<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('CorpCustInq_GeneralDetails', function (Blueprint $table) {
            $table->id();
            $table->string('cust_id')->unique();
            $table->string('cust_title_code');
            $table->string('cust_name');
            $table->string('cust_short_name');
            $table->string('cust_sex');
            $table->string('cust_minor_flg');
            $table->date('date_of_birth');
            $table->string('cust_marital_status');
            $table->string('cust_emp_id')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('psprt_num')->nullable();
            $table->date('psprt_issu_date')->nullable();
            $table->text('psprt_det')->nullable();
            $table->date('psprt_exp_date')->nullable();
            $table->string('address_type');
            $table->string('cust_nre_flg');
            $table->string('name_screening_id_no');
            $table->string('idtype');
            $table->string('idno');
            $table->date('idissuedate');
            $table->string('issuedistrict');
            $table->string('idregisteredin');
            $table->timestamps();
        });

        Schema::create('CorpCustInq_RetCustAddrInfo', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('address_type');
            $table->string('address1')->nullable();
            $table->string('address2')->nullable();
            $table->string('municipality_vdc_name')->nullable();
            $table->string('ward_no')->nullable();
            $table->string('zonee')->nullable();
            $table->string('city_code')->nullable();
            $table->string('district_code')->nullable();
            $table->string('email_id')->nullable();
            $table->string('cntry_code')->nullable();
            $table->string('phone_num1')->nullable();
            $table->string('phone_num2')->nullable();
            $table->string('del_flg')->default('N');
            $table->timestamps();

            $table->foreign('customer_id')
                  ->references('cust_id')
                  ->on('CorpCustInq_GeneralDetails')
                  ->onDelete('cascade');
        });

        Schema::create('CorpCustInq_MisInformation', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('cust_occp_code');
            $table->string('cust_othr_bank_code');
            $table->string('cust_grp');
            $table->string('cust_status');
            $table->date('cdd_ecdd_date');
            $table->string('constitution');
            $table->text('cust_free_text')->nullable();
            $table->string('annual_turn_over');
            $table->string('education_qualification');
            $table->string('religion');
            $table->date('annual_turn_over_as_on');
            $table->string('rm_code');
            $table->string('risk_category');
            $table->string('total_no_of_annual_txn');
            $table->timestamps();

            $table->foreign('customer_id')
                  ->references('cust_id')
                  ->on('CorpCustInq_GeneralDetails')
                  ->onDelete('cascade');
        });

        Schema::create('CorpCustInq_CorpMiscInfoData', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('person_reltn_name');
            $table->string('cust_reltn_code');
            $table->string('del_flg')->default('N');
            $table->string('cust_id')->nullable();
            $table->timestamps();

            $table->foreign('customer_id')
                  ->references('cust_id')
                  ->on('CorpCustInq_GeneralDetails')
                  ->onDelete('cascade');
        });

        Schema::create('CorpCustInq_CurrencyInfo', function (Blueprint $table) {
            $table->id();
            $table->string('customer_id');
            $table->string('crncy_code');
            $table->string('del_flg')->default('N');
            $table->timestamps();

            $table->foreign('customer_id')
                  ->references('cust_id')
                  ->on('CorpCustInq_GeneralDetails')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('CorpCustInq_CurrencyInfo');
        Schema::dropIfExists('CorpCustInq_CorpMiscInfoData');
        Schema::dropIfExists('CorpCustInq_MisInformation');
        Schema::dropIfExists('CorpCustInq_RetCustAddrInfo');
        Schema::dropIfExists('CorpCustInq_GeneralDetails');
    }
};
