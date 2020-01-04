<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forum;

class commentController extends Controller
{

    public function index(){
        return view('welcome');

    }

    public function page1(){
        return view('home',['title'=> 'page1',]);
    }

    public function page2(){
        return view('home',['title'=> 'page2',]);
    }

    public function forum($url)
    {
        $comments = Forum::where('url',base64_decode($url))
            ->whereNull('respond_to_id')
            ->paginate(3);
        return $comments;
    }

    public function store()
    {
        request()->validate([
            'name' => ['required'],
            'body' => ['required'],
            'url' => ['required'],
        ]);

        $forum = new Forum();
        $forum->name = request('name');
        $forum->url = request('url');
        $forum->body = request('body');
        $forum->respond_to_id = request('respond_to_id');
        $forum->setRelation('children',collect());

        $forum->save();


        return $forum;
    }

    public function edit(){

        $validatedData = request()->validate([
            'body' => 'required',
            'url' => 'required',
            'name' => 'required',
        ]);

        Forum::whereId(request('id'))->update($validatedData);
        return 'done';
    }

    public function destroy($id)
    {
        Forum::findOrFail(base64_decode($id))->delete();
        Forum::where('respond_to_id',base64_decode($id))->delete();


        return 'done';
    }

}
