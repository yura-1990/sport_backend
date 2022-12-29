<?php

namespace App\Http\Controllers;

use App\Models\WorkPlace;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Traits\LocaleTrait;

class WorkPlaceController extends Controller
{
    use LocaleTrait;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/workplace",
     *     tags={"WorkPlace"},
     *     summary="Get all data from workplace database",
     *     description="Via this link All workplaces` datas come",
     *     operationId="workPlace",
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

    public function workPlace()
    {
        try {
            $workPlace = WorkPlace::select('id',LocaleTrait::convert('name'), 'created_at', 'updated_at')->get();
            return response()->json([
                'status' => __('ok'),
                'workPlace' => $workPlace
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
     * @param  \App\Models\WorkPlace  $workPlace
     * @return \Illuminate\Http\Response
     */
    public function show(WorkPlace $workPlace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\WorkPlace  $workPlace
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, WorkPlace $workPlace)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\WorkPlace  $workPlace
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkPlace $workPlace)
    {
        //
    }
}
