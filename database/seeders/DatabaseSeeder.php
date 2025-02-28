<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ResponseFormat;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('admin'),
        ]);

        // Filling the response formats
        ResponseFormat::create([
            "function" => "AccountInquiry",
            "response" => '{"Code":"0","Message":"Operation Successfull","Data":{"AcctInqResponse":{"AcctInqRs":{"AccountDetail":[{"ACCT_SHORT_NAME":"[[ACCT_SHORT_NAME]]","SOL_ID":"[[SOL_ID]]","ACCT_NAME":"[[ACCT_NAME]]","CUST_ID":"[[CUST_ID]]","SCHM_CODE":"[[SCHM_CODE]]","GL_SUB_HEAD_CODE":"[[GL_SUB_HEAD_CODE]]","ACCT_CLS_FLG":"[[ACCT_CLS_FLG]]","ACCT_CRNCY_CODE":"[[ACCT_CRNCY_CODE]]","SCHM_TYPE":"[[SCHM_TYPE]]","ACCT_OPN_DATE":"[[ACCT_OPN_DATE]]","ACCT_CLS_DATE":"[[ACCT_CLS_DATE]]","FREZ_CODE":"[[FREZ_CODE]]","FREZ_REASON_CODE":"[[FREZ_REASON_CODE]]"}],"MisInformation":[{"NRB_DEPOSIT_LOAN_DETAIL":"[[NRB_DEPOSIT_LOAN_DETAIL]]","NRB_DEPOSIT_DETAIL":"[[NRB_DEPOSIT_DETAIL]]"}],"RelatedParty":[{"ACCT_POA_AS_REC_TYPE":"[[ACCT_POA_AS_REC_TYPE]]","ACCT_POA_AS_NAME":"[[ACCT_POA_AS_NAME]]","CUST_ID":"[[CUST_ID]]"}]}}},"DeveloperMessage":null,"Errors":null}'
        ]);
    }
}
