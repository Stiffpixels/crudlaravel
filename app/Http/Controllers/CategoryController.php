<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\DataTables\CategoriesDataTable;

class CategoryController extends Controller
{
    public function index(CategoriesDataTable $dataTable){
        return $dataTable->render('admin.categories');
    }
}
