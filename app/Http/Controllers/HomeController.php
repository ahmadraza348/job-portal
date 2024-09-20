<?php

namespace App\Http\Controllers;

use App\Models\AllJobs;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    // Home Page
    public function index()
    {
        $data['category'] = Category::where('status', 1)->orderBy('name' , 'ASC')->take(8)->get();
        $data['featured_job'] = AllJobs::where(['status'=> 1, 'isFeatured' =>1])->with('jobType')->orderBy('created_at' , 'DESC')->take(6)->get();
        $data['latest_job'] = AllJobs::where(['status'=> 1])->with('jobType')->orderBy('created_at' , 'DESC')->take(6)->get();

        return view('front.home', $data);
    }
}
