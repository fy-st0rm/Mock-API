<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('AccountInquiry_AccountDetail', function (Blueprint $table) {
            $table->id();
            $table->string('acctNo')->unique();
            $table->string('acct_short_name');
            $table->string('sol_id');
            $table->string('acct_name');
            $table->string('cust_id')->unique();
            $table->string('schm_code');
            $table->string('gl_sub_head_code');
            $table->char('acct_cls_flg')->default('N');
            $table->string('acct_crncy_code');
            $table->string('schm_type');
            $table->dateTime('acct_opn_date');
            $table->dateTime('acct_cls_date')->nullable();
            $table->string('frez_code')->nullable();
            $table->string('frez_reason_code')->nullable();
            $table->timestamps();
        });

        Schema::create('AccountInquiry_MisInformation', function (Blueprint $table) {
            $table->id();
            $table->string('acctNo');
            $table->string('nrb_deposit_loan_detail');
            $table->string('nrb_deposit_detail');
            $table->timestamps();

            $table->foreign('acctNo')
                  ->references('acctNo')
                  ->on('AccountInquiry_AccountDetail')
                  ->onDelete('cascade');
        });

        Schema::create('AccountInquiry_RelatedParty', function (Blueprint $table) {
            $table->id();
            $table->string('acctNo');
            $table->string('acct_poa_as_rec_type');
            $table->string('acct_poa_as_name');
            $table->string('cust_id');
            $table->timestamps();

            $table->foreign('acctNo')
                  ->references('acctNo')
                  ->on('AccountInquiry_AccountDetail')
                  ->onDelete('cascade');
            $table->foreign('cust_id')
                  ->references('cust_id')
                  ->on('AccountInquiry_AccountDetail')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('AccountInquiry_RelatedParty');
        Schema::dropIfExists('AccountInquiry_MisInformation');
        Schema::dropIfExists('AccountInquiry_AccountDetail');
    }
};
