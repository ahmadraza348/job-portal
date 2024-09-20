<?php

namespace App\Http\Controllers;

use App\Models\AllJobs;
use App\Models\JobType;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
    public function index()
    {
        $data['categories'] = Category::where('status' , 1)->get();
        $data['jobtypes'] = JobType::where('status' , 1)->get();
        $data['jobs'] = AllJobs::where(['status'=> 1])->with('jobType')->orderBy('created_at' , 'DESC')->paginate(9);

        return view('front.job', $data);
    }
}
