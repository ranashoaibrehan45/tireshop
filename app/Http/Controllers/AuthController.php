<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests\RegisterFormRequest;
use App\Mail\VerifyMail;
use App\Models\User;
use App\Models\VerifyUser;

use App\Repositories\CommonRepository;

use Tymon\JWTAuth\Facades\JWTAuth;
use Auth;
use Log;

class AuthController extends Controller
{
	private $comObj;
	
	public function __construct(CommonRepository $comObj)
    {
        $this->comObj = $comObj;
    }

    public function register(RegisterFormRequest $request)
	{
	    $user = new User;
	    $user->email = $request->input('email');
	    $user->username = $request->input('username');
	    $user->first_name = $request->input('first_name');
	    $user->last_name = $request->input('last_name');
	    $user->password = bcrypt($request->input('password'));

	    if($user->save())
	    {
			$verifyUser = VerifyUser::create([
	            'user_id' => $user->id,
	            'token' => sha1(time())
	        ]);
	    	
			Mail::to($user->email)->send(new VerifyMail($user));

	    	return response([
			        'status' => 'success',
			        'data' => $user
			       ], 200);    
	    }
	    
	}

	public function login(Request $request)
	{
		
		$credentials = $request->only('username', 'password');
    	$token = JWTAuth::attempt($credentials);
	    
	    if (! $token)
	    {
            throw ValidationException::withMessages([
	            $request->email => [trans('auth.failed')],
	        ]);
	    }
	    
	    return response(['status' => 'success'])
	            ->header('Authorization', 'Bearer '.$token);
	}

	public function user(Request $request)
	{
	    $user = User::find(Auth::user()->id);
	    return response()->json([
	            'status' => 'success',
	            'data' => $user
	        ]);
	}

	public function refresh()
	{
	    return response()->json([
	            'status' => 'success'
	        ]);
	}

	public function logout()
	{
		Auth::logout();
	    JWTAuth::invalidate();
	    return response()->json([
	            'status' => 'success',
	            'msg' => 'Logged out Successfully.'
	        ], 200);
	}

	public function updateAccount(Request $request)
	{
		$user = User::where('username', $request->username)->where('password', Hash::make($request->password));
		if($user->count() > 0)
		{
			$request->user()->fill([
				'username' => $request->username_new,
	            'password' => Hash::make($request->password_new)
	        ])->save();
		}
		else
		{
			return response()->json([
	            'status' => 'error',
	            'msg'    => 'Error',
	            'username' => 'Invalid username or password'
	        ], 422);
		}
	}

}
