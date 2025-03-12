<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('RetCustInq_GeneralDetails', function (Blueprint $table) {
            $table->id();
            $table->string('acctNo')->unique();
            $table->string('cust_id')->unique();
            $table->string('cust_title_code', 10);
            $table->string('cust_name');
            $table->string('cust_short_name');
            $table->char('cust_sex', 1);
            $table->char('cust_minor_flg', 1)->default('N');
            $table->date('date_of_birth');
            $table->string('cust_marital_status', 10);
            $table->string('cust_emp_id')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('psprt_num')->nullable();
            $table->date('psprt_issu_date')->nullable();
            $table->string('psprt_det')->nullable();
            $table->date('psprt_exp_date')->nullable();
            $table->char('address_type', 1);
            $table->char('cust_nre_flg', 1)->default('N');
            $table->string('name_screening_id_no');
            $table->string('idtype', 10);
            $table->string('idno');
            $table->date('idissuedate');
            $table->string('issuedistrict');
            $table->string('idregisteredin');
            $table->timestamps();
        });

        Schema::create('RetCustInq_GurdianDetails', function (Blueprint $table) {
            $table->id();
            $table->string('acctNo');
            $table->date('minor_date_of_birth');
            $table->date('minor_attain_major_date');
            $table->char('minor_guard_code', 1);
            $table->string('minor_guard_addr1');
            $table->string('minor_guard_addr2')->nullable();
            $table->string('minor_guard_city_code');
            $table->string('minor_guard_state_code');
            $table->string('minor_guard_cntry_code');
            $table->char('del_flg', 1)->default('N');
            $table->string('minor_guard_name');
            $table->timestamps();

            $table->foreign('acctNo')
                  ->references('acctNo')
                  ->on('RetCustInq_GeneralDetails')
                  ->onDelete('cascade');
        });

        Schema::create('RetCustInq_RetCustAddrInfo', function (Blueprint $table) {
            $table->id();
            $table->string('acctNo');
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
            $table->char('del_flg', 1)->default('N');
            $table->timestamps();

            $table->foreign('acctNo')
                  ->references('acctNo')
                  ->on('RetCustInq_GeneralDetails')
                  ->onDelete('cascade');
        });

        Schema::create('RetCustInq_MisInformation', function (Blueprint $table) {
            $table->id();
            $table->string('acctNo');
            $table->string('cust_occp_code');
            $table->string('cust_othr_bank_code');
            $table->string('cust_grp');
            $table->string('cust_status');
            $table->date('cdd_ecdd_date');
            $table->string('constitution');
            $table->text('cust_free_text')->nullable();
            $table->decimal('annual_turn_over', 15, 2)->nullable();
            $table->string('education_qualification');
            $table->string('religion');
            $table->date('annual_turn_over_as_on')->nullable();
            $table->string('rm_code');
            $table->char('risk_category', 1);
            $table->char('total_no_of_annual_txn', 1);
            $table->timestamps();

            $table->foreign('acctNo')
                  ->references('acctNo')
                  ->on('RetCustInq_GeneralDetails')
                  ->onDelete('cascade');
        });

        Schema::create('RetCustInq_EntityRelationShip', function (Blueprint $table) {
            $table->id();
            $table->string('acctNo');
            $table->string('person_reltn_name');
            $table->string('cust_reltn_code');
            $table->char('del_flg', 1)->default('N');
            $table->string('cust_id');
            $table->timestamps();

            $table->foreign('acctNo')
                  ->references('acctNo')
                  ->on('RetCustInq_GeneralDetails')
                  ->onDelete('cascade');
        });

        Schema::create('RetCustInq_CurrencyInfo', function (Blueprint $table) {
            $table->id();
            $table->string('acctNo');
            $table->string('crncy_code');
            $table->char('del_flg', 1)->default('N');
            $table->timestamps();

            $table->foreign('acctNo')
                  ->references('acctNo')
                  ->on('RetCustInq_GeneralDetails')
                  ->onDelete('cascade');
        });

        Schema::create('RetCustInq_AccountOpened', function (Blueprint $table) {
            $table->id();
            $table->string('accountNo');
            $table->string('acct_name');
            $table->string('cust_id');
            $table->string('acct_no')->unique();
            $table->string('schm_code');
            $table->string('schm_desc');
            $table->string('acct_status');
            $table->string('frez_code');
            $table->string('gl_sub_head_code');
            $table->char('acct_cls_flg', 1)->default('N');
            $table->dateTime('acct_opn_date');
            $table->dateTime('acct_cls_date')->nullable();
            $table->timestamps();

            $table->foreign('accountNo')
                  ->references('acctNo')
                  ->on('RetCustInq_GeneralDetails');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('RetCustInq_AccountOpened');
        Schema::dropIfExists('RetCustInq_CurrencyInfo');
        Schema::dropIfExists('RetCustInq_EntityRelationShip');
        Schema::dropIfExists('RetCustInq_MisInformation');
        Schema::dropIfExists('RetCustInq_RetCustAddrInfo');
        Schema::dropIfExists('RetCustInq_GurdianDetails');
        Schema::dropIfExists('RetCustInq_GeneralDetails');
    }
};
