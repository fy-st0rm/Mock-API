<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Http\JsonResponse;

class Responses
{
    public static function AccountInquiryResponse(
        Collection $accountDetail,
        Collection $misInformation,
        Collection $relatedParty
    ): JsonResponse
    {
        $response = [
            "Code" => "0",
            "Message" => "Operation Successfull",
            "Data" => [
                "AcctInqResponse" => [
                    "AcctInqRs" => [
                        "AccountDetail" => $accountDetail->map(function ($result) {
                            return [
                                "ACCT_SHORT_NAME" => $result->acct_short_name,
                                "SOL_ID" => $result->sol_id,
                                "ACCT_NAME" => $result->acct_name,
                                "CUST_ID" => $result->cust_id,
                                "SCHM_CODE" => $result->schm_code,
                                "GL_SUB_HEAD_CODE" => $result->gl_sub_head_code,
                                "ACCT_CLS_FLG" => $result->acct_cls_flg,
                                "ACCT_CRNCY_CODE" => $result->acct_crncy_code,
                                "SCHM_TYPE" => $result->schm_type,
                                "ACCT_OPN_DATE" => $result->acct_opn_date,
                                "ACCT_CLS_DATE" => $result->acct_cls_date,
                                "FREZ_CODE" => $result->frez_code,
                                "FREZ_REASON_CODE" => $result->frez_reason_code,
                            ];
                        }),
                        "MisInformation" => $misInformation->map(function ($result) {
                            return [
                                "NRB_DEPOSIT_LOAN_DETAIL" => $result->nrb_deposit_loan_detail,
                                "NRB_DEPOSIT_DETAIL" => $result->nrb_deposit_detail,
                            ];
                        }),
                        "RelatedParty" => $relatedParty->map(function ($result) {
                            return [
                                "ACCT_POA_AS_REC_TYPE" => $result->acct_poa_as_rec_type,
                                "ACCT_POA_AS_NAME" => $result->acct_poa_as_name,
                                "CUST_ID" => $result->cust_id,
                            ];
                        })
                    ]
                ]
            ],
            "DeveloperMessage" => null,
            "Errors" => null
        ];
        return response()->json($response);
    }

    public static function CibScreeningResponse(Collection $queryResult): JsonResponse
    {
        $response = [
            "Code" => "0",
            "Message" => "Success",
            "Data" => [
                "QueryResult" => $queryResult->flatMap(function ($result) {
                    return collect(range(1, $result->dups))->map(function () use ($result) {
                        return [
                            "Name" => $result->name,
                            "DOB" => $result->dob,
                            "Gender" => $result->gender,
                            "FatherName" => $result->father_name,
                            "CitizenshipNumber" => $result->citizenship_number,
                            "CitizenshipIssuedDate" => $result->citizenship_issued_date,
                            "CitizenshipIssuedDistrict" => $result->citizenship_issued_district,
                            "PassportNumber" => $result->passport_number,
                            "PassportExpiryDate" => $result->passport_expiry_date,
                            "DrivingLicenseNumber" => $result->driving_license_number,
                            "DrivingLicenseIssuedDate" => $result->driving_license_issued_date,
                            "VoterIdNumber" => $result->voter_id_number,
                            "VoterIdIssuedDate" => $result->voter_id_issued_date,
                            "PAN" => $result->pan,
                            "PANIssuedDate" => $result->pan_issued_date,
                            "PANIssuedDistrict" => $result->pan_issued_district,
                            "IndianEmbassyNumber" => $result->indian_embassy_number,
                            "IndianEmbassyRegDate" => $result->indian_embassy_reg_date,
                            "Sector" => $result->sector,
                            "BlacklistNumber" => $result->blacklist_number,
                            "BlacklistedDate" => $result->blacklisted_date,
                            "BlacklistType" => $result->blacklist_type,
                            "PanNumber" => $result->pan_number,
                            "CompanyRegNumber" => $result->company_reg_number,
                            "CompanyRegDate" => $result->company_reg_date,
                            "CompanyRegAuth" => $result->company_reg_auth
                        ];
                    });
                })->toArray(),
            ],
            "DeveloperMessage" => null,
            "Errors" => null
        ];

        return response()->json($response);
    }

    public static function ComplienceScreeningAPIResponse(Collection $queryResult): JsonResponse
    {
        $response = [
            "Code" => "0",
            "Message" => "Success",
            "Data" => [
                "QueryResult" => $queryResult->map(function($result) {
                    return [
                        "sno" => $result->sno,
                        "ofac_key" => $result->ofac_key,
                        "ent_num" => $result->ent_num,
                        "name" => $result->name,
                        "typeV" => $result->typeV,
                        "address" => $result->address,
                        "city" => $result->city,
                        "state" => $result->state,
                        "zip" => $result->zip,
                        "country" => $result->country,
                        "remarks" => $result->remarks,
                        "type_sort" => $result->type_sort,
                        "from_file" => $result->from_file,
                        "source" => $result->source,
                        "manual_ofac_id" => $result->manual_ofac_id,
                        "intEnt" => $result->intEnt,
                        "name2" => $result->name2,
                        "DOB" => $result->DOB,
                        "Metaphone" => $result->Metaphone,
                        "Alternative_Script" => $result->Alternative_Script,
                        "SoundexAplha" => $result->SoundexAplha,
                        "DOB_YEAR" => $result->DOB_YEAR,
                        "DOB_MONTH" => $result->DOB_MONTH,
                        "Other_Name" => $result->Other_Name,
                        "insertion_time" => $result->insertion_time,
                        "modification_time" => $result->modification_time,
                        "ACCUITY_UPDATE" => $result->ACCUITY_UPDATE,
                        "is_deleted" => $result->is_deleted
                    ];
                }),
            ]
        ];

        return response()->json($response);
    }

    public static function CorpCustInqResponse(
        Collection $generalDetails,
        Collection $reqCustAddrInfo,
        Collection $misInformation,
        Collection $corpMiscInfoData,
        Collection $currencyInfo
    ): JsonResponse
    {
        $response = [
            "Code" => "0",
            "Message" => "Operation Successful",
            "Data" => [
                "corpCustomerInqResponse" => [
                    "corpCustomerInqRs" => [
                        "GeneralDetails" => $generalDetails->map(function($detail) {
                            return [
                                "CUST_ID" => $detail->cust_id,
                                "CUST_TITLE_CODE" => $detail->cust_title_code,
                                "CUST_NAME" => $detail->cust_name,
                                "CUST_SHORT_NAME" => $detail->cust_short_name,
                                "CUST_SEX" => $detail->cust_sex,
                                "CUST_MINOR_FLG" => $detail->cust_minor_flg,
                                "DATE_OF_BIRTH" => $detail->date_of_birth,
                                "CUST_MARITAL_STATUS" => $detail->cust_marital_status,
                                "CUST_EMP_ID" => $detail->cust_emp_id,
                                "MOBILE_NO" => $detail->mobile_no,
                                "PSPRT_NUM" => $detail->psprt_num,
                                "PSPRT_ISSU_DATE" => $detail->psprt_issu_date,
                                "PSPRT_DET" => $detail->psprt_det,
                                "PSPRT_EXP_DATE" => $detail->psprt_exp_date,
                                "ADDRESS_TYPE" => $detail->address_type,
                                "CUST_NRE_FLG" => $detail->cust_nre_flg,
                                "NAME_SCREENING_ID_NO" => $detail->name_screening_id_no,
                                "IDTYPE" => $detail->idtype,
                                "IDNO" => $detail->idno,
                                "IDISSUEDATE" => $detail->idissuedate,
                                "ISSUEDISTRICT" => $detail->issuedistrict,
                                "IDREGISTEREDIN" => $detail->idregisteredin,
                            ];
                        }),
                        "RetCustAddrInfo" => $reqCustAddrInfo->map(function($address) {
                            return [
                                "ADDRESS_TYPE" => $address->address_type,
                                "ADDRESS1" => $address->address1,
                                "ADDRESS2" => $address->address2,
                                "MUNICIPALITY_VDC_NAME" => $address->municipality_vdc_name,
                                "WARD_NO" => $address->ward_no,
                                "ZONEE" => $address->zonee,
                                "CITY_CODE" => $address->city_code,
                                "DISTRICT_CODE" => $address->district_code,
                                "EMAIL_ID" => $address->email_id,
                                "CNTRY_CODE" => $address->cntry_code,
                                "PHONE_NUM1" => $address->phone_num1,
                                "PHONE_NUM2" => $address->phone_num2,
                                "DEL_FLG" => $address->del_flg,
                            ];
                        }),
                        "MisInformation" => $misInformation->map(function($info) {
                            return [
                                "CUST_OCCP_CODE" => $info->cust_occp_code,
                                "CUST_OTHR_BANK_CODE" => $info->cust_othr_bank_code,
                                "CUST_GRP" => $info->cust_grp,
                                "CUST_STATUS" => $info->cust_status,
                                "CDD_ECDD_DATE" => $info->cdd_ecdd_date,
                                "CONSTITUTION" => $info->constitution,
                                "CUST_FREE_TEXT" => $info->cust_free_text,
                                "ANNUAL_TURN_OVER" => $info->annual_turn_over,
                                "EDUCATION_QUALIFACTION" => $info->education_qualification,
                                "REGILION" => $info->religion,
                                "ANNUAL_TURN_OVER_AS_ON" => $info->annual_turn_over_as_on,
                                "RM_CODE" => $info->rm_code,
                                "RISK_CATEGORY" => $info->risk_category,
                                "TOTAL_NO_OF_ANNUAL_TXN" => $info->total_no_of_annual_txn,
                            ];
                        }),
                        "corpMiscInfoData" => $corpMiscInfoData->map(function($miscData) {
                            return [
                                "PERSON_RELTN_NAME" => $miscData->person_reltn_name,
                                "CUST_RELTN_CODE" => $miscData->cust_reltn_code,
                                "DEL_FLG" => $miscData->del_flg,
                            ];
                        }),
                        "CurrencyInfo" => $currencyInfo->map(function($currency) {
                            return [
                                "crncy_code" => $currency->crncy_code,
                                "del_flg" => $currency->del_flg,
                            ];
                        }),
                    ]
                ]
            ],
            "DeveloperMessage" => null,
            "Errors" => null
        ];

        return response()->json($response);
    }

    public static function RetCustInqResponse(
        Collection $generalDetails,
        Collection $gurdianDetails,
        Collection $addressInfo,
        Collection $misInformation,
        Collection $entityRelationship,
        Collection $currencyInfo,
        Collection $accountOpened
    ): JsonResponse
    {
        $response = [
            "Code" => "0",
            "Message" => "Operation Successfull",
            "Data" => [
                "RetCustInqResponse" => [
                    "RetCustInqRs" => [
                        "GeneralDetails" => $generalDetails->map(function ($detail) {
                            return [
                                "CUST_ID" => $detail->cust_id,
                                "CUST_TITLE_CODE" => $detail->cust_title_code,
                                "CUST_NAME" => $detail->cust_name,
                                "CUST_SHORT_NAME" => $detail->cust_short_name,
                                "CUST_SEX" => $detail->cust_sex,
                                "CUST_MINOR_FLG" => $detail->cust_minor_flg,
                                "DATE_OF_BIRTH" => $detail->date_of_birth,
                                "CUST_MARITAL_STATUS" => $detail->cust_marital_status,
                                "CUST_EMP_ID" => $detail->cust_emp_id,
                                "MOBILE_NO" => $detail->mobile_no,
                                "PSPRT_NUM" => $detail->psprt_num,
                                "PSPRT_ISSU_DATE" => $detail->psprt_issu_date,
                                "PSPRT_DET" => $detail->psprt_det,
                                "PSPRT_EXP_DATE" => $detail->psprt_exp_date,
                                "ADDRESS_TYPE" => $detail->address_type,
                                "CUST_NRE_FLG" => $detail->cust_nre_flg,
                                "NAME_SCREENING_ID_NO" => $detail->name_screening_id_no,
                                "IDTYPE" => $detail->idtype,
                                "IDNO" => $detail->idno,
                                "IDISSUEDATE" => $detail->idissuedate,
                                "ISSUEDISTRICT" => $detail->issuedistrict,
                                "IDREGISTEREDIN" => $detail->idregisteredin,
                            ];
                        }),
                        "GurdianDetails" => $gurdianDetails->map(function ($details) {
                            return [
                                "MINOR_DATE_OF_BIRTH" => $details->minor_date_of_birth,
                                "MINOR_ATTAIN_MAJOR_DATE" => $details->minor_attain_major_date,
                                "MINOR_GUARD_CODE" => $details->minor_guard_code,
                                "MINOR_GUARD_ADDR1" => $details->minor_guard_addr1,
                                "MINOR_GUARD_ADDR2" => $details->minor_guard_addr2,
                                "MINOR_GUARD_CITY_CODE" => $details->minor_guard_city_code,
                                "MINOR_GUARD_STATE_CODE" => $details->minor_guard_state_code,
                                "MINOR_GUARD_CNTRY_CODE" => $details->minor_guard_cntry_code,
                                "DEL_FLG" => $details->del_flg,
                                "MINOR_GUARD_NAME" => $details->minor_guard_name
                            ];
                        }),
                        "RetCustAddrInfo" => $addressInfo->map(function ($detail) {
                            return [
                                "ADDRESS_TYPE" => $detail->address_type,
                                "ADDRESS1" => $detail->address1,
                                "ADDRESS2" => $detail->address2,
                                "MUNICIPALITY_VDC_NAME" => $detail->municipality_vdc_name,
                                "WARD_NO" => $detail->ward_no,
                                "ZONEE" => $detail->zonee,
                                "CITY_CODE" => $detail->city_code,
                                "DISTRICT_CODE" => $detail->district_code,
                                "EMAIL_ID" => $detail->email_id,
                                "CNTRY_CODE" => $detail->cntry_code,
                                "PHONE_NUM1" => $detail->phone_num1,
                                "PHONE_NUM2" => $detail->phone_num2,
                                "DEL_FLG" => $detail->del_flg,
                            ];
                        }),
                        "MisInformation" => $misInformation->map(function ($detail) {
                            return [
                                "CUST_OCCP_CODE" => $detail->cust_occp_code,
                                "CUST_OTHR_BANK_CODE" => $detail->cust_othr_bank_code,
                                "CUST_GRP" => $detail->cust_grp,
                                "CUST_STATUS" => $detail->cust_status,
                                "CDD_ECDD_DATE" => $detail->cdd_ecdd_date,
                                "CONSTITUTION" => $detail->constitution,
                                "CUST_FREE_TEXT" => $detail->cust_free_text,
                                "ANNUAL_TURN_OVER" => $detail->annual_turn_over,
                                "EDUCATION_QUALIFACTION" => $detail->education_qualification,
                                "REGILION" => $detail->religion,
                                "ANNUAL_TURN_OVER_AS_ON" => $detail->annual_turn_over_as_on,
                                "RM_CODE" => $detail->rm_code,
                                "RISK_CATEGORY" => $detail->risk_category,
                                "TOTAL_NO_OF_ANNUAL_TXN" => $detail->total_no_of_annual_txn,
                            ];
                        }),
                        "EntityRelationShip" => $entityRelationship->map(function ($detail) {
                            return [
                                "PERSON_RELTN_NAME" => $detail->person_reltn_name,
                                "CUST_RELTN_CODE" => $detail->cust_reltn_code,
                                "DEL_FLG" => $detail->del_flg,
                                "CUST_ID" => $detail->cust_id,
                            ];
                        }),
                        "CurrencyInfo" => $currencyInfo->map(function ($detail) {
                            return [
                                "crncy_code" => $detail->crncy_code,
                                "del_flg" => $detail->del_flg,
                            ];
                        }),
                        "AccountOpened" => $accountOpened->map(function ($detail) {
                            return [
                                "ACCT_NAME" => $detail->acct_name,
                                "CUST_ID" => $detail->cust_id,
                                "ACCT_NO" => $detail->acct_no,
                                "SCHM_CODE" => $detail->schm_code,
                                "SCHM_DESC" => $detail->schm_desc,
                                "ACCT_STATUS" => $detail->acct_status,
                                "FREZ_CODE" => $detail->frez_code,
                                "GL_SUB_HEAD_CODE" => $detail->gl_sub_head_code,
                                "ACCT_CLS_FLG" => $detail->acct_cls_flg,
                                "ACCT_OPN_DATE" => $detail->acct_opn_date,
                                "ACCT_CLS_DATE" => $detail->acct_cls_date,
                            ];
                        }),
                    ]
                ]
            ],
            "DeveloperMessage" => null,
            "Errors" => null
        ];

        return response()->json($response);
    }
}
