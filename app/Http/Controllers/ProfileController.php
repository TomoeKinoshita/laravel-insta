<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    //
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function show($id){
        $user_a = $this->user->findOrFail($id);  // get the data of the user

        return view('user.profile.show')
                ->with('user', $user_a);  // pass tha data
    }

    public function edit(){  // since we already know that we will edit the logged-in user, we don't need $id here.
        return view('user.profile.edit');  // findOrFailを使うこともできるが、
    }

    public function update(Request $request){

        // validation
        $request->validate([
            'avatar' => 'max:1048|mimes:jpeg,jpg,png,gif',  // not required
            'name' => 'required|max:50',
            'introduction' => 'max:100',  // not required
            'email' => 'required|max:50|email|unique:users,email,'.Auth::user()->id
                // "|email|" is just check if it's email format

                // "email" has unique key on users table.
                // (ex.) users,email,1 | [table name], [column name], [id]
                // use exception (id) when updating, but not when creating new record
                // (when creating -> unique:users,email)
        ]);

        // ACTIVITY: update profile
        // 1. finish validation (validation in view. adding error messages)
        // 2. update profile
        //  - avatar - image convert to longtext
        // 3. after updating, redirect to profile page (show profile)

        $user_a = $this->user->findOrFail(Auth::user()->id);

        if($request->avatar){  // if form has submitted new avatar
            $user_a->avatar = 'data:image/'.$request->avatar->extension().';base64,'.base64_encode(file_get_contents($request->avatar));
        };

        $user_a->name = $request->name;
        $user_a->email = $request->email;
        $user_a->introduction = $request->introduction;

        $user_a->save();

        return redirect()->route('profile.show', Auth::user()->id);
    }

    public function following($id){  // user id. profileページで必要になるid（URLに表示されるもの。例:profile/2/following）
        $user_a = $this->user->findOrFail($id);

        return view('user.profile.following')->with('user', $user_a);
            // 'user' is variable in header.blade, need to match
    }

    public function followers($id){
        $user_b = $this->user->findOrFail($id);

        return view('user.profile.followers')->with('user', $user_b);
    }


    public function updatePassword(Request $request){

        // for validation (1) and (2) below, we cannot use normal validation.
        // for validation (3) below, we can use normal/regular Laravel validation.

        // * (1) That is not your current password.
        $user_a = $this->user->findOrFail(Auth::user()->id);
        if(!Hash::check($request->old_password, $user_a->password)){
            // if not current password
            // we cannot use "==" b/c our passwords are incripted in database

            // send error message
            return redirect()->back()->with('incorrect_password_error', 'That is not your current password.');
                                    // ->withは、viewでのpassing dataの使い方と同様
                // when we have validation, what happens is that it goes back to the same page, and it shows the error message.

                // Normally when we have "->with" in function, we can already use the valiable in '  ', for example 'user' in "->with('user', $user_a)". But if we try to write the code {{ $incorrect_password_error }} in edit.blade.php, we got an error of "Undefined variable $incorrect_password_error". This is b/c profile edit actually calls "public function edit" (return view('user.profile.edit')). This is the function that opens the edit view, and it does not have the variable "$incorrect_password_error", so it's goiing to get an error.
        }

        // * (2) New password cannot be the same as current password.
        if($request->old_password == $request->new_password){
            // checks that the password is the same.
            // we can use == b/c just to compare. both values are from the form

            // send error message
            return redirect()->back()->with('same_password_error', 'New password cannot be the same as current password.');
        }

        // * (3) New password does not match
        // for this validation, normal/regular Laravel validation
        $request->validate([

            'new_password' => 'required|string|min:8|confirmed'
            // confirmed - checks if the passwords match.
            // "true" in validation will only work if... to confirm, in the form you need 2 inputs with similar names (x and x_confirmation)

            // 'new_password' above, which is the 'name' of the <input>, is from the first <input>. The name here in the validation should match the first <input>.

            // to confirm, you need the second <input> with name ('new_password_confirmation'). It's required that you have this kind of name.
            // naming of the name of <input>: name of the first <input> + "_confirmation"
        ]);

        $user_a->password = Hash::make($request->new_password);
                            // Hash to encode the password
        $user_a->save();

        // success message
        return redirect()->back()->with('password_change_success', 'Changed password successfully!');
    }
}
