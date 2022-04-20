<?php

namespace App\Http\Controllers\frontend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserProfileController extends Controller
{

    public function show(Request $request)
    {
        return view('profile.show', [
            'request' => $request,
            'user' => $request->user(),
        ]);
    }

    public function updateProfileInformation(Request $request)
    {
        /* there is a middleware user for this route but to be sure... */
        if ($request->user() != auth()->user()) {
            return redirect()->back()->with('fail', 'Failed to update');
        }
        $imgName = User::get('profile_photo_path');
        $user = User::find(Auth::id());
        if ($user) {
            $image = $request->file('photo');
            if (!($image) && ($request->name == auth()->user()->name) && ($request->email == auth()->user()->email) && !$request->del_photo && ($request->phone == auth()->user()->phone)) {
                return back()->with('fail', 'Nothing to Update');
            }
            if (auth()->user()->profile_photo_path && $request->del_photo) {
                $user->deleteProfilePhoto();
            }
            if ($image) {
                $this->validate($request, [
                    'photo' => 'nullable|mimes:jpg,jpeg,png,bmp,svg,webp|max:1024|unique:users,profile_photo_path,' . $user->id
                ]);
                $user->updateProfilePhoto($request->photo);
            }
            if ($request->name != auth()->user()->name) {
                $request = $request->merge(['name' => trim(strip_tags($request->name))]);
                //dd($request);
                $this->validate($request, ['name' => 'unique:users,name|max:255|min:2'], ['name.unique' => 'This name exists, please choose another one']);
                $user->update([
                    'name' => $request->name
                ]);
            }
            if ($request->email != auth()->user()->email) {
                $prof = "required|max:255|email|unique:users,email," . $user->id;
                $this->validate($request, ['email' => $prof]);
                $user->update([
                    'email' => $request->email
                ]);
            }
            if ($request->phone != auth()->user()->phone) {
                $phone = "nullable|max:255|string|min:9";
                $this->validate($request, ['phone' => $phone]);
                $user->update([
                    'phone' => $request->phone
                ]);
            }
            return redirect()->back()->with('success', 'Profile was successsfully updated');
        } else {
            return redirect()->back()->with('fail', 'Failed to Update');
        }
    }

    public function updatePassword(Request $request)
    {
        /* there is a middleware user for this route but to be sure... */
        if ($request->user() != auth()->user()) {
            return redirect()->back()->with('fail', 'Failed to update');
        }
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed|min:8'
        ]);
        $hashedPassword = Auth::user()->password;
        if (Hash::check($request->current_password, $hashedPassword)) {
            $request->user()->fill([
                'password' => Hash::make($request->password)
            ])->save();
            return redirect()->back()->with('success', 'Password was successsfully updated');
        } else {
            return redirect()->back()->with('fail', 'Failed to update');
        }
    }
}
