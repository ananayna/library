<?php

namespace App\Http\Controllers;

use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
     //Author index Page
     public function index(){
        $authors = Author::latest()->get();
        return view('admin.author', compact('authors'));
    }

    //Author store Page
    public function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:300',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,webp'
        ]);

        $author_slug = str($request->name)->slug();
        $slug_count = Author::where('slug','LIKE', '%'.$author_slug.'%')->count();
        if($slug_count > 0){
            $author_slug .= '-' . $slug_count + 1 ;
        }

        if($request->hasFile('image')){
            $image = str()->random(5).time().'.'.$request->image->extension();
            $request->image->storeAs('Author',$image, 'public');
        }

        $author = new Author();

        $author->name = $request->name;
        $author->slug = $author_slug;
        $author->image = isset($image) ? $image : $author->image;
        $author->message = $request->message;
        $author->save();

        return back();
    }

    Public function edit($id){
        $authors = Author::paginate(6);
        $editData = Author::find($id, ['id','name','message']);
        return view('admin.author', compact('authors', 'editData'));
        }

        public function update(Request $request, $id){
            $request->validate([
                'name' => 'required|string|max:255',
                'message' => 'required|string|max:300',
                'image' => 'nullable|image|mimes:jpg,png,jpeg,webp'
            ]);

            $author_slug = str($request->name)->slug();
            $slug_count = Author::where('slug','LIKE', '%'.$author_slug.'%')->count();
            if($slug_count > 0){
                $author_slug .= '-' . $slug_count + 1 ;
            }

            if($request->hasFile('image')){
                $image = str()->random(5).time().'.'.$request->image->extension();
                $request->image->storeAs('Author',$image, 'public');
            }

            $author = Author::find($id);

            $author->name = $request->name;
            $author->slug = $author_slug;
            $author->image = isset($image) ? $image : $author->image;
            $author->message = $request->message;
            $author->save();

            return back();
        }

        Public function delete($id){
            $author = Author::find($id);
            $author->delete();
            return back();
        }

    public function change_status(Request $request){
        $author = Author::find($request->author_id);
        if($author->status){
            $author->status = false;
        }else{
            $author->status = true;
        }
        $author->save();
    }
}
