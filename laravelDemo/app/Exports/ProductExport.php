<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection,WithHeadings
{
    public function headings():array{
        return [
            'id',
            'sku',
            'name',
            'category',
            'price',
            'discount',
            'status',
            'created_at',
            'updated_at',
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return Product::where('status', '!=', 'enable')->get();
        return Product::all();
    }
}
