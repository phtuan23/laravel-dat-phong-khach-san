<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::orderBy('id', 'DESC')->paginate(4);
        if(request()->search){
            $search = request()->search;
            $categories = Category::orderby('id','DESC')->where('name','LIKE',"%$search%")->orWhere('max_people','=',$search)->orWhere('size','=',$search)->paginate(4);
        }
        return view('admin.category.index',compact('categories'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->only('name', 'size', 'max_people', 'description'),
            [
                'name' => 'required|unique:category',
                'size' => 'required|numeric',
                'max_people' => 'required|numeric',
                'description' => 'required'
            ],
            [
                'name.required' => 'Vui lòng điền tên danh mục',
                'name.unique' => 'Danh mục đã được sử dụng',
                'size.required' => 'Vui lòng điền diện tích',
                'size.numeric' => 'Diện tích không hợp lệ',
                'max_people.required' => 'Vui lòng điền số người tối đa',
                'max_people.numeric' => 'Số người tối đa phải là số',
                'description.required' => 'Vui lòng điền mô tả'
            ]
        );
        if($validator->fails()){
            $errors = $validator->errors()->all();
            $html = "<ul class='list-group'>";
            foreach($errors as $err){
                $html .= "<li class='list-group-item' style='list-style: none;border:none'>$err</li>";
            }
            $html .= "</ul>";
            return response([
                'status' => false,
                'title' => 'Thêm mới thất bại',
                'icon' => 'warning',
                'message' => $html
            ]);
        }
        if($validator->passes()){
            $data = [
                'name' => $request->name,
                'size' => $request->size,
                'max_people' => $request->max_people,
                'description' => $request->description
            ];
            if(Category::create($data)){
                Session::flash('success','Thêm mới thành công.');
                return response([
                    'status' => true
                ]);
            }else{
                return response([
                    'status' => false,
                    'message' => 'Thêm mới không thành công. Vui lòng thử lại',
                    'title' => 'Thêm mới thất bại',
                    'icon' => 'error'
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $validator = Validator::make(
            $request->only('name', 'size', 'max_people', 'description'),
            [
                'name' => 'required|unique:category,name,'.$category->id,
                'size' => 'required|numeric',
                'max_people' => 'required|numeric',
                'description' => 'required'
            ],
            [
                'name.required' => 'Vui lòng điền tên danh mục',
                'name.unique' => 'Danh mục đã được sử dụng',
                'size.required' => 'Vui lòng điền diện tích',
                'size.numeric' => 'Diện tích không hợp lệ',
                'max_people.required' => 'Vui lòng điền số người tối đa',
                'max_people.numeric' => 'Số người tối đa phải là số',
                'description.required' => 'Vui lòng điền mô tả'
            ]
        );
        if($validator->fails()){
            $errors = $validator->errors()->all();
            $html = "<ul class='list-group'>";
            foreach($errors as $err){
                $html .= "<li class='list-group-item' style='list-style: none;border:none'>$err</li>";
            }
            $html .= "</ul>";
            return response([
                'status' => false,
                'title' => 'Cập nhật thất bại',
                'icon' => 'warning',
                'message' => $html
            ]);
        }
        if($validator->passes()){
            $data = [
                'name' => $request->name,
                'size' => $request->size,
                'max_people' => $request->max_people,
                'description' => $request->description
            ];
            if($category->update($data)){
                Session::flash('success','Cập nhật thành công.');
                return response([
                    'status' => true
                ]);
            }else{
                return response([
                    'status' => false,
                    'message' => 'Cập nhật không thành công. Vui lòng thử lại',
                    'title' => 'Thêm mới thất bại',
                    'icon' => 'error'
                ]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->rooms()->count() > 0){
            return response([
                'status' => false,
                'title' => "Thất bại",
                'message' => 'Không thể xóa danh mục hiện tại',
                'icon' => 'error'
            ]);
        }else{
            $category->delete();
            return response([
                'status' => true,
                'title' => "Thành công",
                'message' => 'Xóa danh mục thành công',
                'icon' => 'success'
            ]);
        };
    }
}
