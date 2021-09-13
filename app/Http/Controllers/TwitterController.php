<?php

namespace App\Http\Controllers;

use App\Models\User;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class TwitterController extends Controller
{
    public function loginwithTwitter()
    {
        return Socialite::driver('twitter')->redirect();
    }

    public function cbTwitter()
    {
        try{

            $user = Socialite::driver('twitter')->user();

            $userWhere = User::where('twitter_id', $user->id)->first();

            if ($userWhere) {
                $a = 101;

                Auth::login($userWhere);
                dump($userWhere);

            } else {
                $gitUser = User::create([
                    'name' => $user->name,
                    'email' => is_null($user->email) ? $user->name . '@gmail.com' : $user->email,
                    'twitter_id'=> $user->id,
                    'oauth_type'=> 'twitter',
                    'password' => encrypt('admin595959')
                ]);

                Auth::login($gitUser);

                dump($user);
            }
        } catch (Exception $e) {
            dd($e->getMessage());
        }
    }

    public function getTweetTimeLine()
    {
        $id = Auth::id();
        dd($id);
    }
}