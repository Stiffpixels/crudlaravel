<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Product;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    /*public function getAllProducts(Request $request){*/
    /*    $q = $request->query('q');*/
    /*    $eloQ = Product::query();*/
    /**/
    /*    if($q!=null){*/
    /*        $eloQ->orWhere('name', 'like', '%'.$q.'%');*/
    /*    }*/
    /**/
    /*    return view('admin.products', ['categories'=>Category::all(), 'products'=>$eloQ->Paginate(10)]);*/
    /*}*/

    public function getDataTable(){
        $categories = Product::query();
        return DataTables::of($categories)->make(true);
    }

    public function displayDataTable():View{

        return view('admin.products', ['categories'=>Category::all()]);
    }

    public function addProduct(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:products'],
            'category' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->category_id = $request->category;
        $product->description = $request->description;
        $product->slug = str_replace(" ", "-", $request->name);
        $product->cover_img = "";
        $product->save();

        return redirect(route('products'))->with('success', "Product added successfully!");
    }

    public function updateProduct(Request $request, string $id)
    {
        $updatedFields = [];
        $product = Product::where('id', $id)->first();
        $name = $request->name;
        $slug = $request->slug;

        if($name and $name!=$product->name){
            $request->validate(["name"=>['required', 'string', 'max:255']]);
            $updatedFields["name"]=$name;
        }


        if($slug and $slug!=$product->slug){
            $request->validate([
                'slug' => ['required', 'string', 'lowercase', 'max:255']
            ]);

            $updatedFields["slug"]= strtolower(str_replace(" ", "-", $request->slug));
        }

        if(count($updatedFields)>0){
            Product::where('id', $id)->update($updatedFields);
        }

        return redirect(route("products"));
    }

    public function deleteProduct(string $id){
        Product::where('id', $id)->delete();
        return redirect(route("products"));
    }
}

