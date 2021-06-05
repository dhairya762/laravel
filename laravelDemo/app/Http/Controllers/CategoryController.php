<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Carbon\Carbon;

use function PHPUnit\Framework\isNull;

class CategoryController extends Controller
{

    public function newIndex()
    {
        $currentCategory = null;
        $categories = Category::where('parent_id', '=', 0)->get();
        $allCategories = Category::all();
        $path = $allCategories->pluck('name', 'id')->toArray();
        // return view('categories.categoryTreeview', compact('path','currentCategory', 'categories', 'allCategories'));
        $view = view('categories.newList', compact('path','currentCategory', 'categories', 'allCategories'))->render();
        $response = [
            'element' =>[
                [
                    'selector' => '#content',
                    'html' => $view
                ]
            ]
        ];
        header('content-type:application/json');
        echo json_encode($response);
    }
    public function manageCategory()
    {
        $currentCategory = null;
        $categories = Category::where('parent_id', '=', 0)->get();
        $allCategories = Category::all();
        $path = $allCategories->pluck('name', 'id')->toArray();
        // return view('categories.categoryTreeview', compact('path','currentCategory', 'categories', 'allCategories'));
        $view = view('categories.categoryTreeview', compact('path','currentCategory', 'categories', 'allCategories'))->render();
        $response = [
            'element' =>[
                [
                    'selector' => '#content',
                    'html' => $view
                ]
            ]
        ];
        header('content-type:application/json');
        echo json_encode($response);
    }

    public function addCategory(Request $request)
    {
        $category = new Category;
            $post['name'] = $request->input('name');
            $post['parent_id'] = $request->get('parent_id');
        if ($post['parent_id'] == NULL) {
            $post['parent_id'] = 0;
        }
        $id = Category::insertGetId($post);
        $category = Category::find($id);
        $parentCategory = Category::find($category->parent_id);
        if ($category->parent_id != 0) {
            $category->path = $parentCategory['path'] . " = " . $id;
        } else {
            $category->path = $id;
        }
        $category->save();
        // $category = Category::find($id);
        // $data = compact('category');
        // return $data;
        return redirect('category')->with('success', 'Category added successfully.');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $model = new Category;
        $categories = Category::get();
        $path = Category::pluck('name', 'id')->toArray();//->all();//->toArray();
        // return view('categories.list', compact('categories', 'path'));//->with('name', $name);
        $view = view('categories.list', compact('categories', 'path'))->render();//->with('name', $name);
        $response = [
            'element' =>[
                [
                    'selector' => '#content',
                    'html' => $view
                ]
            ]
        ];
        header('content-type:application/json');
        echo json_encode($response);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function create($id)
    // {
    //     $category = Category::find($id);
    //     if ($category) {
    //         $path = $category->path;
    //         $categories = Category::where('id', '!=', $id)
    //         ->where('path', 'NOT LIKE', "{$path}%")
    //         ->get();
    //     }
    //     else {
    //         $categories = Category::all();
    //     }
    //     $path = Category::pluck('name', 'id')->toArray();
    //     // return view('categories.add', compact('categories', 'path', 'categoryDetail', 'id'));
    //     return view('categories.add', compact('categories', 'path', 'id', 'category'));
    // }

    public function create()
    {
        $categories = Category::where('parent_id', '=', 0)->get();
        $allCategories = Category::pluck('name', 'id');
        return view('categories.add', compact('categories', 'allCategories'));
        $view = view('categories.add', compact('categories', 'allCategories'))->render();
        $response = [
            'element' =>[
                [
                    'selector' => '#content',
                    'html' => $view
                ]
            ]
        ];
        header('content-type:application/json');
        echo json_encode($response);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
    {
        $category = Category::find($id);
        $postData = $request->category;
        if (!$category) {
            if (!(isset($postData['parent_id']))) {
                $postData['parent_id'] = 0;
            }
            $postData['path'] = 0;
            $postData['created_at'] = Carbon::now();
            $id = Category::insertGetId($postData);

            $category = Category::find($id);
            $parentCategory = Category::find($category->parent_id);
            if ($category->parent_id != 0) {
                $category->path = $parentCategory['path'] . " = " . $id;
            } else {
                $category->path = $id;
            }
            $category->save();
        } else {
            $path = $category->path;
            $childCategories = Category::where('path', 'LIKE', "%{$path}%")->where('id', '!=', $id)->get();
            $category->name = $postData['name'];
            $category->parent_id = $postData['parent_id'];
            if ($category->parent_id == 0) {
                $category->path = $id;
            }
            else
            {
                $category->path = $postData['parent_id'] . " = " . $id;
            }
            $category->status = $postData['status'];
            $category->created_at = Carbon::now();
            foreach ($childCategories as $key => $value) {
                $value->path = $category->path . " = " . $value->id;
                $value->save();
            }
            $category->save();
        }
        return redirect('categories');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request,$id)
    {
        $postData = $request->get('id');
        $category = Category::where('id', '=', $id)->first();
        return $category;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $categories = Category::where('parent_id', '=', 0)->get();
        $currentCategory = Category::find($id);
        $path = $currentCategory->path;
        $allCategories = Category::where('path', 'NOT LIKE', "{$path}%")
            ->get();
        $view = view('categories.updateCategoryTreeview', compact('currentCategory', 'id', 'allCategories','categories'))->render();
        $response = [
            'element' =>[
                [
                    'selector' => '#content',
                    'html' => $view
                ]
            ]
        ];
        header('content-type:application/json');
        echo json_encode($response);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category, $id)
    {
        $category = Category::find($id);
        $category->name = $request->input("name");
        $category->parent_id = $request->input("parent_id");
        if (!$category->parent_id) {
            $category->parent_id = 0;
        }
        if ($category->parent_id != 0) {
            $parentCategory = Category::find($category->parent_id);
            $category->path = $parentCategory->path . ' = '. $id; 
        }
        else
        {
            $category->path = $id; 
        }
        $category->updated_at = Carbon::now(); 
        $category->save();
        $childCategories = Category::where('path', 'LIKE', "%{$id}%")->where('id', '!=', $id)->get();
        foreach ($childCategories as $key => $child) {
            if ($child->parent_id == $id) {
                $child->path = $category->path . ' = ' . $child->id;
            }
            else{
                $parentCategory = Category::find($child->parent_id);
                $child->path = $parentCategory->path . ' = ' . $child->id;
            }
            $child->save();
        }
        return redirect('category')
            ->with('success', 'Category Updated Succesfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        echo 1;
        die;
        $category = Category::find($id);
        $childCategories = Category::where('path', 'LIKE', "%{$id}%")->where('id', '!=', $id)->get();
        foreach ($childCategories as $key => $value) {
            if ($value->parent_id == $id) {
                $value->parent_id = $category->parent_id;
                $value->path = $category->parent_id . " = " . $value->id;
                $value->save();
            }
            else {
                $parentCategory = Category::find($value->parent_id);
                $value->path = $parentCategory->path . " = " . $value->id;
                $value->save();
            }
        }
        if ($category->delete()) {
            $categories = Category::all();
            if ($categories) {
                $categories = $categories->where('parent_id', '=', '0');
                foreach ($categories as $key => $category) {
                    $category->path = $category->id;
                    $category->save();
                }
            }
        }
        return redirect('category')->with('Category deleted successfully.');
    }
}