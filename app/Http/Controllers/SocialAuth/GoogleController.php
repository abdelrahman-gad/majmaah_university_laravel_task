<?php

namespace App\Http\Controllers\SocialAuth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Laravel\Socialite\Facades\Socialite;


class GoogleController extends Controller
{
   public function login(){
       return Socialite::driver('google')->redirect();
   }

   public function callback(){
       
    try {
        $user = Socialite::driver('google')->user();

        // Check Users Email If Already There
        $is_user = User::where('email', $user->getEmail())->first();
        if(!$is_user){

            $saveUser = User::updateOrCreate([
                'google_id' => $user->getId(),
            ],[
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'password' => Hash::make($user->getName().'@'.$user->getId())
            ]);
        }else{
            $saveUser = User::where('email',  $user->getEmail())->update([
                'google_id' => $user->getId(),
            ]);
            $saveUser = User::where('email', $user->getEmail())->first();
        }


        Auth::loginUsingId($saveUser->id);
        
        return redirect()->route('home');
    } catch (\Throwable $th) {
        throw $th;
    }

   }

}
