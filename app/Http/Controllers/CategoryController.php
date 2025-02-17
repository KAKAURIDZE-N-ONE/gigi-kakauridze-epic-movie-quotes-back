<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
	public function index(): JsonResponse
	{
		$categories = Category::all();

		return response()->json([
			'status' => 'Categories retrieved successfully!',
			'data'   => $categories,
		], 200);
	}
}
