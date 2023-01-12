<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;


/**
 * @OA\Info(
 *     description="Sport Api Documentation to build the frontend of this site",
 *     version="1.0.0",
 *     title="Sport Api Swagger Documentation Anatation",
 *     termsOfService="http://swagger.io/terms/",
 *     @OA\Contact(
 *         email="yurayur1990@gmail.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * )
 *
 *
 * @OA\Server(
 *     description="Sport api server link",
 *     url="http://localhost:8000/"
 * )
 * @OA\Server(
 *     description="Sport api server link",
 *     url="http://localhost:8000/"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function success($data = [], $message = '')
    {
        return response()->json([
            'status' => 'ok',
            'message' => $message,
            'data' => $data,
        ]);
    }

    public function error($message, $code = 500)
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], $code);
    }
}
