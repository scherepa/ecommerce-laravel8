<?php

namespace App\Http\Controllers\backend;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{

    public function show(Request $request)
    {
        return view('admin.admin_profile_view', [
            'request' => $request,
            'user' => $request->user(),
        ]);
    }

    public function updateProfileInformation(Request $request)
    {
        /* there is a middleware admin for this route but to be sure... */
        if ($request->user() != auth()->user()) {
            return redirect()->back()->with('fail', 'Failed to update');
        }
        $imgName = Admin::get('profile_photo_path');
        $user = Admin::find(Auth::id());
        if ($user) {
            $image = $request->file('photo');
            if (!($image) && ($request->name == auth()->user()->name) && ($request->email == auth()->user()->email) && !$request->del_photo) {
                return back()->with('fail', 'Nothing to Update');
            }
            if (auth()->user()->profile_photo_path && $request->del_photo) {
                unlink('storage/' . $user->profile_photo_path);
                $user->forceFill([
                    'profile_photo_path' => NULL
                ])->save();
            }
            if ($image) {
                $this->validate($request, [
                    'photo' => 'nullable|mimes:jpg,jpeg,png,bmp,svg,webp|max:1024|unique:admins,profile_photo_path,' . $user->id
                ]);
                //$user->updateProfilePhoto($request->photo);
                $previmage = $user->profile_photo_path;
                $ext = strtolower($image->getClientOriginalExtension());
                do {
                    $name_gen = hexdec(uniqid());
                    $img = $name_gen . '.' . $ext;
                    $location = 'admin-profile-photos/';
                    $last_img = $location . $img;
                } while ($imgName->contains($last_img));
                if ($previmage) {
                    unlink('storage/' . $previmage);
                }
                $image->move('storage/' . $location, $img);
                $user->forceFill([
                    'profile_photo_path' => $last_img,
                ])->save();
            }
            if ($request->name != auth()->user()->name) {
                $request = $request->merge(['name' => trim(strip_tags($request->name))]);
                //dd($request);
                $this->validate($request, ['name' => 'unique:admins,name|max:255|min:2'], ['name.unique' => 'This name exists, please choose another one']);
                $user->update([
                    'name' => $request->name
                ]);
            }
            if ($request->email != auth()->user()->email) {
                $prof = "required|max:255|email|unique:admins,email," . $user->id;
                $this->validate($request, ['email' => $prof]);
                $user->update([
                    'email' => $request->email
                ]);
            }
            return redirect()->back()->with('success', 'Profile was successsfully updated');
        } else {
            return redirect()->back()->with('fail', 'Failed to Update');
        }
    }

    public function updatePassword(Request $request)
    {
        /* there is a middleware admin for this route but to be sure... */
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
