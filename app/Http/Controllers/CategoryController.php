<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Category;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    public function getAllCategories(){
        return view('admin.categories', ['categories'=>Category::all()]);
    }

    public function addCategory(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:categories'],
        ]);

        $category = new Category;
        $category->name = $request->name;
        $category->slug = str_replace(" ", "-", $request->name);
        $category->cover_img = "";
        $category->save();

        return redirect(route('categories'));
    }

    public function updateCategory(Request $request, string $id)
    {
        $updatedFields = [];
        $category = Category::where('id', $id)->first();
        $name = $request->name;
        $slug = $request->slug;

        if($name and $name!=$category->name){
            $request->validate(["name"=>['required', 'string', 'max:255']]);
            $updatedFields["name"]=$name;
        }

        if($slug and $slug!=$category->slug){
            $request->validate([
                'slug' => ['required', 'string', 'lowercase', 'max:255']
            ]);

            $updatedFields["slug"]= strtolower(str_replace(" ", "-", $request->slug));
        }


        if(count($updatedFields)>0){
            Category::where('id', $id)->update($updatedFields);
        }

        return redirect(route("categories"));
    }

    public function deleteCategory(string $id){
        Category::where('id', $id)->delete();
        return redirect(route("categories"));
    }
}
