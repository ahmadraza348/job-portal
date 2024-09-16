<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AccountController extends Controller
{
    public function registration()
    {
        return view('front.account.registration');
    }

    public function process_registration(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required',
        ]);

        if ($validator->passes()) {
            $user = new User();
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);

            $user->save();

            Session()->flash('success', 'You have registered successfully.');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }

    public function login()
    {
        return view('front.account.login');
    }

    public function authenticate(request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',

        ]);
        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('account.profile');
            } else {
                return redirect()->route('account.login')->with('error', 'Either Email or Password is incorrect')->withInput($request->only('email'));
            }
        } else {
            return redirect()->route('account.login')->withErrors($validator)->withInput($request->only('email'));
        }
    }

    public function profile()
    {
        $id = Auth::user()->id;
        $data['user'] = User::where('id', $id)->first();

        return view('front.account.profile', $data);
    }

    public function updateProfile(Request $request)
    {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:5|max:25',
            'email' => 'required|email|unique:users,email,' . $id . ',id'
        ]);
        if ($validator->passes()) {
            $user = User::find($id);
            $user->name = $request->name;
            $user->email = $request->email;
            $user->mobile = $request->mobile;
            $user->designation = $request->designation;

            $user->save();
            Session()->flash('success', 'Profile updated successfully.');
            return response()->json([
                'status' => true,
                'errors' => []
            ]);
        } else {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('account.login')->with('success', 'You are logged out successfully');
    }

    public function updateProfilePic(Request $request)
    {
        $id = Auth::user()->id;
        $validator = Validator::make($request->all(), [
            'image' => 'required|image'
        ]);

        if ($validator->passes()) {
            try {
                $image = $request->file('image');  // Ensure you use the `file()` method for the image input
                $ext = $image->getClientOriginalExtension();
                $imageName = $id . '-' . time() . '.' . $ext;  // Added a dot before extension for a valid filename
                $image->move(public_path('profile_pic'), $imageName);  // Simplified the path

                User::where('id', $id)->update(['image' => $imageName]);
                Session()->flash('success', 'Profile Picture Updated successfully.');
                return response()->json([
                    'status' => true,
                    'message' => 'Profile Picture updated successfully.',
                    'errors' => []
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'An error occurred while updating the profile picture.',
                    'errors' => [$e->getMessage()]
                ]);
            }
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed.',
                'errors' => $validator->errors()->all()
            ]);
        }
    }

    public function createJob(){
        return view('front.account.job.create');
    }
}
