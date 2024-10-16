<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Traits\GeneralTrait;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    use GeneralTrait;

    public function index()
    {
        $categories = Category::get();
        return response()->json($categories);
    }

    public function getCategoryById(Request $request)
    {
        $category = Category::find($request->id);
        if (!$category)
            return $this->returnError(404, 'هذا القسم غير موجود');
         return $this->returnData('category ', $category);
    }

    public function changeStatus(Request $request)
    {
         Category::where('id',$request->id)->update(['active' => $request -> active]);
            return $this->returnSuccessMessage( 'تم تغيير الحالة بنجاح');

    }
}
