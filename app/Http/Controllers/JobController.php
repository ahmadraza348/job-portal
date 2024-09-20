<?php

namespace App\Http\Controllers;

use App\Models\AllJobs;
use App\Models\JobType;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::where('status', 1)->get();
        $jobtypes = JobType::where('status', 1)->get();
        $jobs = AllJobs::where(['status' => 1]);

        // Search using keywords

        if (!empty($request->keyword)) {
            $jobs = $jobs->where(function ($query) use ($request) {
                $query->orWhere('title', 'like', '%' . $request->keyword . '%');
                $query->orWhere('keywords', 'like', '%' . $request->keyword . '%');
            });
        }
        // Searxh using location
        if (!empty($request->location)) {
            $jobs = $jobs->where('location', $request->location);
        }
        // Searxh using category
        if (!empty($request->category)) {
            $jobs = $jobs->where('category_id', $request->category);
        }
        $jobTypeArray = [];
        // Searxh using Job Type
        if (!empty($request->jobType)) {
            $jobTypeArray = explode(',', $request->jobType);
            $jobs = $jobs->whereIn('job_type_id',  $jobTypeArray);
        }
        // Searxh using experience
        if (!empty($request->experience)) {
            $jobs = $jobs->where('experience', $request->experience);
        }

        $jobs =  $jobs->with(['jobType', 'category']);

        if ($request->sort == 1) {
            $jobs = $jobs->orderBy('created_at', 'ASC');
        } elseif ($request->sort == 0) {
            $jobs = $jobs->orderBy('created_at', 'DESC');
        } else {
            $jobs = $jobs->orderBy('created_at', 'DESC');
        }

        $jobs =  $jobs->paginate(9);

        return view('front.job', [
            'categories' => $categories,
            'jobtypes' => $jobtypes,
            'jobs' => $jobs,
            'jobTypeArray' => $jobTypeArray
        ]);
    }


    public function detail($id)
    {
        $detail = AllJobs::where([
            'id' => $id,
            'status' => 1
        ])->with(['jobType', 'category'])->first();
        return view('front.detail', [
            'detail' => $detail,
        ]);
    }
}
