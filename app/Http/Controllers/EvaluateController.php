<?php

namespace App\Http\Controllers;

use App\Exports\OneUserInfoExport;
use App\Exports\UsersInfoExport;
use App\Http\Requests\UpdateCheckRequest;
use App\Http\Resources\EvaluateResource;
use App\Models\AllScore;
use App\Models\Avatar;
use App\Models\Check;
use App\Models\CheckUser;
use App\Models\Direction;
use App\Models\DirectionCategory;
use App\Models\Education;
use App\Models\Pasport;
use App\Models\PersonalInfo;
use App\Models\PortfolioUser;
use App\Models\Region;
use App\Models\StatisticUser;
use App\Models\Training;
use App\Models\User;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Traits\LocaleTrait;

class EvaluateController extends Controller
{
    use LocaleTrait;
    /**
     * @OA\Get(
     *     path="/api/evaluate/{user_id}",
     *     tags={"Evaluate"},
     *     summary="Get all data from evaluate database",
     *     description="Via this link All evaluate` datas come",
     *     operationId="evaluate",
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
     *         description="user_id for check data",
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

    public function evaluate($user_id){
        try {
            $evaluate = Check::where('user_id', $user_id)->get();
            return  EvaluateResource::collection($evaluate);
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
     * @OA\Post (
     *     path="/api/evaluateCheck/{check_id}/update",
     *     tags={"Evaluate"},
     *     summary="Updated",
     *     description="Update this check",
     *     operationId="updateEvaluateChecks",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="check_id",
     *         in="path",
     *         description="avatar that to be updated",
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
     *                @OA\Property(
     *                     property="score",
     *                     description="score",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="admin_permission",
     *                     description="Permission of one of an Admin",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="messages",
     *                     description="message of one of an Admin",
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

    public function updateEvaluateChecks(Request $request, $check_id)
    {
        try {
            $request->validate([
                'score' => 'required|string',
                'admin_permission' => "required",
                "messages" => 'required'
            ]);

            $checkUserEveluate=Check::find($check_id);
            $checkUserEveluate->score=$request->score;
            $checkUserEveluate->admin_permission=$request->admin_permission;
            $checkUserEveluate->messages=$request->messages;
            $checkUserEveluate->update();

            return response()->json([
                'status' => __('ok'),
                'checkUserEveluate' => $checkUserEveluate
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
     *     path="/api/direction_user/{direction_id}",
     *     tags={"Evaluate"},
     *     summary="Get all data from evaluate database",
     *     description="Via this link All evaluate` datas come",
     *     operationId="countDirectionUser",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="direction_id",
     *         in="path",
     *         description="direction_id for check data",
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

    public function countDirectionUser($direction_id): \Illuminate\Http\JsonResponse
    {
        try {
            $direction_user = Check::where('direction_id', $direction_id)->get();
            $data = [];
            foreach ($direction_user as $user){
                $data[] = $user->user_id;
            }
            return response()->json([
                'data'=> $direction_user,
                'datas'=>count($data),

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
     * @OA\Get(
     *     path="/api/direction_with_user/{direction_id}/{fillial_id}",
     *     tags={"Evaluate"},
     *     summary="Get all data from evaluate database",
     *     description="Via this link All evaluate` datas come",
     *     operationId="directionWithUser",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="direction_id",
     *         in="path",
     *         description="direction_id for check data",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="fillial_id",
     *         in="path",
     *         description="fillial_id for check data",
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

    public function directionWithUser($direction_id, $fillial_id=null): \Illuminate\Http\JsonResponse
    {
        try {
            $direction_user = Check::where('direction_id',$direction_id)->get();


            $data = [];
            $passport_info = [];

            foreach ($direction_user as $user){

                if ($fillial_id==$user->user->fillial_id){

                    $getUser = User::find($user->user->id)->check;
                    $result=0;
                    foreach ($getUser as $score){
                        $result += $score->score;
                    }
                    $passport_info['pnfl'] = Pasport::where('id', $user->user->pasport_id)->first()->pnfl ?? null;
                    $passport_info['filliad_id'] =  $user->user->fillial_id ?? null;
                    $passport_info['pasport_seria'] = Pasport::where('id', $user->user->pasport_id)->first()->pasport_seria ?? null;
                    $passport_info['pasport_seria_code'] = Pasport::where('id', $user->user->pasport_id)->first()->pasport_seria_code ?? null;
                    $passport_info['user_name']=PersonalInfo::where('user_id', $user->user->id)->first()->full_name ?? null;
                    $passport_info['gender']=PersonalInfo::where('user_id', $user->user->id)->first()->gender ?? null;
                    $passport_info['email']=PersonalInfo::where('user_id', $user->user->id)->first()->email ?? null;
                    $passport_info['nationality']=PersonalInfo::where('user_id', $user->user->id)->first()->nationality ?? null;
                    $passport_info['birth_date']=PersonalInfo::where('user_id', $user->user->id)->first()->birth_date ?? null;
                    $passport_info['phone']=PersonalInfo::where('user_id', $user->user->id)->first()->phone ?? null;
                    $passport_info['avatar']=Avatar::where('user_id', $user->user->id)->first()->photo ?? null;
                    $passport_info['score']=Check::where('user_id', $user->user->id)->first()->score ?? null;
                    $passport_info['all_score']=$result ?? null;
                    $passport_info['training_direction']=Training::where('user_id', $user->user->id)->first()->direction ?? null;
                    $passport_info['training_date_end']=Training::where('user_id', $user->user->id)->first()->date_end ?? null;
                    $passport_info['training_date_start']=Training::where('user_id', $user->user->id)->first()->date_start ?? null;
                    $passport_info['education_specialization']=Education::select('specialization')->where('user_id', $user->user->id)->first() ?? null;
                    $passport_info['check_user']=CheckUser::where('user_id', $user->user->id)->first()->permission ?? null;
                    $passport_info['portfolio_user']=PortfolioUser::where('user_id', $user->user->id)->first()->permission ?? null;
                    $passport_info['statistic_user']=StatisticUser::where('user_id', $user->user->id)->first()->permission ?? null;
                    $passport_info['user_id']=$user->user->id ?? null;

                    $passport_info['region']= Region::select(LocaleTrait::convert('name'))->where('id', $user->user->region_id)->first() ?? null;
                }
                $data[] = $passport_info;

            }



            $uniq_array = array_unique($data, SORT_REGULAR);

            return response()->json([
                'data' => $uniq_array

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
     * @OA\Get(
     *     path="/api/userInfo/{direction_id}/export",
     *     tags={"Evaluate"},
     *     summary="Get all user list in excel file",
     *     description="Returns file",
     *     operationId="userInfoExport",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="direction_id",
     *         in="path",
     *         description="direction_id for check data",
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
     *
     *  )
     */

    public function userInfoExport($direction_id): BinaryFileResponse
    {
        return Excel::download(new UsersInfoExport($direction_id), 'userInfo.xlsx');
    }

    /**
     * @OA\Get(
     *     path="/api/oneUserInfo/{user_id}/export",
     *     tags={"Evaluate"},
     *     summary="Get all user list in excel file",
     *     description="Returns file",
     *     operationId="oneUserInfo",
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
     *         description="user id",
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
     *
     *  )
     */

    public function oneUserInfo($user_id): BinaryFileResponse
    {
        return Excel::download(new OneUserInfoExport($user_id), 'oneUserInfo.xlsx');
    }

    /**
     * @OA\Get(
     *     path="/api/user_in_direction/{user_id}",
     *     tags={"Evaluate"},
     *     summary="Get all data from evaluate database",
     *     description="Via this link All evaluate` datas come",
     *     operationId="userInDirection",
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
     *         description="user_id for check data",
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

    public function userInDirection($user_id)
    {
        try {
            $user = User::find($user_id);
            $region_id = Work::where('user_id', $user_id)->first()->region_id;
            $training_id = Training::where('user_id', $user_id)->first()->region_id;
            $getUser = User::find($user_id)->check;
            $result=0;
            foreach ($getUser as $score){
                $result += $score->score;
            }

            $passport_info['pnfl'] = Pasport::where('id', $user->pasport_id)->first()->pnfl ?? null;
            $passport_info['pasport_seria'] = Pasport::where('id', $user->pasport_id)->first()->pasport_seria ?? null;
            $passport_info['pasport_seria_code'] = Pasport::where('id', $user->pasport_id)->first()->pasport_seria_code ?? null ;
            $passport_info['user_name']=PersonalInfo::where('user_id', $user_id)->first()->full_name ?? null;
            $passport_info['email']=PersonalInfo::where('user_id', $user_id)->first()->email ?? null;
            $passport_info['nationality']=PersonalInfo::where('user_id', $user_id)->first()->nationality ?? null;
            $passport_info['birth_date']=PersonalInfo::where('user_id', $user_id)->first()->birth_date ?? null;
            $passport_info['phone']=PersonalInfo::where('user_id', $user_id)->first()->phone ?? null;
            $passport_info['user_id']=$user_id ?? null;
            $passport_info['gender']=PersonalInfo::where('user_id', $user_id)->first()->gender ?? null;
            $passport_info['avatar']=Avatar::where('user_id', $user_id)->first()->photo ?? null;
            $passport_info['score']=Check::where('user_id', $user_id)->first()->score ?? null;
            $passport_info['all_score']=$result ?? null;
            $passport_info['training_direction']=Training::where('user_id', $user_id)->first()->direction ?? null;
            $passport_info['training_date_end']=Training::where('user_id', $user_id)->first()->date_end ?? null;
            $passport_info['training_date_start']=Training::where('user_id', $user_id)->first()->date_start ?? null;
            $passport_info['education_specialization']=Education::select('specialization')->where('user_id', $user_id)->first() ?? null;
            $passport_info['work_region']= Region::where('id', $region_id)->select(LocaleTrait::convert('name'))->first() ?? null;
            $passport_info['training_region']= Region::where('id', $training_id)->select(LocaleTrait::convert('name'))->first() ?? null;
            $passport_info['education']= Education::where('user_id', $user_id)->get() ?? null;
            $passport_info['work']= Work::where('user_id', $user_id)->get() ?? null;
            $passport_info['training']= Training::where('user_id', $user_id)->get() ?? null;


            $data[] = $passport_info;

            return response()->json([
                'user'=>$data,
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
     * @OA\Get(
     *     path="/api/downloadpdf/{user_id}",
     *     tags={"Evaluate"},
     *     summary="Get all data from evaluate database",
     *     description="Via this link All evaluate` datas come",
     *     operationId="download",
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
     *         description="user_id for check data",
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

    public function download($pdf_id): \Illuminate\Http\JsonResponse
    {
        try {
            $pdf = Check::find($pdf_id)->pdf;
            $file = public_path($pdf);
            $download=Storage::disk('public')->get("storage/$pdf");
            $fileName = time().'.pdf';
            $headers = ['Content-Type: application/pdf'];
//            return response()->download($contents);
            return response()->download($download, $fileName, $headers);
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
