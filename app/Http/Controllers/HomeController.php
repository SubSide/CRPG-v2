<?php

namespace App\Http\Controllers;

use App\Models\Announcement;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $announcements = Announcement::orderBy('date_posted', 'DESC')->get();
        return view('home', compact('announcements'));
    }
}
