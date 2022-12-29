<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUserPDFRequest;
use App\Http\Requests\UpdateUserPDFRequest;
use App\Models\Check;
use App\Models\User;
use App\Models\UserPdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class UserPdfController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/userPdf",
     *     tags={"UserPDF"},
     *     summary="Get all data from UserPdf database",
     *     description="Via this link All UserPdf` datas come",
     *     operationId="user_pdf",
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
     *
     *  )
     */

    public function user_pdf(): \Illuminate\Http\JsonResponse
    {
        try {
            $userPdf = Check::select('id', 'user_id', 'direction_id', 'direction_category_id', 'pdf')->get();
            return response()->json([
                'status' => true,
                'userPdf' => $userPdf,
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Post(
     *     path="/api/userPdf",
     *     tags={"UserPDF"},
     *     summary="Store an pdf file",
     *     operationId="storeUserPdf",
     *     @OA\Parameter(
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
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="user_id",
     *                     description="Type user id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="direction_category_id",
     *                     description="Type direction category id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="pdf",
     *                     description="Upload your pdf file",
     *                     type="file",
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

    public function storeUserPdf(StoreUserPDFRequest $request): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validated();

            if ($request->hasFile('pdf')){
                $getUserPdf = UserPdf::where('direction_category_id', $request->direction_category_id)->first()->pdf ?? null;
                if ($getUserPdf){
                    Storage::disk('public')->delete($getUserPdf);
                }
                $path = $request->file('pdf')->store('userPDF', 'public');
            }

            $userPDF = UserPdf::updateOrCreate(
                ['direction_category_id'=>$request->direction_category_id],
                [
                    'direction_category_id'=>$request->direction_category_id,
                    'pdf'=>$path
                ]
            );

            return response()->json([
                'status' => __('ok'),
                'message' => __('Data created or updated successfully'),
                'userPDF' => $userPDF,
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
     * Display the specified resource.
     *
     * @param  \App\Models\UserPdf  $userPdf
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Get(
     *     path="/api/userPdf/{userPdf}",
     *     tags={"UserPDF"},
     *     summary="Get one data from UserPDF database",
     *     description="Via this link a UserPDF`s data comes to show",
     *     operationId="showUserPdf",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="userPdf",
     *         in="path",
     *         description="ID for userPdf data",
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

    public function showUserPdf(UserPdf $userPdf): \Illuminate\Http\JsonResponse
    {
        try {
            return response()->json([
                'status' => 'ok',
                'userPdf' => $userPdf,
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
     *     path="/api/downloadUserPdf/{user_id}",
     *     tags={"UserPDF"},
     *     summary="Get one data from UserPDF database",
     *     description="Via this link a UserPDF`s data comes to show",
     *     operationId="downloadUserPdf",
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
     *         description="ID for userPdf data",
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

    public function downloadUserPdf($user_id): \Symfony\Component\HttpFoundation\BinaryFileResponse
    {
        try {
          /*  $userPDF = User::find($user_id)->check;
            $data = [];
            foreach ($userPDF as $pdf){
                $pdfInfo['direction_category_id'] = $pdf->direction_category_id;
                $pdfInfo['pdf'] = $pdf->pdf;
                $data[]=$pdfInfo;
            }*/

            $getpdf = Check::find($user_id)->pdf;
            $headers = ['Content-Type: application/pdf'];
            $fileName = time().'.pdf';
            return response()->download($getpdf, $fileName,$headers);

           /* return response()->json([
                'status' => 'ok',
                'userPDF'=>$getpdf
            ], Response::HTTP_OK);*/
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
     * @param  \App\Models\UserPdf  $userPdf
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Put(
     *     path="/api/userPdf/{userPdf}/update",
     *     tags={"UserPDF"},
     *     summary="Updated",
     *     description="Update this userPDF",
     *     operationId="updateUserPdf",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="userPdf",
     *         in="path",
     *         description="userPDF that to be updated",
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
     *             mediaType="multipart/form-data",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="pdf",
     *                     description="Upload your pdf file",
     *                     type="file",
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

    public function updateUserPdf(UpdateUserPDFRequest $request, UserPdf $userPdf): \Illuminate\Http\JsonResponse
    {
        try {
            $request->validated();
            if ($request->hasFile('pdf')){
                Storage::disk('public')->delete($userPdf->pdf);
                $path = $request->file('pdf')->store('userPDF', 'public');
            }

            $userPdf->update([
                'pdf' => $path ?? $userPdf->pdf
            ]);

            return response()->json([
                'status' => __('ok'),
                'message' => __('Data updated successfully'),
                'userPdf' => $userPdf,
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
     * @param  \App\Models\UserPdf  $userPdf
     * @return \Illuminate\Http\Response
     */

    /**
     * @OA\Delete(
     *     path="/api/userPdf/{id}/delete",
     *     tags={"UserPDF"},
     *     summary="Deletes a userPdf",
     *     operationId="destroyUserPdf",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="id",
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

    public function destroyUserPdf($id): \Illuminate\Http\JsonResponse
    {
        try {
            $userPdf = UserPdf::find($id);
            Storage::disk('public')->delete($userPdf->pdf);
            $userPdf->delete();
            return response()->json([
                'status' => __('ok'),
                'userPdf'=> $userPdf
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
