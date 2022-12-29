<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomePageStoreRequest;
use App\Models\HomePage;

class HomePageController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/home-pages",
     *     tags={"HomePage"},
     *     summary="Get all home page list",
     *     description="Via this link All home page datas come",
     *     operationId="homePage",
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
        return $this->success(HomePage::query()->get());
    }

    /**
     * @OA\Post(
     *  tags={"HomePage"},
     *  description="Save home page data",
     *  path="/api/home-pages",
     *  operationId="storeHomePage",
     *  @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  description="file to upload",
     *                  property="photo",
     *                  type="string",
     *                  format="binary"
     *              ),
     *              @OA\Property(
     *                  description="Video link",
     *                  property="video",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  description="Photo text",
     *                  property="photo_text",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  description="Status",
     *                  property="status",
     *                  type="integer"
     *              )
     *          )
     *      )
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
    public function store(HomePageStoreRequest $request)
    {
        $data = $request->validated();
        $data['status'] = $data['status'] ?? 10;
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('files', 'public');
        }
        $model = new HomePage();
        $model->fill($data);
        if ($model->save()) {
            return $this->success($model);
        }

        return $this->error("Unable to save home page item");
    }

    /**
     * @OA\Get(
     *     path="/api/home-pages/{id}",
     *     tags={"HomePage"},
     *     summary="Get home page",
     *     description="Via this link Home page",
     *     operationId="getHomePage",
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID for homePage data",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *  ),
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
    public function show(HomePage $homePage)
    {
        return $this->success($homePage);
    }

    /**
     * @OA\POST(
     *  tags={"HomePage"},
     *  description="Update home page data",
     *  path="/api/home-pages/{id}",
     *  operationId="updateHomePage",
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID for homePage data",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *  ),
     *  @OA\RequestBody(
     *      @OA\MediaType(
     *          mediaType="multipart/form-data",
     *          @OA\Schema(
     *              type="object",
     *              @OA\Property(
     *                  description="file to upload",
     *                  property="photo",
     *                  type="string",
     *                  format="binary"
     *              ),
     *              @OA\Property(
     *                  description="Video link",
     *                  property="video",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  description="Photo text",
     *                  property="photo_text",
     *                  type="string"
     *              ),
     *              @OA\Property(
     *                  description="Status",
     *                  property="status",
     *                  type="integer"
     *              ),
     *              @OA\Property(
     *                  description="Method (Send always PUT)",
     *                  property="_method",
     *                  type="string",
     *                  default="PUT"
     *              )
     *          )
     *      )
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
    public function update(HomePageStoreRequest $request, HomePage $homePage)
    {
        $data = $request->validated();
        $data['status'] = $data['status'] ?? 10;
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('files', 'public');
        }
        $homePage->fill($data);
        if ($homePage->save()) {
            return $this->success($homePage);
        }

        return $this->error("Unable to update home page item");
    }

    /**
     * @OA\Delete(
     *     path="/api/home-pages/{id}",
     *     tags={"HomePage"},
     *     summary="Delete home page",
     *     description="Delete home page",
     *     operationId="deletePage",
     *  @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID for homePage data",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *  ),
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
    public function delete(HomePage $homePage)
    {
        $homePage->delete();
        return $this->success($homePage);
    }
}
