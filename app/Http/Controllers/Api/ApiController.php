<?php

namespace App\Http\Controllers\Api;

use App\Filament\Resources\Categories\CategoryResource;
use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function categories()
    {
        $categories = Category::orderBy('position', 'asc')->where('visible', true)->get();
        return CategoryResource::collection($categories);
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)->first();
        return new CategoryResource($category);
    }
}
