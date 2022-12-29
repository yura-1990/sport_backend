<?php

namespace App\Http\Controllers;

use App\Exports\ExportUser;
use App\Imports\ImportUser;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class UserController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/users",
     *     tags={"User"},
     *     summary="Get all user list",
     *     description="Via this link All user datas come",
     *     operationId="user",
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
        $admin = User::query()->with('pasport', 'fillial', 'role')->get();
        return $this->success($admin);
    }

    /**
     * @OA\Get(
     *     path="/api/users/export",
     *     tags={"User"},
     *     summary="Get all user list in excel file",
     *     description="Returns file",
     *     operationId="userExport",
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
    public function export()
    {
        return Excel::download(new ExportUser(), 'users.xlsx');
    }

    /**
     * @OA\Post(
     *  tags={"User"},
     *  description="Import user files from excel",
     *  path="/api/users/import",
     *  operationId="userImport",
     *  @OA\RequestBody(
     *      @OA\MediaType(
     *      mediaType="multipart/form-data",
     *      @OA\Schema(
     *          type="object",
     *          @OA\Property(
     *              description="file to upload",
     *              property="file",
     *              type="string",
     *              format="binary"
     *          )
     *      )
     *  )
     * ),
     * @OA\Response(
     * response=200,
     * description="Successful operation",
     * ),
     * @OA\Response(
     * response=401,
     * description="Unauthenticated",
     * ),
     * @OA\Response(
     * response=403,
     * description="Forbidden"
     * )
     * )
     */
    public function import(Request $request)
    {
        Excel::import(new ImportUser(), $request->file('file')->store('files'));
        return $this->success();
    }
}
