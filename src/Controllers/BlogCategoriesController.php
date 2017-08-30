<?php

namespace Helori\LaravelBlog\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Helori\LaravelBlog\Models\BlogCategory as Category;
use Helori\LaravelBlog\Requests\BlogCategoryCreate as CategoryCreateRequest;
use Helori\LaravelBlog\Requests\BlogCategoryUpdate as CategoryUpdateRequest;


class BlogCategoriesController extends Controller
{
    public function read(Request $request, $id = null)
    {
        if(is_null($id)){
            return Category::findOrFail($id);
        }else{
            return Category::orderBy('title')->get();
        }
    }

    public function delete(Request $request, $id)
    {
        Category::destroy($id);
    }

    public function create(CategoryCreateRequest $request)
    {
        return Category::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $item = Category::findOrFail($id);
        $item->update($request->all());
        $item->save();
        return $item;
    }
}
