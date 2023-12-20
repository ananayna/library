<?php

namespace App\Http\Controllers;

use App\Helpers\MyHelpers;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    use MyHelpers;
    public function index(){
        $categories = Category::latest()->get();
        return view('admin.category', compact('categories'));
    }

    //category store Page
    public function store(Request $request){


        $request->validate([
            'name' => 'required|string|max:255',
        ]);


        $category = new Category();

        $category->name = $request->name;
        $category->slug = $this->slug_Generator($request->name, Category::class);
        $category->save();
        alert()->success('Category','Category add successfully');
        return back();
    }

    Public function edit($id){
        $categories = Category::paginate(10);
        $editData = Category::find($id, ['id','name']);
        return view('admin.Category', compact('categories', 'editData'));
        }

        public function update(Request $request, $id){
            $request->validate([
                'name' => 'required|string|max:255',
            ]);


            $category = Category::find($id);

            $category->name = $request->name;
            $category->slug = $this->slug_Generator($request->name, Category::class);
            $category->save();
            alert()->success('Category','Category update successfully');

            return back();
        }

        Public function delete($id){
            $category_count = Category::count();
            if($category_count > 1){
                $category = Category::find($id);
                $category->delete();
                return back();
            }
            return back();
        }

    public function change_status(Request $request){
        $category = Category::find($request->category_id);
        if($category->status){
            $category->status = false;
        }else{
            $category->status = true;
        }
        $category->save();
    }

}
