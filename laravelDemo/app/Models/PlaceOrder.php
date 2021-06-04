<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlaceOrder extends Model
{
    use HasFactory;
    protected $table = "placeorder";

    public function getTotal($items)
    {
        $total = 0;
        foreach ($items as $key => $item) {
            $total += $item->price;
        }
        return $total;
    }
    
    public function getTotalDiscount($items)
    {
        $discount = 0;
        foreach ($items as $key => $item) {
            $discount += $item->discount;
        }
        return $discount;
    }

    public function getFinalPrice($items)
    {
        $finalPrice = 0;
        $finalPrice += ($this->getTotal($items) - $this->getTotalDiscount($items));
        return $finalPrice;
    }

    public function getTotalQuantity($items)
    {
        $quantity = 0;
        foreach ($items as $key => $item) {
            $quantity += $item->quantity;
        }
        return $quantity;
    }
}
