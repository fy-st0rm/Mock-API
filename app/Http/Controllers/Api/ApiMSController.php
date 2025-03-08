<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExecuteRequest;
use App\Http\Formatter;
use App\Models\ResponseFormat;
use App\Models\CibScreeningData;
use App\Models\ComplienceScreeningAPIData;
use App\Responses;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;


class ApiMSController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/apims/execute",
     *     summary="Executes the api",
     *     tags={"APIMS"},
     *     security={{ "bearer": {} }},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"function"},
     *             @OA\Property(
     *                 property="function",
     *                 type="string",
     *                 example="Name of function to execute",
     *             ),
     *             @OA\Property(
     *                 property="data",
     *                 type="object",
     *                 example={"key": "value"},
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Unauthenticated",
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation failed",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="status",
     *                 type="string",
     *                 example="error",
     *             ),
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Validation failed.",
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={"function": "The function name must be a string"},
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Bad Request",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="Invalid function name",
     *             ),
     *         ),
     *     ),
     * )
     */
    public function execute(ExecuteRequest $request)
    {
        $function = $request->input("function");
        $data = $request->input("data");
        $response_type = $request->input("response_type");

        if (!method_exists($this, $function)) {
            return response()->json(["message" => "Invalid function name"], 500);
        }

        $responseFormat = ResponseFormat::where("function", $function)->first();
        if (!$responseFormat) {
            return response()->json(["message" => "Response format for $function not found."], 500);
        }

        return $this->$function($data, $responseFormat->response);
    }

    function AccountInquiry(array $data, string $responseFormat): JsonResponse
    {
        $acctNo = $data["acctNo"];

        $record = DB::table("AccountInquiry_AccountDetail")
            ->where("acctNo", $acctNo)
            ->first();

        // If record doesnt exists create a fake one
        if (!$record) {
            $custId = fake()->unique()->numerify('000000#####');
            DB::table('AccountInquiry_AccountDetail')->insert([
                'acctNo' => $acctNo,
                'acct_short_name' => fake()->word(),
                'sol_id' => fake()->numerify('####'),
                'acct_name' => fake()->name(),
                'cust_id' => $custId,
                'schm_code' => fake()->word(),
                'gl_sub_head_code' => fake()->word(),
                'acct_cls_flg' => fake()->randomElement(['Y', 'N']),
                'acct_crncy_code' => fake()->currencyCode(),
                'schm_type' => fake()->word(),
                'acct_opn_date' => fake()->dateTimeThisDecade(),
                'acct_cls_date' => fake()->dateTimeThisDecade(),
                'frez_code' => fake()->word(),
                'frez_reason_code' => fake()->word(),
            ]);

            DB::table('AccountInquiry_MisInformation')->insert([
                'acctNo' => $acctNo,
                'nrb_deposit_loan_detail' => fake()->word(),
                'nrb_deposit_detail' => fake()->word(),
            ]);

            DB::table('AccountInquiry_RelatedParty')->insert([
                'acctNo' => $acctNo,
                'acct_poa_as_rec_type' => fake()->randomElement(['M', 'F', 'O', 'J']),
                'acct_poa_as_name' => fake()->name(),
                'cust_id' => $custId,
            ]);
        }

        // Querying the data
        $accountDetail = DB::table("AccountInquiry_AccountDetail")
            ->where("acctNo", $acctNo)
            ->get();

        $misInformation = DB::table("AccountInquiry_MisInformation")
            ->where("acctNo", $acctNo)
            ->get();

        $relatedParty = DB::table("AccountInquiry_RelatedParty")
            ->where("acctNo", $acctNo)
            ->get();

        return Responses::AccountInquiryResponse(
            $accountDetail,
            $misInformation,
            $relatedParty
        );
    }

    function CibScreening(array $data, string $responseFormat): JsonResponse
    {
        $name = $data["name"];
        $record = DB::table("CibScreening")
            ->where('name', $name)
            ->where(function ($query) use ($data) {
                if (!empty($data["PanNumber"])) {
                    $query->where('pan_number', $data["PanNumber"]);
                } elseif (!empty($data["citizenship"])) {
                    $query->where("citizenship_number", $data["citizenship"]);
                }
            })
            ->first();

        // If record doesnt exists creating a fake one
        if (!$record) {
            DB::table("CibScreening")->insert([
                'name' => $name,
                'dob' => fake()->date(),
                'gender' => fake()->randomElement(['Male', 'Female', 'Other']),
                'father_name' => fake()->name('male'),
                'citizenship_number' => isset($data["citizenship"]) ? $data["citizenship"]: fake()->numerify('########'),
                'citizenship_issued_date' => fake()->date(),
                'citizenship_issued_district' => fake()->city(),
                'passport_number' => fake()->bothify('??######'),
                'passport_expiry_date' => fake()->date(),
                'driving_license_number' => fake()->bothify('DL-######'),
                'driving_license_issued_date' => fake()->date(),
                'voter_id_number' => fake()->bothify('VI######'),
                'voter_id_issued_date' => fake()->date(),
                'pan' => fake()->numerify('######'),
                'pan_issued_date' => fake()->date(),
                'pan_issued_district' => fake()->city(),
                'indian_embassy_number' => fake()->numerify('######'),
                'indian_embassy_reg_date' => fake()->date(),
                'sector' => fake()->word(),
                'blacklist_number' => fake()->numerify('BL######'),
                'blacklisted_date' => fake()->date(),
                'blacklist_type' => fake()->word(),
                'pan_number' => isset($data["PanNumber"]) ? $data["PanNumber"] : fake()->numerify('##########'),
                'company_reg_number' => fake()->bothify('CR-######'),
                'company_reg_date' => fake()->date(),
                'company_reg_auth' => fake()->company(),
                'dups' => rand(2, 5),
            ]);
        }

        // Querying from the database
        $queryResult = DB::table("CibScreening")
            ->where('name', $name)
            ->where(function ($query) use ($data) {
                if (!empty($data["PanNumber"])) {
                    $query->where('pan_number', $data["PanNumber"]);
                } elseif (!empty($data["citizenship"])) {
                    $query->where("citizenship_number", $data["citizenship"]);
                }
            })
            ->get();

        return Responses::CibScreeningResponse($queryResult);
    }

    function ComplienceScreeningAPI(array $data, string $responseFormat): JsonResponse
    {
        $name = $data["name"];
        $record = DB::table("ComplienceScreeningAPI")
            ->where("name", $name)
            ->first();

        // Create new record if not found
        if (!$record) {
            $address = fake()->address();
            $sanitizedAddress = str_replace("\n", " ", $address); // Replace newline characters with space

            // Inserting fake data in ComplienceScreeningAPI table
            DB::table("ComplienceScreeningAPI")->insert([
                'sno' => fake()->uuid(),
                'ofac_key' => fake()->uuid(),
                'ent_num' => fake()->randomNumber(5, true),
                'name' => $name,
                'typeV' => fake()->randomElement(['Individual', 'Organization']),
                'address' => $sanitizedAddress,  // Use sanitized address here
                'city' => fake()->city(),
                'state' => fake()->state(),
                'zip' => fake()->postcode(),
                'country' => fake()->country(),
                'remarks' => fake()->sentence(),
                'type_sort' => fake()->word(),
                'from_file' => fake()->word() . '.csv',
                'source' => fake()->company(),
                'manual_ofac_id' => fake()->uuid(),
                'intEnt' => fake()->boolean(),
                'name2' => fake()->name(),
                'DOB' => fake()->date(),
                'Metaphone' => fake()->word(),
                'Alternative_Script' => fake()->word(),
                'SoundexAplha' => strtoupper(fake()->lexify('???')),
                'DOB_YEAR' => fake()->year(),
                'DOB_MONTH' => fake()->month(),
                'Other_Name' => fake()->name(),
                'insertion_time' => fake()->dateTime(),
                'modification_time' => fake()->dateTime(),
                'ACCUITY_UPDATE' => fake()->dateTime(),
                'is_deleted' => fake()->boolean(10), // 10% chance of being true
            ]);
        }

        $queryResult = DB::table("ComplienceScreeningAPI")
            ->where("name", $name)
            ->get();

        return Responses::ComplienceScreeningAPIResponse($queryResult);
    }

    function CorpCustInq(array $data, string $responseFormat): JsonResponse
    {
        $cust_id = $data["cust_id"];
        $record = DB::table("CorpCustInq_GeneralDetails")
            ->where("cust_id", $cust_id)
            ->first();

        // Create a new record
        if (!$record) {
            // Insert into CorpCustInq_GeneralDetails
            DB::table('CorpCustInq_GeneralDetails')->insert([
                'cust_id' => $cust_id,
                'cust_title_code' => fake()->randomElement(['Mr', 'Ms', 'M/S']),
                'cust_name' => fake()->company(),
                'cust_short_name' => substr(fake()->company(), 0, 10),
                'cust_sex' => fake()->randomElement(['M', 'F', 'O']),
                'cust_minor_flg' => fake()->randomElement(['Y', 'N']),
                'date_of_birth' => fake()->date('Y-m-d', '2005-01-01'),
                'cust_marital_status' => fake()->randomElement(['001', '002', '003', '004']),
                'cust_emp_id' => fake()->optional()->numerify('EMP###'),
                'mobile_no' => fake()->optional()->phoneNumber(),
                'psprt_num' => fake()->optional()->regexify('[A-Z]{2}[0-9]{6}'),
                'psprt_issu_date' => fake()->optional()->date(),
                'psprt_det' => fake()->optional()->text(20),
                'psprt_exp_date' => fake()->optional()->date(),
                'address_type' => fake()->randomElement(['P', 'C', 'B']),
                'cust_nre_flg' => fake()->randomElement(['Y', 'N']),
                'name_screening_id_no' => fake()->numerify('######'),
                'idtype' => fake()->randomElement(['INST', 'IND']),
                'idno' => fake()->numerify('#########/###/###'),
                'idissuedate' => fake()->date('Y-m-d'),
                'issuedistrict' => fake()->city(),
                'idregisteredin' => fake()->randomElement(['001', '002', '003']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert into CorpCustInq_RetCustAddrInfo
            foreach (['CUSTCOMMADD', 'CUSTEMPADD', 'CUSTPERMADD'] as $type) {
                DB::table('CorpCustInq_RetCustAddrInfo')->insert([
                    'customer_id' => $cust_id,
                    'address_type' => $type,
                    'address1' => fake()->optional()->address(),
                    'address2' => fake()->optional()->address(),
                    'municipality_vdc_name' => fake()->optional()->city(),
                    'ward_no' => fake()->optional()->numberBetween(1, 20),
                    'zonee' => fake()->randomElement(['BAGM', 'LUMB', 'GAND']),
                    'city_code' => fake()->city(),
                    'district_code' => fake()->city(),
                    'email_id' => fake()->optional()->safeEmail(),
                    'cntry_code' => fake()->countryCode(),
                    'phone_num1' => fake()->optional()->phoneNumber(),
                    'phone_num2' => fake()->optional()->phoneNumber(),
                    'del_flg' => fake()->randomElement(['Y', 'N']),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Insert into CorpCustInq_MisInformation
            DB::table('CorpCustInq_MisInformation')->insert([
                'customer_id' => $cust_id,
                'cust_occp_code' => fake()->numberBetween(1, 10),
                'cust_othr_bank_code' => fake()->numerify('###'),
                'cust_grp' => fake()->randomElement(['1', '2', '3']),
                'cust_status' => fake()->randomElement(['0', '1']),
                'cdd_ecdd_date' => fake()->date('Y-m-d'),
                'constitution' => fake()->randomElement(['001', '002', '003']),
                'cust_free_text' => fake()->optional()->text(50),
                'annual_turn_over' => fake()->randomElement(['5', '10', '15']),
                'education_qualification' => fake()->randomElement(['1', '2', '3', '4', '5']),
                'religion' => fake()->randomElement(['1', '2', '3', '4', '5']),
                'annual_turn_over_as_on' => fake()->date('Y-m-d'),
                'rm_code' => fake()->numerify('###'),
                'risk_category' => fake()->randomElement(['A', 'B', 'C']),
                'total_no_of_annual_txn' => fake()->randomElement(['A', 'B', 'C']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert into CorpCustInq_CorpMiscInfoData
            $items = rand(1, 5);
            for ($i = 0; $i < $items; $i++) {
                DB::table('CorpCustInq_CorpMiscInfoData')->insert([
                    'customer_id' => $cust_id,
                    'person_reltn_name' => fake()->name(), // Generate a random name
                    'cust_reltn_code' => fake()->randomElement(['SHARE', 'OWNER']),
                    'del_flg' => fake()->randomElement(['Y', 'N']),
                    'cust_id' => fake()->optional()->numerify('###'),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Insert into CorpCustInq_CurrencyInfo
            DB::table('CorpCustInq_CurrencyInfo')->insert([
                'customer_id' => $cust_id,
                'crncy_code' => fake()->currencyCode(),
                'del_flg' => fake()->randomElement(['Y', 'N']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Now querying the data from the database
        $generalDetails = DB::table("CorpCustInq_GeneralDetails")
            ->where("cust_id", $cust_id)
            ->get();

        $reqCustAddrInfo = DB::table("CorpCustInq_RetCustAddrInfo")
            ->where("customer_id", $cust_id)
            ->get();

        $misInformation = DB::table("CorpCustInq_MisInformation")
            ->where("customer_id", $cust_id)
            ->get();

        $corpMiscInfoData = DB::table("CorpCustInq_CorpMiscInfoData")
            ->where("customer_id", $cust_id)
            ->get();

        $currencyInfo = DB::table("CorpCustInq_CurrencyInfo")
            ->where("customer_id", $cust_id)
            ->get();

        // Convert to the required format
        return Responses::CorpCustInqResponse(
            $generalDetails,
            $reqCustAddrInfo,
            $misInformation,
            $corpMiscInfoData,
            $currencyInfo
        );
    }
}
