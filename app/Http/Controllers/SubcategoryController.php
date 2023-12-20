<?php

namespace App\Http\Controllers;

use App\Helpers\MyHelpers;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    use MyHelpers;
    public function index(){
        $subcategories = Subcategory::latest()->get();
        $categories = Category::latest()->select(['id', 'name'])->get();
        return view('admin.subcategory', compact('subcategories', 'categories'));
    }

    //category store Page
    public function store(Request $request){


        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|exists:categories,id'
        ]);


        $subcategory = new Subcategory();

        $subcategory->name = $request->name;
        $subcategory->category_id = $request->category;
        $subcategory->slug = $this->slug_Generator($request->name, Subcategory::class);
        $subcategory->save();
        alert()->success('Add','subcategory add successfully');
        return back();
    }

    Public function edit($id){
        $subcategories = Subcategory::paginate(10);
        $categories = Category::latest()->select(['id', 'name'])->get();
        $editData = Subcategory::find($id, ['id','name']);
        return view('admin.subcategory', compact('subcategories', 'editData', 'categories'));
        }

        public function update(Request $request, $id){
            $request->validate([
                'name' => 'required|string|max:255',
            ]);


            $subcategory = Subcategory::find($id);

            $subcategory->name = $request->name;
            $subcategory->slug = $this->slug_Generator($request->name, Subcategory::class);
            $subcategory->category_id = $request->category;
            $subcategory->save();
            alert()->success('Category','Subcategory update successfully');

            return back();
        }

        Public function delete($id){
                $subcategory = Subcategory::find($id);
                $subcategory->delete();
                return back();

        }

    public function change_status(Request $request){
        $subcategory = Subcategory::find($request->subcategory_id);
        if($subcategory->status){
            $subcategory->status = false;
        }else{
            $subcategory->status = true;
        }
        $subcategory->save();
    }
}
