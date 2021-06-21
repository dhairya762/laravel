<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';

    public function getTotal($items)
    {
        $total = 0;
        if ($items) {
            foreach ($items as $key => $item) {
                $total += $item->price;
            }
        }
        $cart = self::where('customer_id', '=', session('customer_id'))->first();
        $cart->total = $total;
        $cart->save();
        return $total;
    }
    
    public function getTotalDiscount($items)
    {
        $discount = 0;
        if ($items) {
            foreach ($items as $key => $item) {
                $discount += $item->discount;
            }
        }
        $cart = self::where('customer_id', '=', session('customer_id'))->first();
        $cart->discount = $discount;
        $cart->save();
        return $discount;
    }

    public function getFinalPrice($items)
    {
        $finalPrice = 0;
        $cart = self::where('customer_id', '=', session('customer_id'))->first();
        $finalPrice = $cart->shipping_amount;
        if ($items) {
            $finalPrice += ($this->getTotal($items) - $this->getTotalDiscount($items));
        }
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
