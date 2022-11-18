<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Repositories\CategoryRepository;
use Illuminate\Support\Facades\Gate;

class CategoryController extends Controller
{
    //
    protected $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function index()
    {
        if(!Gate::allows('category.index')){
            abort(401);
        }
        $categories = $this->categoryRepository->paginate();
        return view('admin.category.index', compact('categories'));
    }

    public function posts($slug)
    {
        $category = $this->categoryRepository->getCategoryBySlug($slug);
        $posts = $this->categoryRepository->getPostGroupByCategory($category);
        $name = $category->category_name;
        return view('category', compact('posts', 'name'));
    }

    public function store(CategoryRequest $request)
    {
        $this->categoryRepository->save($request->except("_token"));
        return redirect()->route('category.index');
    }
}
