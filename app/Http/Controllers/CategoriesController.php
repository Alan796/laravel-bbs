<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    public function show(Category $category, Request $request, User $user)
    {
        $posts = Post::where('category_id', $category->id)->withOrder($request->order)->paginate(30);

        $activists = $user->getActivists();

        return view('posts.index', compact('posts', 'category', 'activists'));
    }
}
