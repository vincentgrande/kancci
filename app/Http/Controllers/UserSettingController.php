<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;
use Illuminate\Support\Str;

class UserSettingController extends Controller
{
    /**
     * Function to get auth.forgot-password View
     * @return Application|Factory|View
     */
    public function showForgetPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Function to send Mail to the User when he forgot his password
     * @param Request $request
     * @return RedirectResponse()
     */
    public function submitForgetPasswordForm(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        Mail::send('email.forgetPassword', ['token' => $token], function($message) use($request){
            $message->to($request->email);
            $message->subject('Reset Password');
        });

        return back()->with('message', 'We have e-mailed your password reset link!');
    }
    /**
     * Function to see the auth.forgetPasswordLink View
     * @param $token
     * @return Application|Factory|View
     */
    public function showResetPasswordForm($token) {
        return view('auth.forgetPasswordLink', ['token' => $token]);
    }

    /**
     * Function to change User's password with email
     * @param Request $request
     * @return RedirectResponse()
     */
    public function submitResetPasswordForm(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
                            ->where([
                            'email' => $request->email,
                            'token' => $request->token
                            ])
                            ->first();

        if(!$updatePassword){
            return back()->withInput()->with('error', 'Invalid token!');
        }

        $user = User::where('email', $request->email)
                    ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email'=> $request->email])->delete();

        return redirect('/login')->with('message', 'Your password has been changed!');
    }

    /**
     * Function to change the password of the User with old password confirmation
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function changePassword(Request $request) : Redirector
    {
        try {
            $request->validate([
                'actualPassword' => 'required|string|min:8',
                'newPassword' => 'required_with:confirmNewPassword|same:confirmNewPassword|string|min:8',
                'confirmNewPassword' => 'min:8'
            ]);
            $user = User::where(['id' => Auth::user()->id])->first();
            $actualPassword = $request->actualPassword;
            $newPassword = $request->newPassword;
            $confirmNewPassword = $request->confirmNewPassword;
            if (Hash::check($actualPassword, $user->password)) {
                if ($newPassword == $confirmNewPassword) {
                    $user->update(['password' => Hash::make($newPassword)]);
                    return redirect(route('settingsSecurityGet'))->with('message', 'Your password has been changed!');
                } else {
                    return redirect(route('settingsSecurityGet'))->with('error', 'Your both password wasn\'t the same.');;
                }
            } else {
                return redirect(route('settingsSecurityGet'))->with('error', 'Your must enter your current password.');;
            }
        }
        catch(\Exception $exception)
        {
            return redirect(route('settingsSecurityGet'))->with('error', 'Change Password  Failed...'.'    '.$exception->getMessage());
        }
    }

    /**
     * Function to Upload an change the User Profile Picture
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function changePicture(Request $request)
    {
        try {
            // Validation de la photo
            $request->validate([

                'image' => 'required|image|mimes:jpeg,png,jpg,svg|max:2048',

            ]);
            $user = User::where(['id' => Auth::user()->id])->first();

            // Si la photo actuel n'est pas la photo par défaut on la supprime du serveur
            if($user->picture != 'undraw_profile.svg' | $user->picture == '') {
                unlink(public_path('img/' . $user->picture));
            }
            // Enregistrement de la photo sur le serveur avec un Hash pour garantir l'unicité du nom
            $filename = Hash::make($request->image->hashName());
            $filename = str_replace('/', 'l', $filename);
            $filename = str_replace('.', 'i', $filename);
            $imageName = $filename.'.'. $request->image->extension();
            $request->image->move(public_path('img/uploaded'), $imageName);

            // Mise à jour du lien vers la photo pour l'utilisateur
            User::where(['id' => Auth::user()->id])->update(['picture' => 'uploaded/' . $imageName]);

            return redirect(route('settingsProfileGet'))->with('message', 'Your picture have been changed successfully !');
        }
        catch(\Exception $exception)
        {
            return redirect(route('settingsProfileGet'))->with('error', 'Upload Failed...'.'    '.$exception->getMessage());
        }
    }

    /**
     * Function to change the Email adresse from the User
     * @param Request $request
     * @return Application|RedirectResponse
     */
    public function changeEmail(Request $request)
    {
        try {
            $request->validate([

                'mail' => 'required|email',

            ]);
            $user = User::where(['id' => Auth::user()->id])->first();
            $user->update(['email' => $request->mail]);
            return redirect(route('settingsEmailGet'))->with('message', 'Your E-mail have been changed successfully !');
        }
        catch (\Exception $ex)
        {
            return redirect(route('settingsEmailGet'))->with('error', 'An error occurred.');
        }
    }
}
