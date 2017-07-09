<?php

namespace App\Http\Controllers\Me;

use App\Http\Controllers\Controller;
use App\Models\Character;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyCharactersController extends Controller
{

    public function viewList(){
        if(!Auth::check()){
            return redirect(route('home'));
        }

        $characters = Auth::user()->characters()->get();
        return view('me.characters.mylist', compact(['characters']));
    }


    public function show($id){
        try {
            $character = Character::findOrFail($id);
            return view('me.characters.view', compact('character'));
        } catch(ModelNotFoundException $e){
            return redirect(route('home'));
        }
    }


    public function create(Request $request){
        if(!Auth::check()){
            return redirect(route('home'));
        }

        if($request->isMethod('get')){
            return view('me.characters.create');
        }

        $this->validate($request, [
            'name' => 'required|max:32',
            'class' => 'required|max:32',
            'gametype' => 'required|max:32',
            'level' => 'required|numeric|min:1|max:'.(Character::getMaxLevel(Auth::user()->xpLeft())),
            'story' => 'nullable|max:1024',
        ]);


        $name = strip_tags($request->input('name'));
        $class = strip_tags($request->input('class'));
        $gametype = strip_tags($request->input('gametype'));
        $level = intval($request->input('level'));
        $story = $request->input('story');

        $character = new Character();
        $character->name = $name;
        $character->class = $class;
        $character->gametype = $gametype;
        $character->level = $level;
        $character->story = $story;

        $character->user()->associate(Auth::user());
        $character->save();

        return redirect($character->getTitleUrl());
    }


    public function edit(Request $request, $id){
        if(!Auth::check()){
            return redirect(route('home'));
        }

        try {
            $character = Character::findOrFail($id);
            $user = $character->user;
        } catch(ModelNotFoundException $e){
            return redirect(route('characters'));
        }

        if(!Auth::check() || Auth::user()->cant('update', $character)){
            return redirect($character->getTitleUrl())->with('err', 'Je hebt hier geen rechten voor!');
        }


        if($request->isMethod('get')){
            return view('me.characters.edit', compact('character'));
        }

        $this->validate($request, [
            'name' => 'required|max:32',
            'class' => 'required|max:32',
            'gametype' => 'required|max:32',
            'level' => 'required|numeric|min:1|max:'.Character::getMaxLevel($user->xpLeft() + Character::getLevelXp($character->level)),
            'story' => 'nullable|max:1024',
        ]);


        $name = strip_tags($request->input('name'));
        $class = strip_tags($request->input('class'));
        $gametype = strip_tags($request->input('gametype'));
        $level = intval($request->input('level'));
        $story = $request->input('story');

        $character->name = $name;
        $character->class = $class;
        $character->gametype = $gametype;
        $character->level = $level;
        $character->story = $story;
        $character->save();

        return redirect($character->getTitleUrl());
    }

    public function delete(Request $request, $id){
        try {
            $character = Character::findOrFail($id);
        } catch(ModelNotFoundException $e){
            return redirect(route('characters'));
        }

        if(!Auth::check() || Auth::user()->cant('delete', $character)){
            return redirect($character->getTitleUrl())->with('err', 'Je hebt hier geen rechten voor!');
        }

        if($request->isMethod('get')){
            return view('me.characters.delete', compact('character'));
        }

        $character->delete();
        return redirect(route('characters'));
    }

}
