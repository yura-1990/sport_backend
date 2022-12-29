<?php

namespace App\Http\Controllers;

use App\Models\Fillial;
use Illuminate\Http\Request;
use App\Http\Traits\LocaleTrait;
use Symfony\Component\HttpFoundation\Response;

class FillialController extends Controller
{
    use LocaleTrait;

    /**
     * @OA\Get(
     *     path="/api/filial",
     *     tags={"Filial"},
     *     summary="Get all data from fillials database",
     *     description="Via this link All fillials` datas come",
     *     operationId="filials",
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

    public function filials()
    {
        try {
            $filial = Fillial::select('id', LocaleTrait::convert('name'))->get();
            return response()->json([
                'status' => __('ok'),
                'filial' => $filial
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
