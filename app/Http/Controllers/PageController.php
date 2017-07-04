<?php

namespace App\Http\Controllers;

use App\Models\Page;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function page($page){
        try {
            $page = Page::findOrFail($page);
        } catch(ModelNotFoundException $e){
            return redirect('/');
        }

        return view('page', compact('page'));
    }
}
