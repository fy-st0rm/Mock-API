<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ExecuteRequest;
use App\Models\ResponseFormat;
use App\Models\CibScreeningData;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;

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
        $responseFormat = str_replace('[[ACCT_SHORT_NAME]]', fake()->name(), $responseFormat);
        $responseFormat = str_replace('[[SOL_ID]]', fake()->numberBetween(1000, 9999), $responseFormat);
        $responseFormat = str_replace('[[ACCT_NAME]]', fake()->name(), $responseFormat);
        $responseFormat = str_replace('[[CUST_ID]]', fake()->randomNumber(9, true), $responseFormat);
        $responseFormat = str_replace('[[SCHM_CODE]]', fake()->word(), $responseFormat);
        $responseFormat = str_replace('[[GL_SUB_HEAD_CODE]]', fake()->word(), $responseFormat);
        $responseFormat = str_replace('[[ACCT_CLS_FLG]]', fake()->randomElement(['Y', 'N']), $responseFormat);
        $responseFormat = str_replace('[[ACCT_CRNCY_CODE]]', fake()->currencyCode(), $responseFormat);
        $responseFormat = str_replace('[[SCHM_TYPE]]', fake()->word(), $responseFormat);
        $responseFormat = str_replace('[[ACCT_OPN_DATE]]', fake()->dateTimeThisDecade()->format('d/m/Y H:i:s'), $responseFormat);
        $responseFormat = str_replace('[[ACCT_CLS_DATE]]', fake()->dateTimeThisDecade()->format('d/m/Y H:i:s'), $responseFormat);
        $responseFormat = str_replace('[[FREZ_CODE]]', fake()->randomLetter(), $responseFormat);
        $responseFormat = str_replace('[[FREZ_REASON_CODE]]', fake()->word(), $responseFormat);
        $responseFormat = str_replace('[[NRB_DEPOSIT_LOAN_DETAIL]]', fake()->randomLetter(), $responseFormat);
        $responseFormat = str_replace('[[NRB_DEPOSIT_DETAIL]]', fake()->randomLetter(), $responseFormat);
        $responseFormat = str_replace('[[ACCT_POA_AS_REC_TYPE]]', fake()->randomLetter(), $responseFormat);
        $responseFormat = str_replace('[[ACCT_POA_AS_NAME]]', fake()->name(), $responseFormat);

        $jsonData = json_decode($responseFormat);
        return response()->json($jsonData, 200);
    }

    function CibScreening(array $data, string $responseFormat): JsonResponse
    {
        // Querying the database for matching name and pan or citizenship
        $record = CibScreeningData::where('name', $data["name"])
            ->where(function ($query) use ($data) {
                if (!empty($data["PanNumber"])) {
                    $query->where('pan', $data["PanNumber"]);
                } elseif (!empty($data["citizenship"])) {
                    $query->where("citizenship_number", $data["citizenship"]);
                }
            })
            ->first();

        // If record doesnt exists creating a fake one
        if (!$record) {
            $record = CibScreeningData::create([
                'name' => $data["name"],
                'dob' => fake()->date(),
                'gender' => fake()->randomElement(['Male', 'Female', 'Other']),
                'father_name' => fake()->name('male'),
                'citizenship_number' => isset($data['citizenship']) ? $data['citizenship'] : fake()->numerify('########'),
                'citizenship_issued_date' => fake()->date(),
                'citizenship_issued_district' => fake()->city(),
                'passport_number' => fake()->bothify('??######'),
                'passport_expiry_date' => fake()->date(),
                'driving_license_number' => fake()->bothify('DL-######'),
                'driving_license_issued_date' => fake()->date(),
                'voter_id_number' => fake()->bothify('VI######'),
                'voter_id_issued_date' => fake()->date(),
                'pan' => isset($data["PanNumber"]) ? $data["PanNumber"] : fake()->numerify('##########'),
                'pan_issued_date' => fake()->date(),
                'pan_issued_district' => fake()->city(),
                'indian_embassy_number' => fake()->numerify('######'),
                'indian_embassy_reg_date' => fake()->date(),
                'sector' => fake()->word(),
                'blacklist_number' => fake()->numerify('BL######'),
                'blacklisted_date' => fake()->date(),
                'blacklist_type' => fake()->word(),
                'company_reg_number' => fake()->bothify('CR-######'),
                'company_reg_date' => fake()->date(),
                'company_reg_auth' => fake()->company(),
            ]);
        }

        // Filling up the response
        $responseFormat = str_replace('[[Name]]', $record->name, $responseFormat);
        $responseFormat = str_replace('[[DOB]]', $record->dob, $responseFormat);
        $responseFormat = str_replace('[[Gender]]', $record->gender, $responseFormat);
        $responseFormat = str_replace('[[FatherName]]', $record->father_name, $responseFormat);
        $responseFormat = str_replace('[[CitizenshipNumber]]', $record->citizenship_number, $responseFormat);
        $responseFormat = str_replace('[[CitizenshipIssuedDate]]', $record->citizenship_issued_date, $responseFormat);
        $responseFormat = str_replace('[[CitizenshipIssuedDistrict]]', $record->citizenship_issued_district, $responseFormat);
        $responseFormat = str_replace('[[PassportNumber]]', $record->passport_number, $responseFormat);
        $responseFormat = str_replace('[[PassportExpiryDate]]', $record->passport_expiry_date, $responseFormat);
        $responseFormat = str_replace('[[DrivingLicenseNumber]]', $record->driving_license_number, $responseFormat);
        $responseFormat = str_replace('[[DrivingLicenseIssuedDate]]', $record->driving_license_issued_date, $responseFormat);
        $responseFormat = str_replace('[[VoterIdNumber]]', $record->voter_id_number, $responseFormat);
        $responseFormat = str_replace('[[VoterIdIssuedDate]]', $record->voter_id_issued_date, $responseFormat);
        $responseFormat = str_replace('[[PAN]]', $record->pan, $responseFormat);
        $responseFormat = str_replace('[[PANIssuedDate]]', $record->pan_issued_date, $responseFormat);
        $responseFormat = str_replace('[[PANIssuedDistrict]]', $record->pan_issued_district, $responseFormat);
        $responseFormat = str_replace('[[IndianEmbassyNumber]]', $record->indian_embassy_number, $responseFormat);
        $responseFormat = str_replace('[[IndianEmbassyRegDate]]', $record->indian_embassy_reg_date, $responseFormat);
        $responseFormat = str_replace('[[Sector]]', $record->sector, $responseFormat);
        $responseFormat = str_replace('[[BlacklistNumber]]', $record->blacklist_number, $responseFormat);
        $responseFormat = str_replace('[[BlacklistedDate]]', $record->blacklisted_date, $responseFormat);
        $responseFormat = str_replace('[[BlacklistType]]', $record->blacklist_type, $responseFormat);
        $responseFormat = str_replace('[[PanNumber]]', $record->pan_number, $responseFormat);
        $responseFormat = str_replace('[[CompanyRegNumber]]', $record->company_reg_number, $responseFormat);
        $responseFormat = str_replace('[[CompanyRegDate]]', $record->company_reg_date, $responseFormat);
        $responseFormat = str_replace('[[CompanyRegAuth]]', $record->company_reg_auth, $responseFormat);

        $jsonData = json_decode($responseFormat, true);
        return response()->json($jsonData, 200);
    }
}
