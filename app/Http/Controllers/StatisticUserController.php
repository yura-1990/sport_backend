<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStatisticUserRequest;
use App\Http\Requests\UpdateStatisticUserRequest;
use App\Models\StatisticUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class StatisticUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/statisticUser",
     *     tags={"StatisticUser"},
     *     summary="Get all data from StatisticUser database",
     *     description="Via this link All StatisticUser` datas come",
     *     operationId="statisticUser",
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

    public function statisticUser()
    {
        try {
            $statisticUser = StatisticUser::get();
            return response()->json([
                'status' => __('ok'),
                'statisticUser' => $statisticUser
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
     *     path="/api/statisticUser",
     *     tags={"StatisticUser"},
     *     summary="Register a pasport",
     *     operationId="storeStatisticUser",
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
     *                     property="user_id",
     *                     description="type user id",
     *                     type="integer",
     *                 ),
     *                 @OA\Property(
     *                     property="permission",
     *                     description="permission of one of an Admin",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     description="message of one of an Admin",
     *                     type="string",
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

    public function storeStatisticUser(StoreStatisticUserRequest $request)
    {
        try {
            $request->validated();
            $statisticUsers = StatisticUser::updateOrCreate(
                ['user_id'=>$request->user_id],
                [
                    'user_id'=>$request->user_id,
                    'permission'=>$request->permission,
                    'message'=>$request->message
                ]
            );;
            return response()->json([
                'status' => __('ok'),
                'statisticUsers' => $statisticUsers
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
     * @param  \App\Models\StatisticUser  $statisticUser
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/statisticUser/{statisticUser}",
     *     tags={"StatisticUser"},
     *     summary="Get one data from showStatisticUser database",
     *     description="Via this link a showStatisticUser`s data comes to show",
     *     operationId="showStatisticUser",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="statisticUser",
     *         in="path",
     *         description="ID for checkUser data",
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

    public function showStatisticUser(StatisticUser $statisticUser)
    {
        try {
            return response()->json([
                'status' => __('ok'),
                'local'=> App::getLocale(),
                'statisticUser' => $statisticUser,
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
     * @OA\Get(
     *     path="/api/statisticUserById/{user_id}",
     *     tags={"StatisticUser"},
     *     summary="Get one data from showStatisticUser database",
     *     description="Via this link a showStatisticUser`s data comes to show",
     *     operationId="getStatisticUser",
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
     *         description="ID for checkUser data",
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

    public function getStatisticUser($user_id)
    {
        try {
            $statisticUserById = StatisticUser::where('user_id', $user_id)->get();
            return response()->json([
                'status' => __('ok'),
                'local'=> App::getLocale(),
                'statisticUserById' => $statisticUserById,
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
     * @param  \App\Models\StatisticUser  $statisticUser
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Put(
     *     path="/api/statisticUser/{statisticUser}/update",
     *     tags={"StatisticUser"},
     *     summary="Updated",
     *     description="Update this statisticUser",
     *     operationId="updateStatisticUser",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="statisticUser",
     *         in="path",
     *         description="StatisticUser that to be updated",
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
     *                 @OA\Property(
     *                     property="permission",
     *                     description="permission of one of an Admin",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="message",
     *                     description="massege of one of an Admin",
     *                     type="string",
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

    public function updateStatisticUser(UpdateStatisticUserRequest $request, StatisticUser $statisticUser)
    {
        try {
            $request->validated();
            $statisticUser->update($request->all());

            return response()->json([
                'status' => __('ok'),
                'local'=> App::getLocale(),
                'message' => __('Data updated successfully'),
                'statisticUser' => $statisticUser
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
     * @param  \App\Models\StatisticUser  $statisticUser
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *     path="/api/statisticUser/{statisticUser}/delete",
     *     tags={"StatisticUser"},
     *     summary="Deletes a statisticUser",
     *     operationId="destroyStatisticUser",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="statisticUser",
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
    public function destroyStatisticUser(StatisticUser $statisticUser)
    {
        try {
            $statisticUser->delete();

            return response()->json([
                'status' => 'ok',
                'statisticUser'=> $statisticUser
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
}
