<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $blogs = Blog::orderBy('id','desc')->paginate(4);
        if(request()->search){
            $search = request()->search;
            $blogs = Blog::orderby('id','DESC')->where('name','LIKE',"%$search%")->paginate(4);
        }
        return view('admin.blog.index',compact('blogs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blog.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'content' => 'required',
            'image' => 'required|image',
        ],
        [
            'name.required' => 'Vui lòng nhập tiêu đề',
            'content.required' => 'Vui lòng nhập nội dung bài viết',
            'image.required' => 'Vui lòng chọn ảnh tiêu đề',
            'image.image' => 'Ảnh chọn không hợp lệ'
        ]);

        if($request->has('image')){
            $request->image->move(public_path('upload'),$request->image->getClientOriginalName());
            $data = [
                'name' => $request->name,
                'content' => $request->content,
                'image' => $request->image->getClientOriginalName()
            ];
            if(Blog::create($data)){
                return redirect()->route('blog.index')->with('success','Thêm mới thành công');
            }
            return redirect()->back()->with('error','Thêm mới không thành công');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        return view('admin.blog.edit',compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'name' => 'required',
            'content' => 'required',
            'image' => 'nullable|image',
        ],
        [
            'name.required' => 'Vui lòng nhập tiêu đề',
            'content.required' => 'Vui lòng nhập nội dung bài viết',
            'image.image' => 'Ảnh chọn không hợp lệ'
        ]);

        $image = $blog->image;
        if($request->has('image')){
            $image = $request->image->getClientOriginalName();
            $request->image->move(public_path('upload'),$image);
        }
        $data = [
            'name' => $request->name,
            'content' => $request->content,
            'image' => $image
        ];
        if($blog->update($data)){
            return redirect()->route('blog.index')->with('success','Cập nhật thành công');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        $blog->delete();
        redirect()->back()->with('success','Xóa thành công');
    }
}
