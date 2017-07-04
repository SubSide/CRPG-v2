<?php

namespace App\Http\Controllers\Management;

use App\Models\Page;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function pages(){
        return view('management.pages.list', [
            'pages' => Page::all()
        ]);
    }

    public function editPage(Request $request, $page = null){
        try {
            $page = Page::findOrFail($page);
        } catch(ModelNotFoundException $e){
            $page = new Page();
        }

        if(!Auth::check() || Auth::user()->cant('update', $page)){
            return redirect('admin.pages')->with('err', 'Je hebt hier geen rechten voor!');
        }

        if($request->isMethod('get')){
            return view('management.pages.form', compact('page'));
        }


        $page->title = $request->input('title');
        $page->content = $request->input('content');
        if($page->id != 1) {
            $page->logged_in = $request->input('logged_in') ? 1 : 0;
            $page->type = $request->input('type');
        }
        $page->lastEditedBy()->associate(Auth::user());

        $page->save();

        return redirect(route('admin.pages'));
    }
}
