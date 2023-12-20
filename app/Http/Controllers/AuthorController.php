<?php

namespace App\Http\Controllers;

use App\Helpers\MyHelpers;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    use MyHelpers;
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


        if($request->hasFile('image')){
            $image = $this->ImageUplode($request->image, 'Author');
        }

        $author = new Author();

        $author->name = $request->name;
        $author->slug = $this->slug_Generator($request->name, Author::class);
        $author->image = isset($image) ? $image : $author->image;
        $author->message = $request->message;
        $author->save();
        alert()->success('Add','Author add successfully');
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

            if($request->hasFile('image')){
                $image = $this->ImageUplode($request->image, 'Author');
            }

            $author = Author::find($id);

            $author->name = $request->name;
            $author->slug = $this->slug_Generator($request->name, Author::class);
            $author->image = isset($image) ? $image : $author->image;
            $author->message = $request->message;
            $author->save();
            alert()->success('Update','Author update successfully');
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
