<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductMedia;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

use function PHPUnit\Framework\isNull;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $page_no = null)
    {
        if (!$page_no) {
            $page_no = 1;
        }
        $current_page = $page_no;
        $recordsPerPage = $request->records_per_page;
        if ($recordsPerPage) {
            session(['paginate' => $recordsPerPage]);
        }
        if ($current_page == 1) {
            $recordsPerPage = session('paginate');
            if (!$recordsPerPage) {
                $recordsPerPage = 1;
            }
            session(['paginate' => $recordsPerPage]);
        }
        $count = Product::count();
        $limit = session('paginate');
        $offset = ($current_page - 1) * $limit;
        $allProducts = Product::all();
        $products = Product::orderBy('id', 'DESC')->offset($offset)->limit($limit)->get();

        if ($limit > 0) {
            $totalPage = ceil($count / $limit);
        } else {
            $totalPage = 0;
        }
        $view = view('product.list', compact('totalPage', 'limit', 'offset', 'allProducts', 'recordsPerPage', 'products'))->render();
        $response = [
            'element' => [
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
    public function create($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        // return view('product.add', compact('categories','product', 'id'));
        $view = view('product.add', compact('categories', 'product', 'id'))->render();
        $response = [
            'element' => [
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
        $postData = $request->products;
        if (!$postData['sku']) {
            return redirect('products/add/' . $id)->with('error', 'Please insert data into SKU field.');
        }
        if (!$postData['name']) {
            return redirect('products/add/' . $id)->with('error', 'Please insert data into Name field.');
        }
        if (!$postData['category']) {
            return redirect('products/add/' . $id)->with('error', 'Please insert data into Category field.');
        }
        if ($postData['price'] || $postData['price'] == 0) {
            if ($postData['price'] <= 0) {
                return redirect('products/add/' . $id)->with('error', 'Price value must be more than 0');
            }
        } else {
            return redirect('products/add/' . $id)->with('error', 'Please insert data into Price field.');
        }
        if (!$postData['discount'] || $postData['discount'] < 0) {
            if ($postData['discount'] < 0) {
                return redirect('products/add/' . $id)->with('error', 'Discount value must be greater than 0.');
            }
            if(!$postData['discount'] && $postData['discount'] != 0) {
                return redirect('products/add/' . $id)->with('error', 'Please insert data into Discount field.');
            }
        }
        if (!$postData['status']) {
            return redirect('products/add/' . $id)->with('error', 'Please insert data into Status field.');
        }
        $product = Product::find($id);
        if (!$product) {
            $sku = Product::where('sku', '=', $postData['sku'])->first();
            if ($sku) {
                return redirect('products/add/0')->with('error', 'Sku has to be unique please selece unique one.');;
            }
            $postData['created_at'] = Carbon::now();
            Product::insertGetId($postData);
            return redirect('products')->with('success', 'Product inserted successfully');
        } else {
            $product->sku = $postData['sku'];
            $product->name = $postData['name'];
            $product->category = $postData['category'];
            $product->price = $postData['price'];
            $product->discount = $postData['discount'];
            $product->status = $postData['status'];
            $product->updated_at = Carbon::now();
            $product->save();
            return redirect('products')->with('success', 'Product Updated successfully');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resourc>e.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request, $id)
    {
        $product = Product::find($id);
        // return view('product.edit', compact('product'));
        $view = view('product.edit', compact('product'))->render();
        $response = [
            'element' => [
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
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect('products')->with('success', 'Product deleted successfully.');
    }

    public function mediaAction($id)
    {
        $media = ProductMedia::where('product_id', '=', $id)->get(); //->toArray();
        // return view('product.media', compact('media', 'id'));
        $view = view('product.media', compact('media', 'id'))->render();
        $response = [
            'element' => [
                [
                    'selector' => '#content',
                    'html' => $view
                ]
            ]
        ];
        header('content-type:application/json');
        echo json_encode($response);
    }

    public function saveMediaAction(Request $request, $id)
    {
        $postData = $request->all();
        if (array_key_exists('base', $postData)) {
            $tmpArray['base'] = $postData['base'];
        }
        if (array_key_exists('small', $postData)) {
            $tmpArray['small'] = $postData['small'];
        }
        if (array_key_exists('thumb', $postData)) {
            $tmpArray['thumb'] = $postData['thumb'];
        }
        if (isset($tmpArray)) {
            foreach ($postData['label'] as $key => $value) {
                DB::update('update product_media set label = ? where id = ?', [$value, $key]);
                foreach ($tmpArray as $key2 => $value2) {
                    if ($value2 == $key) {
                        DB::update('update product_media set ' . $key2 . '= ? where id = ?', [1, $key]);
                    } else {
                        DB::update('update product_media set ' . $key2 . ' = ? where id = ?', [0, $key]);
                    }
                }
            }
        }
        if (array_key_exists('gallery', $postData)) {
            foreach ($postData['gallery'] as $key => $value) {
                DB::update('update product_media set gallery = ? where id = ?', [1, $key]);
            }
        }
        if (array_key_exists('delete', $postData)) {
            $delete = $postData['delete'];
            foreach ($delete as $media_id => $value) {
                $media = ProductMedia::where('id', '=', $media_id)->first();
                if (unlink('upload\product\\' . $media->image)) {
                    $media->delete();
                }
            }
        }
        return redirect('products/media/' . $id);
    }

    public function uploadMediaAction(Request $request, $id)
    {
        $media = new ProductMedia;
        $image = $request->file('image');
        $name = $_FILES['image']['name'];
        $input['imagename'] = $name;
        $destinationPath = public_path('\upload\product\\');
        if ($image->move($destinationPath, $input['imagename'])) {
            $media->image = $input['imagename'];
            $media->label = $name;
            $media->product_id = $id;
        }
        $media->save();
        return redirect('products/media/' . $id)->with('success', "Product deleted successfully.");
    }
}
