<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ProductImport;
use App\Exports\ProductExport;

class CsvController extends Controller
{
    protected $header = [];
    protected $data = [];

    public function index(Request $request)
    {
        $view = view('csv.form')->render();
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
        die;
    }

    // public function upload(Request $request)
    // {
    //     $image = $request->file('image');
    //     $name = $_FILES['image']['name'];
    //     $type = $_FILES['image']['type'];
    //     $tmp_name = $_FILES['image']['tmp_name'];
    //     $size = $_FILES['image']['size'];
    //     $destinationPath = public_path('\upload\csv\\');
    //     $file = fopen($tmp_name, "r");
    //     if ($file) {
    //         // $allFile = scandir($destinationPath, 0);
    //         // if (array_search($name, $allFile)) {
    //         //     return redirect('csv')->with('error', "File name is available in the system please rename it and then upload it.");
    //         // }
    //         $image->move($destinationPath, $name);
    //     }
    //     while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
    //         if ($this->header) {
    //             $this->data[] = array_combine($this->header, $column);
    //         } else {
    //             $this->header = $column;
    //         }
    //     }
    //     foreach ($this->data as $key => $value) {
    //         if (isset($value['sku'])) {
    //             $sku = $value['sku'];
    //         } else {
    //             return redirect('csv')->with('error', 'Sku field is empty in csv file on line .');
    //         }
    //         if (isset($value['name'])) {
    //             $name = $value['name'];
    //         } else {
    //             return redirect('csv')->with('error', 'Name field is empty in csv file on line .');
    //         }
    //         if (isset($value['category'])) {
    //             $category = $value['category'];
    //         } else {
    //             return redirect('csv')->with('error', 'Category field is empty in csv file on line .');
    //         }
    //         if (isset($value['price'])) {
    //             if ($value['price'] <= 0) {
    //                 return redirect('csv')->with('error', 'Price field is must be more then 0 in csv file on line .');
    //             }
    //             $price = $value['price'];
    //         } else {
    //             return redirect('csv')->with('error', 'Price field is empty in csv file on line .');
    //         }
    //         if (isset($value['discount'])) {
    //             if ($value['discount'] >= 0) {
    //                 $discount = $value['discount'];
    //             } else {
    //                 return redirect('csv')->with('error', 'Discount field is must not be less then 0 in csv file on line .');
    //             }
    //         } else {
    //             return redirect('csv')->with('error', 'Discount field is empty in csv file on line .');
    //         }
    //         if (isset($value['status'])) {
    //             $status = $value['status'];
    //         } else {
    //             return redirect('csv')->with('error', 'Status field is empty in csv file on line .');
    //         }
    //     }
    //     foreach ($this->data as $key => $value) {
    //         $product = Product::where('sku', '=', $value['sku'])->first();
    //         if ($product) {
    //             $value['updated_at'] = Carbon::now();
    //             $product->update($value);
    //             // $product->sku = $sku;
    //             // $product->name = $name;
    //             // $product->category = $category;
    //             // $product->price = $price;
    //             // $product->discount = $discount;
    //             // $product->status = $status;
    //             // $product->updated_at = Carbon::now();
    //             // $product->save();
    //             // print_r($product);
    //             // die;
    //         } else {
    //             $value['created_at'] = Carbon::now();
    //             $product = Product::insert($value);
    //             //     [
    //             //         'sku' => $sku,
    //             //         'name' => $name,
    //             //         'category' => $category,
    //             //         'price' => $price,
    //             //         'discount' => $discount,
    //             //         'status' => $status,
    //             //         'created_at' => Carbon::now(),
    //             //     ]
    //             // );
    //         }
    //     }
    //     fclose($file);
    //     return redirect('csv')->with('success', 'CSV file Imported successfully.');
    // }

    // public function export()
    // {
    //     $tmpHeader = [];
    //     header('Content-Type: text/csv; charset=utf-8');
    //     header('Content-Disposition: attachment; filename=data.csv');
    //     $file = fopen('php://output', 'w');
    //     $header = DB::select('SHOW COLUMNS FROM `product`');
    //     foreach ($header as $key => $value) {
    //         array_push($tmpHeader, $value->Field);
    //     }
    //     fputcsv($file, $tmpHeader);
    //     $products = Product::orderBy('id', 'DESC')->get();
    //     foreach ($products as $key => $product) {
    //         foreach ($tmpHeader as $key => $value) {
    //             $tmpData[$value] = $product->$value;
    //         }
    //         fputcsv($file, $tmpData);
    //     }
    //     fclose($file);
    // }

    public function import(Request $request)
    {
        Excel::import(new ProductImport, $request->image);
        return Redirect('csv')->with("success", "Records imports successfully.");
    }

    public function exportIntoCSV()
    {
        return Excel::download(new ProductExport, 'productlist.csv');
    }
}