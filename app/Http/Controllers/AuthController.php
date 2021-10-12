<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Deployment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use DB;
use Mail;

class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register','notauthenticate']]);
    }

    public function notauthenticate() {
        return response()->json(array('status'=>401,'msg'=>'Authentication failed'), 401);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request){ 

        /*$books = DB::collection('users')->get();
        echo '<pre>'; print_r($books); exit;
        DB::table('users')->insert(array('email'=>'chisdsdsd@gmail.com'));*/    

        // $deployment = new Deployment;
        // $deployment->email= "tako@gmail.com";
        // $deployment->save();
        // die;

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json(['status'=> 422,'error' => $validator->errors()]);
            // return response()->json($validator->errors(), 422);
        }

        if (! $token = auth()->attempt($validator->validated())) {
            // return response()->json(['error' => 'Either email or password is wrong.'], 401);
            return response()->json(['status'=> 401,'error' => 'Either email or password is wrong.']);
        }

        return $this->createNewToken($token);
    }

    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {

        try {
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|between:2,100',
                'email' => 'required|string|email|max:100|unique:admin',
                'password' => 'required|string|min:6',

            ]);

        // if($validator->fails()){
        //      return response()->json($validator->errors(), 400);
        // }

        // $user = User::create(array_merge(
        //             $validator->validated(),
        //             ['password' => bcrypt($request->password)]
        //         ));

        // return response()->json([
        //     'message' => 'User successfully registered',
        //     'user' => $user
        // ], 201);

            if($validator->fails()){
               return response()->json(['status'=> 400,'error' => $validator->errors()]);
           }
           $userIP = getUserIP();
           $user = User::create(array_merge(
            $validator->validated(),
            ['password' => bcrypt($request->password)],
            ['is_admin' => 0],
            ['status' => 0],
            ['userIP' => $userIP]
        ));
        // send mail to user
           if($user != '' && $user != null){
            $data = [
                'id'         => $user->_id,
                'subject'     => "Register Sucessfully",
                'email'       => $request->email,
                'name'        => $request->name,
            ];
            Mail::send('Admin.email_template.register_template', ["mailData" => $data], function ($message) use ($data) {
                $message->to($data['email'])
                ->subject($data['subject']);
            });
        }
        return response()->json([
            'status' => 201,
            'msg' => 'User successfully registered',
            'user' => $user
        ]);    
    } catch (\Exception $e) {
        echo $e->getMessage(); die;
    }
}

public function emailcheck(Request $request){
   $checkemail = [];
   if (count($checkemail) > 0) {
     echo json_encode(FALSE);
 } else {
     echo json_encode(true);
 }
}


    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth()->logout();

        return response()->json(['message' => 'User successfully signed out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth()->refresh());
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth()->user());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createNewToken($token){
        $expirationTime = 60*24*100;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * $expirationTime,
            'user' => auth()->user()
        ]);
    }

}
