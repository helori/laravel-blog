<?php

namespace Helori\LaravelBlog\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Helori\LaravelBlog\Models\BlogArticle as Article;
use Helori\LaravelBlog\Requests\BlogArticleCreate as ArticleCreateRequest;
use Helori\LaravelBlog\Requests\BlogArticleUpdate as ArticleUpdateRequest;


class BlogArticlesController extends Controller
{
    public function read(Request $request, $id = null)
    {
        if(is_null($id)){
            return Article::findOrFail($id);
        }else{
            return Article::orderBy('title')->get();
        }
    }

    public function delete(Request $request, $id)
    {
        Article::destroy($id);
    }

    public function create(CategoryCreateRequest $request)
    {
        return Article::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $item = Article::findOrFail($id);
        $item->update($request->all());
        $item->save();
        return $item;
    }
}
