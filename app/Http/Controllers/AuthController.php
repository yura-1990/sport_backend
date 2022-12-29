<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginUserRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\Pasport;
use App\Models\PersonalInfo;
use App\Models\User;
use App\Models\PasswordReset;
use App\Services\NotificationService;
use Carbon\Carbon;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login','register','editAuth','updateAuth','forgotPassword','resetPasswordLoad','resetPassword',]]);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Auth"},
     *     summary="Login the user",
     *     operationId="login",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *      @OA\RequestBody(
     *          description="Input data format",
     *          @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="login",
     *                     description="Type your login to enter",
     *                     type="string",
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="Enter you password",
     *                     type="string"
     *                 )
     *             )
     *         )
     *      ),
     *      @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *      ),
     * )
     *
    */

    public function login(LoginUserRequest $request)
    {
        $request->validated();
        $credentials = $request->only('login', 'password');

        $token = JWTAuth::attempt($credentials);

        if (!$token){
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized',
            ], 401);
        }

        $user = Auth::user();

        return response()->json([
            'status' => 'ok',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }

    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Auth"},
     *     summary="Register a user",
     *     operationId="register",
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
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="login",
     *                     description="Type your login",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     description="Type your password",
     *                     type="password"
     *                 ),
     *                 @OA\Property(
     *                     property="fillial_id",
     *                     description="Type your Fillial",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="pasport_id",
     *                     description="Type your Pasport",
     *                     type="integer"
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

    public function register(RegisterUserRequest $request, NotificationService $service)
    {
        $request->validated();

        $user = User::create([
            'login' => $request->login,
            'password' => Hash::make($request->password),
            'role_id' => '3',
            'fillial_id' => $request->fillial_id,
            'pasport_id' => $request->pasport_id
        ]);

        $service->create('User created', $user, [1]);

        $token = JWTAuth::attempt([
            'login'=>$request->login,
            'password'=>$request->password
        ]);

        return response()->json([
            'status' => 'ok',
            'message' => 'User created successfully',
            'user' => $user,
            'authorisation' => [
                'token' => $token,
                'type' => 'bearer',
            ]
        ]);
    }



    public function logout()
    {
        Auth::logout();
        return response()->json([
            'status' => 'ok',
            'message' => 'Successfully logged out',
        ]);
    }

    /**
     * @param $pnfl
     * @return \Illuminate\Http\JsonResponse
     */


    public function editAuth($pnfl){
        $pasport_id = Pasport::where('pnfl', $pnfl)->first()->id;
        $user = User::where('pasport_id', $pasport_id)->get();

        return response()->json([
            'user'=>$user
        ]);
    }


    public function refresh()
    {
        return response()->json([
            'status' => 'ok',
            'user' => Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }


    // forget password api method

    /**
     * @OA\Put(
     *     path="/api/forgot-password/{pnfl}",
     *     tags={"Auth"},
     *     summary="If you forgot password",
     *     description="Change you password with your email",
     *     @OA\Parameter(
     *         name="Accept-Language",
     *         in="header",
     *         description="Set language parameter by typing uz, ru, en",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="pnfl",
     *         in="path",
     *         description="pnfl for resent password",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         description="Input data format",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 type="object",
     *                 @OA\Property(
     *                     property="password",
     *                     description="Type your pasport seria",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password_confirmation",
     *                     description="Type your pasport seria code",
     *                     type="integer"
     *                 ),
     *             )
     *         )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *     ),
     * )
     */



    public function forgotPassword(UpdateUserRequest $request, $pnfl): \Illuminate\Http\JsonResponse
    {

        try {
            $passport = Pasport::where('pnfl', $pnfl)->first()->id ?? null;
            $request->validated();

            if($passport){
                $user = User::where('pasport_id', $passport)->first();
                $user->password = Hash::make($request->password);
                $user->save();
                return response()->json([
                    'success' => true,
                    'message' => $user
                ]);
            }else {
                return response()->json([
                    'message' => __('your pnfl is not match with the entering data')
                ]);
            }

            /*$email = PersonalInfo::where('email', $request->email)->get();
            if (count($email) > 0){
                $token =  Str::random(40);
                $domain = URL::to('/');
                $url =  $domain . '/api/reset-password?token=' . $token;

                $data['url']=$url;
                $data['email']=$request->email;
                $data['title']='Password reset';
                $data['body']='Please check on below to reset your password.';

                Mail::send('forgetPasswordMail',['data'=>$data], function ($message) use ($data){
                    $message->to($data['email'])->subject($data['title']);
                });

                $dateTime=Carbon::now()->format('Y-m-d H:i:s');
                PasswordReset::updateOrCreate(
                    ['email'=>$request->email],
                    [
                        'email' => $request->email,
                        'token' => $token,
                        'created_at' => $dateTime
                    ]
                );

                return response()->json([
                    'success'=>true,
                    'message'=>'Please check your email to reset your password.'
                ]);

            }else{
                return response()->json([
                    'success'=>false,
                    'message'=>'User is not found'
                ]);
            }*/

        } catch (\Exception $exception ){
            return response()->json([
                'success'=>false,
                'message'=>$exception->getMessage()
            ]);
        }
    }

    public function resetPasswordLoad(Request $request): \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Contracts\Foundation\Application
    {

        $resetData = PasswordReset::where('token', $request->token)->get();
        if (isset($resetData[0]->token) && count($resetData)>0 ){

            $userID = PersonalInfo::where('email', $resetData[0]['email'])->first()->user_id;

            $user = User::where('id', $userID)->get();

            return view('resetPassword', compact('user'));

        } else{
            return view('404');
        }
    }


    public function resetPassword(Request $request): string
    {
        $request->validate([
            'password'=>'required|string|min:6|confirmed'
        ]);

        $user = User::find($request->id);
        $user->password = Hash::make($request->password);
        $user->save();
        $email = PersonalInfo::where('user_id', $request->id)->first()->email;
        PasswordReset::where('email', $email)->delete();

        return "<h1>Your password has been reset successfully </h1>";
    }


}
