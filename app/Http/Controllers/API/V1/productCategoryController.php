<?php

namespace App\Http\Controllers\API\V1;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\getProductCategoryRequest;
use App\Http\Resources\paginatedResource;
use App\Http\Resources\productCategoryResource;
use App\Models\productCategory;
use Illuminate\Http\Request;

class productCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(getProductCategoryRequest $request)
    {
        $categories = productCategory::search($request->search)
            ->latest()
            ->paginate($request->limit ?? 10);

        return ApiResponse::success(
            new paginatedResource($categories, productCategoryResource::class),
            'Product category list'
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
