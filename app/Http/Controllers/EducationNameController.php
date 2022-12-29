<?php

namespace App\Http\Controllers;

use App\Models\EducationName;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Traits\LocaleTrait;

class EducationNameController extends Controller
{
    use LocaleTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/educationname",
     *     tags={"EducationName"},
     *     summary="Get all data from EducationName database",
     *     description="Via this link All EducationNames` datas come",
     *     operationId="educationName",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthenticated"
     *     ),
     *      @OA\Response(
     *         response=400,
     *         description="Invalid status value"
     *     ),
     *  )
     */

    public function educationName()
    {
        try {
            $educationName = EducationName::select('id',LocaleTrait::convert('name'), 'created_at', 'updated_at')->get();
            return response()->json([
                'status' => __('ok'),
                'educationName' => $educationName
            ],Response::HTTP_OK);
        }
        catch (\Exception $e){
            return
                response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\EducationName  $educationName
     * @return \Illuminate\Http\Response
     */
    public function show(EducationName $educationName)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\EducationName  $educationName
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, EducationName $educationName)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\EducationName  $educationName
     * @return \Illuminate\Http\Response
     */
    public function destroy(EducationName $educationName)
    {
        //
    }
}
