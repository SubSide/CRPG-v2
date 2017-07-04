<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PageController extends Controller
{
    public function page($page){
        try {
            $page = Page::where('id', $page);
            
            if(!Auth::check())
                $page->where('logged_in', 0);

            $page = $page->firstOrFail();
        } catch(ModelNotFoundException $e){
            return redirect('/');
        }

        return view('page', compact('page'));
    }
}
