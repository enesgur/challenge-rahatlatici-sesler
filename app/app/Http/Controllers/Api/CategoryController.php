<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function list(Request $request)
    {
        $data = Category::allData();
        return $this->responseSuccess($data);
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function songs($id, Request $request)
    {
        $data = Category::songs($id);
        return $this->responseSuccess($data);
    }
}
