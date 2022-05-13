<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function profile()
    {
        return view('profile');
    }

    public function profileUpdate(Request $request)
    {
        $this->validate($request, [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.auth()->user()->id ],
        ]);

        User::where("id", auth()->user()->id)->update([
            "firstname" => $request->firstname,
            "lastname" => $request->lastname,
            "email" => $request->email
        ]);

        return redirect()->back()->with("details_success", "Profile details has been updated successfully.");
    }

    public function passwordUpdate(Request $request)
    {
        $this->validate($request, [
            'old_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if(Hash::check($request->old_password, auth()->user()->password)) {
            if($request->old_password == $request->password) {
                return redirect()->back()->with("password", "New password and old password must be different.")->withInput();
            }
            User::where("id", auth()->user()->id)->update([
                "password" => Hash::make($request->password)
            ]);
            return redirect()->back()->with("password_success", "Password has been updated successfully.");
        } else {
            return redirect()->back()->with("old_password", "Old password does not match with current password.")->withInput();
        }
    }
}
