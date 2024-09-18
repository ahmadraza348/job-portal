<?php

namespace App\Http\Controllers;

use App\Models\AllJobs;
use App\Models\User;
use App\Models\Category;
use App\Models\JobType;
use Hamcrest\Core\AllOf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Util\PHP\Job;

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

    public function createJob()
    {
        $categories = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $jobTypes = JobType::orderBy('name', 'ASC')->where('status', 1)->get();
        return view('front.account.job.create', [
            'categories' => $categories,
            'jobTypes' => $jobTypes,
        ]);
    }

    public function saveJob(Request $request)
    {
        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|max:75|min:3',
            'experience' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $data = new AllJobs();
            $data->title  = $request->title;
            $data->category_id  = $request->category;
            $data->job_type_id  = $request->jobType;
            $data->user_id  = Auth::user()->id;
            $data->vacancy  = $request->vacancy;
            $data->salary  = $request->salary;
            $data->location  = $request->location;
            $data->description  = $request->description;
            $data->benefits  = $request->benefits;
            $data->responsibility  = $request->responsibility;
            $data->qualifications  = $request->qualifications;
            $data->keywords  = $request->keywords;
            $data->experience  = $request->experience;
            $data->company_name  = $request->company_name;
            $data->company_location  = $request->company_location;
            $data->company_website  = $request->company_website;

            $data->save();
            Session()->flash('success', 'Job posted successfully.');
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


    public function myJobs()
    {
        $jobs = AllJobs::where('user_id', Auth::user()->id)->with('jobType')->paginate(10);
        return view('front.account.job.myjobs', [
            'jobs' => $jobs
        ]);
    }
    public function editJob($jobid)
    {
        $data['categories'] = Category::orderBy('name', 'ASC')->where('status', 1)->get();
        $data['jobTypes'] = JobType::orderBy('name', 'ASC')->where('status', 1)->get();

        $data['job'] = AllJobs::where([
            'id' => $jobid,
            'user_id' => Auth::user()->id,
        ])->first();
        if ($data['job'] == null) {
            abort(404);
        }
        return view('front.account.job.edit', $data);
    }

    public function updateJob(Request $request, $id)
    {
        $rules = [
            'title' => 'required|min:5|max:200',
            'category' => 'required',
            'jobType' => 'required',
            'vacancy' => 'required|integer',
            'location' => 'required|max:50',
            'description' => 'required',
            'company_name' => 'required|max:75|min:3',
            'experience' => 'required',
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->passes()) {
            $data = AllJobs::find($id);
            $data->title  = $request->title;
            $data->category_id  = $request->category;
            $data->job_type_id  = $request->jobType;
            $data->user_id  = Auth::user()->id;
            $data->vacancy  = $request->vacancy;
            $data->salary  = $request->salary;
            $data->location  = $request->location;
            $data->description  = $request->description;
            $data->benefits  = $request->benefits;
            $data->responsibility  = $request->responsibility;
            $data->qualifications  = $request->qualifications;
            $data->keywords  = $request->keywords;
            $data->experience  = $request->experience;
            $data->company_name  = $request->company_name;
            $data->company_location  = $request->company_location;
            $data->company_website  = $request->company_website;

            $data->save();
            Session()->flash('success', 'Job Updated successfully.');
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

    public function deleteJob(Request $request)
    {
        $job = AllJobs::where([
            'user_id' => Auth::user()->id,
            'id' => $request->jobId
        ])->first();
    
        if ($job == null) {
            return response()->json([
                'status' => false,
                'error' => 'Job not found or already deleted'
            ]);
        }
    
        $job->delete();
            return response()->json([
            'status' => true,
            'success' => 'Job deleted successfully'
        ]);
    }
    
}
