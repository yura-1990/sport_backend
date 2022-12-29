<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAllScoreRequest;
use App\Http\Requests\UpdateAllScoreRequest;
use App\Models\AllScore;
use App\Models\Check;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class AllScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/allScore",
     *     tags={"AllScore"},
     *     summary="Get all data from fillials database",
     *     description="Via this link All fillials` datas come",
     *     operationId="allScore",
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

    public function allScore()
    {
        try {
            $allScore = AllScore::all();

            return response()->json([
                'status' => __('ok'),
                'allScore' => $allScore
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
     *     path="/api/allScore",
     *     tags={"AllScore"},
     *     summary="Register a allScore",
     *     operationId="storeAllScore",
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
     *                 @OA\Property(
     *                     property="direction_id",
     *                     description="direction ID",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="user_id",
     *                     description="Direction category ID",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="all_score",
     *                     description="Direction category score",
     *                     type="string"
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

    public function storeAllScore(StoreAllScoreRequest $request)
    {
        try {
            $request->validated();
            $allScore = new AllScore;
            $allScore->user_id =  $request->user_id;
            $allScore->direction_id =  $request->direction_id;
            $allScore->all_score =  $request->all_score;
            $allScore->save();
            return response()->json([
                'status' => __('Success'),
                'allScore' => $allScore
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
     * @param  \App\Models\AllScore  $allScore
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/allScore/{allScore}",
     *     tags={"AllScore"},
     *     summary="Get one data from showAllScore database",
     *     description="Via this link a showAllScore`s data comes to show",
     *     operationId="showAllScore",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="allScore",
     *         in="path",
     *         description="ID for avatar data",
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

    public function showAllScore(AllScore $allScore)
    {
        try {
            return response()->json([
                'status' => __('ok'),
                'local'=> App::getLocale(),
                'allScore' => $allScore,
            ], Response::HTTP_OK);
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
     * @param  \App\Models\AllScore  $allScore
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Put(
     *     path="/api/allScore/{allScore}/update",
     *     tags={"AllScore"},
     *     summary="Updated",
     *     description="Update this AllScore",
     *     operationId="updateAllScore",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="allScore",
     *         in="path",
     *         description="allScore that to be updated",
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
     *                  @OA\Property(
     *                     property="all_score",
     *                     description="Direction category score",
     *                     type="string"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation"
     *     )
     *   )
     */

    public function updateAllScore(UpdateAllScoreRequest $request, AllScore $allScore)
    {
        try {
            $request->validated();
            $allScore->all_score=$request->all_score;
            $allScore->save();
            return response()->json([
                'status' => __('ok'),
                'local'=> App::getLocale(),
                'Message' => __('Data updated successfully'),
                'allScore' => $allScore
            ], Response::HTTP_OK);
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
     * @param  \App\Models\AllScore  $allScore
     * @return \Illuminate\Http\JsonResponse
     */

    /**
     * @OA\Delete(
     *     path="/api/allScore/{allScore}/delete",
     *     tags={"AllScore"},
     *     summary="Deletes a allScore",
     *     operationId="destroyAllScore",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="allScore",
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

    public function destroyAllScore(AllScore $allScore)
    {
        try {
            $allScore->delete();
            return response()->json([
                'status' => __('ok'),
                'local'=> App::getLocale(),
                'Message' => __('Data updated successfully'),
                'check' => $allScore
            ], Response::HTTP_OK);
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
     * @OA\Get(
     *     path="/api/allScoreWithUserId/{user_id}",
     *     tags={"AllScore"},
     *     summary="Get one data from showAllScore database",
     *     description="Via this link a showAllScore`s data comes to show",
     *     operationId="userScore",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="user_id",
     *         in="path",
     *         description="ID for avatar data",
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

    public function userScore($user_id){
        try {
            $getUser = User::find($user_id)->check;
            $result=0;
            foreach ($getUser as $score){
                $result += $score->score;
            }

            return response()->json([
                'status' => __('ok'),
                'all_score'=>$result ?? null
            ], Response::HTTP_OK);
        }
        catch (\Exception $e){
            return
                response()->json([
                    'status' => false,
                    'message' => $e->getMessage(),
                ]);
        }
    }


}
