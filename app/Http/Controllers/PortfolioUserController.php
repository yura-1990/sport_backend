<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePortfolioUserRequest;
use App\Http\Requests\UpdatePortfolioUserRequest;
use App\Models\PortfolioUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\Response;

class PortfolioUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/portfolioUser",
     *     tags={"PortfolioUser"},
     *     summary="Get all data from PortfolioUser database",
     *     description="Via this link All PortfolioUser` datas come",
     *     operationId="portfolioUser",
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

    public function portfolioUser()
    {
        try {
            $portfolioUser = PortfolioUser::get();
            return response()->json([
                'status' => __('ok'),
                'portfolioUser' => $portfolioUser
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
     *     path="/api/portfolioUser",
     *     tags={"PortfolioUser"},
     *     summary="portfolio check User",
     *     operationId="storePortfolioUser",
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

    public function storePortfolioUser(StorePortfolioUserRequest $request)
    {
        try {
            $request->validated();
            $portfolioUser = PortfolioUser::updateOrCreate(
                ['user_id'=>$request->user_id],
                [
                    'user_id'=>$request->user_id,
                    'permission'=>$request->permission,
                    'message'=>$request->message
                ]
            );
            return response()->json([
                'status' => __('ok'),
                'portfolioUser' => $portfolioUser
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
     * @param  \App\Models\PortfolioUser  $portfolioUser
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/portfolioUser/{portfolioUser}",
     *     tags={"PortfolioUser"},
     *     summary="Get one data from showPortfolioUser database",
     *     description="Via this link a showPortfolioUser`s data comes to show",
     *     operationId="showPortfolioUser",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="portfolioUser",
     *         in="path",
     *         description="ID for portfolioUser data",
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

    public function showPortfolioUser(PortfolioUser $portfolioUser)
    {
        try {
            return response()->json([
                'status' => __('ok'),
                'local'=> App::getLocale(),
                'portfolioUser' => $portfolioUser,
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
     *     path="/api/portfolioUserById/{user_id}",
     *     tags={"PortfolioUser"},
     *     summary="Get one data from showPortfolioUser database",
     *     description="Via this link a showPortfolioUser`s data comes to show",
     *     operationId="getPortfolioUser",
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
     *         description="ID for portfolioUser data",
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

    public function getPortfolioUser($user_id)
    {
        try {
            $portfolioUserById = PortfolioUser::where('user_id', $user_id)->get();
            return response()->json([
                'status' => __('ok'),
                'local'=> App::getLocale(),
                'portfolioUserById' => $portfolioUserById,
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
     * @param  \App\Models\PortfolioUser  $portfolioUser
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Put(
     *     path="/api/portfolioUser/{portfolioUser}/update",
     *     tags={"PortfolioUser"},
     *     summary="Updated",
     *     description="Update this PortfolioUser",
     *     operationId="updatePortfolioUser",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="portfolioUser",
     *         in="path",
     *         description="PortfolioUser that to be updated",
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

    public function updatePortfolioUser(UpdatePortfolioUserRequest $request, PortfolioUser $portfolioUser)
    {
        try {
            $request->validated();
            $portfolioUser->update($request->all());

            return response()->json([
                'status' => __('ok'),
                'local'=> App::getLocale(),
                'message' => __('Data updated successfully'),
                'portfolioUser' => $portfolioUser
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
     * @param  \App\Models\PortfolioUser  $portfolioUser
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *     path="/api/portfolioUser/{portfolioUser}/delete",
     *     tags={"PortfolioUser"},
     *     summary="Deletes a PortfolioUser",
     *     operationId="destroyPortfolioUser",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="portfolioUser",
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

    public function destroyPortfolioUser(PortfolioUser $portfolioUser)
    {
        try {
            $portfolioUser->delete();

            return response()->json([
                'status' => 'ok',
                'portfolioUser'=> $portfolioUser
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
