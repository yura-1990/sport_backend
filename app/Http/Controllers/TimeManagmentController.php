<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTimeManagmentRequest;
use App\Http\Requests\UpdateTimeManagmentRequest;
use App\Models\TimeManagment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;
use Carbon\Carbon;

class TimeManagmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/time_managment",
     *     tags={"Times"},
     *     summary="Get all data from TimeManagment database",
     *     description="Via this link All TimeManagments` datas come",
     *     operationId="timeManagment",
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

    public function timeManagment()
    {
        try {
            $timeManagment = TimeManagment::all();

            return response()->json([
                'status' => __('Success'),
                'timeManagment' => $timeManagment
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

    /**
     * @OA\Post(
     *     path="/api/time_managment",
     *     tags={"Times"},
     *     summary="Create a times",
     *     operationId="storeTimeManagment",
     *      @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
 *                      format="date-time",
     *                 @OA\Property(
     *                     property="day_from",
     *                     description="Set starting day",
     *                     format="date"
     *                 ),
     *                 @OA\Property(
     *                     property="time_from",
     *                     description="Set starting time",
     *                     format="time"
     *                 ),
     *                 @OA\Property(
     *                     property="day_to",
     *                     description="Set ending day",
     *                     format="date"
     *                 ),
     *                 @OA\Property(
     *                     property="time_to",
     *                     description="Set ending time",
     *                     format="time"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     * )
     */

    public function storeTimeManagment(StoreTimeManagmentRequest $request)
    {
        try {
            $request->validated();
            $timeManagment = new TimeManagment();

            $timeManagment->day_from = $request->day_from;
            $timeManagment->time_from = $request->time_from;
            $timeManagment->day_to = $request->day_to;
            $timeManagment->time_to = $request->time_to;

            $timeManagment->save();

            return response()->json([
                'status' => __('Success'),
                'Message' => __('Data created successfully'),
                'timeManagment' => $timeManagment
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
     * Display the specified resource.
     *
     * @param  \App\Models\TimeManagment  $timeManagment
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/time_managment/{timeManagment}",
     *     tags={"Times"},
     *     summary="Get one data from Images database",
     *     description="Via this link a Images`s data comes to show",
     *     operationId="showTimeManagment",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="timeManagment",
     *         in="path",
     *         description="ID for timeManegment data",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
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

    public function showTimeManagment(TimeManagment $timeManagment)
    {
        try {
            $dayDate = Carbon::createFromFormat('Y-m-d', $timeManagment->day_from);
            $toDate = Carbon::createFromFormat('Y-m-d', $timeManagment->day_to);

            $check = Carbon::now()->between($dayDate, $toDate);



            return response()->json([
                'status' => __('Success'),
                'local'=> App::getLocale(),
                'timeManagment' => $timeManagment,
                'datas' => $check
            ]);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TimeManagment  $timeManagment
     * @return \Illuminate\Http\Response
     */
    /**
     * @OA\Put(
     *     path="/api/time_managment/{timeManagment}/update",
     *     tags={"Times"},
     *     summary="Updated",
     *     description="Update this timeManagment",
     *     operationId="updateTimeManagment",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="timeManagment",
     *         in="path",
     *         description="image that to be updated",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid avatar supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="avatar not found"
     *     ),
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 format="date-time",
     *                 @OA\Property(
     *                     property="day_from",
     *                     description="Set starting day",
     *                     format="date"
     *                 ),
     *                 @OA\Property(
     *                     property="time_from",
     *                     description="Set starting time",
     *                     format="time"
     *                 ),
     *                 @OA\Property(
     *                     property="day_to",
     *                     description="Set ending day",
     *                     format="date"
     *                 ),
     *                 @OA\Property(
     *                     property="time_to",
     *                     description="Set ending time",
     *                     format="time"
     *                 ),
     *             ),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     *   )
     */

    public function updateTimeManagment(UpdateTimeManagmentRequest $request, TimeManagment $timeManagment)
    {
        try {
            $request->validated();

            $timeManagment->day_from = $request->day_from;
            $timeManagment->time_from = $request->time_from;
            $timeManagment->day_to = $request->day_to;
            $timeManagment->time_to = $request->time_to;

            $timeManagment->save();

            return response()->json([
                'status' => __('Success'),
                'Message' => __('Data updated successfully'),
                'timeManagment' => $timeManagment
            ]);
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TimeManagment  $timeManagment
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *     path="/api/time_managment/{timeManagment}/delete",
     *     tags={"Times"},
     *     summary="Deletes a Times",
     *     operationId="destroyTimeManagment",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="timeManagment",
     *         in="path",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid course supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Avatar not found"
     *     ),
     *  )
     */

    public function destroyTimeManagment(TimeManagment $timeManagment)
    {
        $timeManagment->delete();
        return response()->json([
            'status' => 'success',
            'timeManagment'=> $timeManagment
        ]);
    }
}
