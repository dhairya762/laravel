<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Carbon\Carbon;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row['price'] <= 0) {
            return redirect('csv')->with('error', 'Price must be more then 0.');
        }
        if ($row['discount'] < 0) {
            return redirect('csv')->with('error', 'Discount must be non negative..');
        }
        $product = Product::where('sku', '=', $row['sku'])->first();
        if ($product) {
            $row['updated_at'] = Carbon::now();
            $product->update($row);
            return $product;
        }

        return new Product([
            'sku' => $row['sku'],
            'name' => $row['name'],
            'category' => $row['category'],
            'price' => $row['price'],
            'discount' => $row['discount'],
            'status' => $row['status'],
            'created_at' => Carbon::now(),
        ]);
    }
}
