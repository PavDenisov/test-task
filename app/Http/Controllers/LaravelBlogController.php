<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LaravelBlogController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        return new JsonResponse(Article::tableFilter($request)->get());
    }

    public function getArticle(string $link): JsonResponse
    {
        return new JsonResponse(Article::with('author')->with('tags')->where('link', '/'. $link)->first());
    }
}
