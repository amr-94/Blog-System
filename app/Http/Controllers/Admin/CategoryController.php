<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('admin')->except('show');
    }


    public function index()
    {
        //
        $categories = category::paginate(3);
        return view('categories.index', [
            'categories' => $categories
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $categories = category::all();
        return view('categories.create', [
            'categories' => $categories
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => ['required', 'string']
        ]);
        if ($request->hasFile('category_img')) {
            $filename = time() . '.' . $request->category_img->extension();
            $request->category_img->move(public_path('files/categories/'), $filename);
            $request->merge([
                'category_image' => $filename,

            ]);
        }
        $request->merge([
            'slug' => Str::slug($request->name),
            'user_id' => Auth::user()->id,
        ]);
        $category = category::create($request->all());
        return redirect(route('category.index'))->with('success', 'A New Categoey Has Added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $category = category::findorfail($id);
        return view('categories.show', [
            'category' => $category
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $category = Category::findorfail($id);
        $categories = category::all()->except($id);
        return view('categories.edit', [
            'category' => $category,
            'categories' => $categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $request->validate([
            'name' => ['required', 'string']
        ]);
        if ($request->hasFile('category_img')) {
            $filename = time() . '.' . $request->category_img->extension();
            $request->category_img->move(public_path('files/categories/'), $filename);
            $request->merge([
                'category_image' => $filename,
            ]);
        }
        $request->merge([
            'slug' => Str::slug($request->name),
            'user_id' => Auth::user()->id,
        ]);

        $category = category::findorfail($id);
        $prev = $category->category_image;
        if ($prev && $prev != $request->category_img) {
            file::delete(public_path('files/categories/') . $prev);
        }

        $category->update($request->all());
        return redirect(route('category.index'))->with('success', 'A Categoey Has Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $category = category::findorfail($id);
        $category->destroy($id);
        return redirect(route('category.index'))->with('success', 'A Categoey Has deleted');
    }
}
