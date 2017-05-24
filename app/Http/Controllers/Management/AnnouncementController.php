<?php

namespace App\Http\Controllers\Management;

use App\Http\Controllers\Controller;
use App\Models\AccessLevel;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    public function show($id){
        try {
            $announcement = Announcement::findOrFail($id);
            return view('announcement', compact('announcement'));
        } catch(ModelNotFoundException $e){
            return redirect(route('home'));
        }
    }

    public function showAdminList(){
        if(!Auth::check() || !Auth::user()->hasPermission(AccessLevel::ADMIN))
            return redirect('home');

        $announcements = Announcement::orderBy('date_posted', 'DESC')->get();
        return view('management.announcement.adminlist', compact('announcements'));
    }

    public function create(Request $request){
        if(!Auth::check() || !Auth::user()->hasPermission(AccessLevel::ADMIN))
            return redirect(route('home'));

        if($request->isMethod('get'))
            return view('management.announcement.create');

        $announcement = new Announcement();
        $announcement->title = $request->input('title');
        $announcement->content = $request->input('content');
        $announcement->date_posted = date('Y-m-d H:i:s', time());
        $announcement->user()->associate(Auth::user());

        $announcement->save();

        return redirect(route('admin.announcements'));
    }

    public function edit(Request $request, $id){
        if(!Auth::check() || !Auth::user()->hasPermission(AccessLevel::ADMIN))
            return redirect(route('home'));

        try {
            $announcement = Announcement::findOrFail($id);
        } catch(ModelNotFoundException $e){
            return redirect(route('admin.announcements'));
        }

        if($request->isMethod('get'))
            return view('management.announcement.edit', ['announcement' => $announcement]);

        $announcement->title = $request->input('title');
        $announcement->content = $request->input('content');
        $announcement->save();

        return redirect(route('admin.announcements'));
    }


    public function delete(Request $request, $id){
        if(!Auth::check() || !Auth::user()->hasPermission(AccessLevel::ADMIN)){
            return redirect(route('announcements'))->with('err', 'Je hebt hier geen rechten voor!');
        }

        try {
            $announcement = Announcement::findOrFail($id);
        } catch(ModelNotFoundException $e){
            return redirect(route('admin.announcements'));
        }

        if($request->isMethod('get')){
            return view('management.announcement.delete', compact('announcement'));
        }

        $announcement->delete();
        return redirect(route('admin.announcements'));
    }
}
