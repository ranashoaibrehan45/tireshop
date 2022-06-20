<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

use Illuminate\Http\Request;
use Socialite;
use Log;
use Auth;

class SocialMediaController extends Controller
{
	public function redirectToFacebook(Request $request)
    {	
    	Log::info("redirectToFacebook");
		return Socialite::driver('facebook')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleFacebookCallback()
    {
		Log::info("handleFacebookCallback");
        $user = Socialite::driver('facebook')->user();
		Log::info("Facebook User: " . print_r($user, true));
		
		$redirectURL = url('/home');
		
		if($user)
		{
			if($user->email!='')
			{
				if($authUser = User::where('fb_id', $user->id)->orWhere('email',$user->email)->first()) {
					Auth::login($authUser, true);
					return redirect($redirectURL);
				}
				
				$authUser = $this->createFacebookUser($user);
				Auth::login($authUser, true);
			}
			
			elseif ($authUser = User::where('fb_id', $user->id)->first())
			{
				Auth::login($authUser, true);
			}
			else{
				$authUser = $this->createFacebookUser($user);
				Auth::login($authUser, true);
			}
			
			return redirect($redirectURL);
		}
    }
	
	private function createFacebookUser($user)
    {
		Log::info("createFacebookUser");
		Log::info("Token length: " . strlen($user->token));
		list($firstname, $lastname) = explode(' ',$user->name);
		
		$userObj = new User();
		$userObj->first_name = $firstname;
		$userObj->last_name = $lastname;
		$userObj->email = $user->email;
		$userObj->fb_id = $user->id;
		$userObj->fb_avatar = $user->avatar;

		$userObj->verified = '1';
		
		if($userObj->save())
		{
			return $userObj;
		}
	}
	
	/*	Google sign up	*/
	public function redirectToGoogle(Request $request)
    {
		Log::info("redirectToGoogle");
		return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleGoogleCallback()
    {
		Log::info("handleGoogleCallback");
        $user = Socialite::driver('google')->stateless()->user();
		Log::info("Google User: " . print_r($user, true));
		
		$authUser = User::where('google_id', $user->id)->orWhere('email',$user->email)->first();
		
		if($authUser){
			Auth::login($authUser, true);
		}
		else{
			$authUser = $this->createGoogleUser($user);
			Auth::login($authUser, true);
		}
		
		$redirectURL = url('home');
		
		return redirect($redirectURL);
	}
	
	private function createGoogleUser($user)
    {
		Log::info("createGoogleUser");
		Log::info("Token length: " . strlen($user->token));
		
		list($firstname, $lastname) = explode(' ',$user->name);
		
		$userObj = new User();
		$userObj->first_name = $firstname;
		$userObj->last_name = $lastname;
		$userObj->email = $user->email;
		$userObj->google_id = $user->id;
		$userObj->google_avatar = $user->avatar;
		$userObj->verified = true;
		
		if($userObj->save())
		{
			return $userObj;
		}
    }
	
	
	
}
