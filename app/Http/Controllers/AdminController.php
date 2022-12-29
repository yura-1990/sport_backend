<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAdminRequest;
use App\Models\Pasport;
use App\Models\Role;
use App\Models\User;
use App\Services\NotificationService;
use Exception;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/admins",
     *     tags={"Admin"},
     *     summary="Get all admin list",
     *     description="Via this link All admin datas come",
     *     operationId="admin",
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
     *
     *  )
     */
    public function index()
    {
        $admin = User::query()->with('pasport', 'fillial')->isAdmin()->get();
        return $this->success($admin);
    }

    /**
     * @OA\Post(
     *     path="/api/admins",
     *     tags={"Admin"},
     *     summary="Create admin",
     *     operationId="storeAdmin",
     *      @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="login",
     *                     description="Admin login",
     *                     type="string",
     *                     default="admin"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="Admin password",
     *                     type="string",
     *                     default="admin"
     *                 ),
     *                 @OA\Property(
     *                     property="pnfl",
     *                     description="Admin pnfl",
     *                     type="integer",
     *                      default=31805911230083
     *                 ),
     *                 @OA\Property(
     *                     property="pasport_seria",
     *                     description="Admin passport seria",
     *                     type="string",
     *                     default="AB"
     *                 ),
     *                 @OA\Property(
     *                     property="pasport_seria_code",
     *                     description="Admin passport number",
     *                     type="integer",
     *                     default=1234567
     *                 ),
     *                 @OA\Property(
     *                     property="fillial_id",
     *                     description="Fillial ID number",
     *                     type="integer",
     *                     default=1
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
    public function store(StoreAdminRequest $request, NotificationService $service)
    {
        $data = $request->validated();
        $role = Role::query()->where('type', 'admin')->first();
        DB::beginTransaction();
        try {
            $pModel = new Pasport();
            $pModel->fill($data);
            if ($pModel->save()) {
                $data['pasport_id'] = $pModel->id;
                $data['role_id'] = $role->id;
                $uModel = new User();
                $uModel->fill($data);
                $uModel->save();
                DB::commit();
                $service->create('User created', $uModel, [1]);
                return response()->json([
                    'status' => 'ok',
                    'message' => 'Admin created successfully',
                    'admin' => $uModel,
                ]);
            }

        } catch (Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }

        return $this->error('Something is wrong! Check your data');
    }

    /**
     * @OA\Get(
     *     path="/api/admins/{user}",
     *     tags={"Admin"},
     *     summary="Get one data",
     *     description="Get one",
     *     operationId="showAdmin",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="ID for user data",
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
    public function show(User $user)
    {
        $user->load('pasport', 'fillial');
        return $this->success($user);
    }

    /**
     * @OA\Put(
     *     path="/api/admins/{user}",
     *     tags={"Admin"},
     *     summary="Update",
     *     description="Update data",
     *     operationId="update",
     *     @OA\Parameter(
     *         name="user",
     *         in="path",
     *         description="id",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid university supplied"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="university not found"
     *     ),
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="login",
     *                     description="Admin login",
     *                     type="string",
     *                     default="admin"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="Admin password",
     *                     type="string",
     *                     default="admin"
     *                 ),
     *                 @OA\Property(
     *                     property="pnfl",
     *                     description="Admin pnfl",
     *                     type="integer",
     *                      default=31805911230083
     *                 ),
     *                 @OA\Property(
     *                     property="pasport_seria",
     *                     description="Admin passport seria",
     *                     type="string",
     *                     default="AB"
     *                 ),
     *                 @OA\Property(
     *                     property="pasport_seria_code",
     *                     description="Admin passport number",
     *                     type="integer",
     *                     default=1234567
     *                 ),
     *                 @OA\Property(
     *                     property="fillial_id",
     *                     description="Admin fillial",
     *                     type="integer",
     *                     default=1
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

    public function update(StoreAdminRequest $request, User $user)
    {
        $data = $request->validated();
        DB::beginTransaction();
        try {
            DB::commit();
            $user->fill($data);
            if ($user->save()) {
                $passport = $user->pasport;
                $passport->fill($data);
                $passport->save();
                return $this->success($user);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return $this->error($e->getMessage());
        }

        return $this->error('Something is wrong! Check your data');
    }


    /**
     * @OA\Delete(
     *     path="/api/admins/{user}",
     *     tags={"Admin"},
     *     summary="Deletes",
     *     operationId="destroyAdmin",
     *     @OA\Parameter(
     *         name="user",
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
     *         description="course not found"
     *     ),
     *  )
     */

    public function delete(User $user)
    {
        DB::beginTransaction();
        try {
            $user->pasport()->delete();
            $user->delete();
            DB::commit();
            return $this->success($user);
        } catch (Exception $e) {
            DB::rollBack();
        }

        return $this->error('Something is wrong! Check your data');
    }
}
