<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\CartAddress;
use App\Models\CartItem;
use App\Models\PlaceOrder;
use App\Models\PlaceOrderAddress;
use App\Models\PlaceOrderItem;
use App\Models\Product;
use App\Models\Customers;
use App\Models\CustomersAddress;
use App\Models\Payment;
use App\Models\Shipping;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getCart()
    {
        $cart = Cart::where('customer_id', '=', session('customer_id'))->first();
        return $cart;
    }

    public function getCartBillingAddress()
    {
        $cart = $this->getCart();
        $cartBillingAddress = CartAddress::where('cart_id', '=', $cart->id)->where('address_type', '=', 'billing')->first();
        return $cartBillingAddress;
    }

    public function getCartShippingAddress()
    {
        $cart = $this->getCart();
        $cartBillingAddress = CartAddress::where('cart_id', '=', $cart->id)->where('address_type', '=', 'shipping')->first();
        return $cartBillingAddress;
    }

    public function getCustomerBillingAddress()
    {
        $customerBillingAddress = CustomersAddress::where('customer_id', '=', session('customer_id'))->where('address_type', '=', 'billing')->first();
        return $customerBillingAddress;
    }

    public function getCustomerShippingAddress()
    {
        $customerShippingAddress = CustomersAddress::where('customer_id', '=', session('customer_id'))->where('address_type', '=', 'shipping')->first();
        return $customerShippingAddress;
    }

    public function index()
    {
        if (!(session('customer_id'))) {
            session(['customer_id' => 1]);
            $customer_id = session('customer_id');
        }
        $model = new Cart;
        $customer_id = session('customer_id');
        $customerName = Customers::where('status', '=', 'Enable')->get();
        $customerName = Customers::where('status', '=', 'Enable')->get();
        $payment = Payment::where('status', '=', 'Enable')->get();
        $shipping = Shipping::where('status', '=', 'Enable')->get();
        $products = Product::where('status', '=', 'enable')->get();
        $cart = $this->getCart();
        if ($cart) {
            $customerBillingAddress = $this->getCartBillingAddress();
            $customerShippingAddress = $this->getCartShippingAddress();
            if (!$customerBillingAddress) {
                $customerBillingAddress = $this->getCustomerBillingAddress();
            }
            if (!$customerShippingAddress) {
                $customerShippingAddress = $this->getCustomerShippingAddress();
            }
            $cartItem = CartItem::where('cart_id', '=', $cart->id)->get();
            if ($cart->customer_id) {
                // return view('cart.index', compact('model', 'cartItem', 'products', 'cart', 'payment', 'shipping', 'customerName', 'customerBillingAddress', 'customerShippingAddress'));
                $view = view('cart.index', compact('model', 'cartItem', 'products', 'cart', 'payment', 'shipping', 'customerName', 'customerBillingAddress', 'customerShippingAddress'))->render();
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
        } else {

            $cart = new cart;
            $cart->customer_id = session('customer_id');
            $customerShippingAddress = $this->getCustomerBillingAddress();
            $customerBillingAddress = $this->getCustomerShippingAddress();
            $cartItem = new CartItem;
            $shipping = Shipping::find(1);
            $cart->shipping_amount = $shipping->amount;
            $cart->save();
            // return view('cart.index', compact('model', 'cartItem', 'products', 'cart', 'payment', 'shipping', 'customerName', 'customerBillingAddress', 'customerShippingAddress'));
            $view = view('cart.index', compact('model', 'cartItem', 'products', 'cart', 'payment', 'shipping', 'customerName', 'customerBillingAddress', 'customerShippingAddress'))->render();
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
    }

    public function selectCustomerAction(Request $request)
    {
        session(['customer_id' => $request->input('customer_id')]);
        return redirect('cart')->with('success', 'Customer selected successfully.');
    }

    public function billingAddressAction(Request $request)
    {
        $cart = $this->getCart();
        $postData = $request->billing;
        $postData['cart_id'] = $cart->id;
        $postData['address_type'] = 'billing';
        if ($postData['save_to_address']) {
            $address = $this->getCustomerBillingAddress();
            if ($address) {
                if ($address->id) {
                    $address->address = $postData['address'];
                    $address->city = $postData['city'];
                    $address->state = $postData['state'];
                    $address->country = $postData['country'];
                    $address->zipcode = $postData['zipcode'];
                    $address->save();
                } else {
                    $address = new CustomersAddress;
                    $address->customer_id = session('customer_id');
                    $address->address = $postData['address'];
                    $address->city = $postData['city'];
                    $address->state = $postData['state'];
                    $address->country = $postData['country'];
                    $address->zipcode = $postData['zipcode'];
                    $address->address_type = 'billing';
                    $address->save();
                }
            }
        }
        $address = new CustomersAddress;
        $address->address_type = 'billing';
        $address->customer_id = session('customer_id');
        $address->address = $postData['address'];
        $address->city = $postData['city'];
        $address->state = $postData['state'];
        $address->country = $postData['country'];
        $address->zipcode = $postData['zipcode'];
        $address->address_type = 'billing';
        $address->save();

        $cartBillingAddress = $this->getCartBillingAddress();
        if ($cartBillingAddress) {
            $cartBillingAddress->cart_id = $cart->id;
            $cartBillingAddress->address = $postData['address'];
            $cartBillingAddress->city = $postData['city'];
            $cartBillingAddress->state = $postData['state'];
            $cartBillingAddress->country = $postData['country'];
            $cartBillingAddress->zipcode = $postData['zipcode'];
            $cartBillingAddress->address_type = 'billing';
            $cartBillingAddress->same_as_billing = 0;
        } else {
            $cartAddress = new CartAddress;
            $cartAddress->cart_id = $cart->id;
            $cartAddress->address = $postData['address'];
            $cartAddress->city = $postData['city'];
            $cartAddress->state = $postData['state'];
            $cartAddress->country = $postData['country'];
            $cartAddress->zipcode = $postData['zipcode'];
            $cartAddress->address_type = 'billing';
            $cartAddress->same_as_billing = 0;
            $cartAddress->save();
        }
        return redirect('cart')->with('success', "Customer's billing address successfully saved.");
    }

    public function shippingAddressAction(Request $request)
    {
        $cart = $this->getCart();
        $postData = $request->shipping;
        $postData['cart_id'] = $cart->id;
        $postData['address_type'] = 'shipping';
        $billingAddress = $this->getCartBillingAddress();
        $shippingAddress = $this->getCartShippingAddress();
        if (isset($postData['same_as_billing'])) {
            if ($shippingAddress) {
                if ($shippingAddress->id) {
                    $shippingAddress->address = $billingAddress->address;
                    $shippingAddress->city = $billingAddress->city;
                    $shippingAddress->state = $billingAddress->state;
                    $shippingAddress->country = $billingAddress->country;
                    $shippingAddress->zipcode = $billingAddress->zipcode;
                    $shippingAddress->same_as_billing = 1;
                }
            } else {
                $shippingAddress = new CartAddress;
                $shippingAddress->cart_id = $cart->id;
                $shippingAddress->address_type = 'shipping';
                $shippingAddress->address = $billingAddress->address;
                $shippingAddress->city = $billingAddress->city;
                $shippingAddress->state = $billingAddress->state;
                $shippingAddress->country = $billingAddress->country;
                $shippingAddress->zipcode = $billingAddress->zipcode;
                $shippingAddress->same_as_billing = 1;
                $shippingAddress->save();
            }
            $customerBillingAddress = $this->getCustomerBillingAddress();
            $customerShippingAddress = $this->getCustomerShippingAddress();
            if ($customerShippingAddress) {
                if ($customerShippingAddress->id) {
                    $customerShippingAddress->address_type = 'shipping';
                    $customerShippingAddress->address = $customerBillingAddress->address;
                    $customerShippingAddress->city = $customerBillingAddress->city;
                    $customerShippingAddress->state = $customerBillingAddress->state;
                    $customerShippingAddress->country = $customerBillingAddress->country;
                    $customerShippingAddress->zipcode = $customerBillingAddress->zipcode;
                    $customerShippingAddress->save();
                } else {
                    $customerShippingAddress = new CustomersAddress;
                    $customerShippingAddress->customer_id = session('customer_id');
                    $customerShippingAddress->address_type = 'shipping';
                    $customerShippingAddress->address = $customerBillingAddress->address;
                    $customerShippingAddress->city = $customerBillingAddress->city;
                    $customerShippingAddress->state = $customerBillingAddress->state;
                    $customerShippingAddress->country = $customerBillingAddress->country;
                    $customerShippingAddress->zipcode = $customerBillingAddress->zipcode;
                    $customerShippingAddress->save();
                }
            }
            if ($postData['save_to_address']) {
                $address = $this->getCustomerShippingAddress();
                if ($address) {
                    $address->address = $customerBillingAddress->address;
                    $address->city = $customerBillingAddress->city;
                    $address->state = $customerBillingAddress->state;
                    $address->country = $customerBillingAddress->country;
                    $address->zipcode = $customerBillingAddress->zipcode;
                    $address->save();
                } else {
                    $address =  new CustomersAddress;
                    $address->customer_id = session('customer_id');
                    $address->address_type = 'shipping';
                    $address->address = $customerBillingAddress->address;
                    $address->city = $customerBillingAddress->city;
                    $address->state = $customerBillingAddress->state;
                    $address->country = $customerBillingAddress->country;
                    $address->zipcode = $customerBillingAddress->zipcode;
                    $address->save();
                }
            }
            return redirect('cart')->with('success', "Customer's shipping address successfully saved.");
        } else {
            if ($postData['save_to_address']) {
                $address = $this->getCustomerShippingAddress();
                if ($address) {
                    if ($address->id) {
                        $address->address = $postData['address'];
                        $address->city = $postData['city'];
                        $address->state = $postData['state'];
                        $address->country = $postData['country'];
                        $address->zipcode = $postData['zipcode'];
                        $address->save();
                    } else {
                        $address = new CustomersAddress;
                        $address->customer_id = session('customer_id');
                        $address->address = $postData['address'];
                        $address->city = $postData['city'];
                        $address->state = $postData['state'];
                        $address->country = $postData['country'];
                        $address->zipcode = $postData['zipcode'];
                        $address->address_type = 'shipping';
                        $address->save();
                    }
                }
            }
            $cartShippingAddress = $this->getCartShippingAddress();
            if ($cartShippingAddress) {
                $cartShippingAddress->cart_id = $cart->id;
                $cartShippingAddress->address = $postData['address'];
                $cartShippingAddress->city = $postData['city'];
                $cartShippingAddress->state = $postData['state'];
                $cartShippingAddress->country = $postData['country'];
                $cartShippingAddress->zipcode = $postData['zipcode'];
                $cartShippingAddress->address_type = 'shipping';
                $cartShippingAddress->same_as_billing = 0;
            } else {
                $cartAddress = new CartAddress;
                $cartAddress->cart_id = $cart->id;
                $cartAddress->address = $postData['address'];
                $cartAddress->city = $postData['city'];
                $cartAddress->state = $postData['state'];
                $cartAddress->country = $postData['country'];
                $cartAddress->zipcode = $postData['zipcode'];
                $cartAddress->address_type = 'shipping';
                $cartAddress->same_as_billing = 0;
                $cartAddress->save();
            }
        }
        return redirect('cart')->with('success', "Customer's shipping address successfully saved.");
    }

    public function paymentAction(Request $request)
    {
        $payment_method_id = $request->payment_method;
        $cart = $this->getCart();
        $cart->payment_method_id = $payment_method_id;
        $cart->save();
        return redirect('cart')->with('success', "Payment method successfully saved.");
    }

    public function shippingAction(Request $request)
    {
        $shipping_method_id = $request->shipping_method;
        $shipping = Shipping::find($shipping_method_id);
        $cart = $this->getCart();
        $cart->shipping_method_id = $shipping_method_id;
        $cart->shipping_amount = $shipping->amount;
        $cart->save();
        return redirect('cart')->with('success', "Shipping method successfully saved.");
    }

    public function addProductAction(Request $request)
    {
        $cart = $this->getCart();
        $postData = $request->product['add_to_cart'];
        if (empty($postData)) {
            return redirect('cart')->with('error', "No Product is selected to add into cart.");
        } else {
            foreach ($postData as $key => $product_id) {
                $product = Product::find($product_id);
                $cartItem = CartItem::where('product_id', '=', $product_id)->where('cart_id', '=', $cart->id)->first();
                if ($cartItem) {
                    if ($cartItem->id) {
                        $cartItem->quantity += 1;
                        $cartItem->price = $cartItem->quantity * $cartItem->price;
                        $cartItem->discount = $cartItem->quantity * $product->discount;
                        $cartItem->save();
                    }
                } else {
                    $cartItem = new CartItem;
                    $cartItem->cart_id = $cart->id;
                    $cartItem->product_id = $product_id;
                    $cartItem->base_price = $product->price;
                    $cartItem->price = $product->price;
                    $cartItem->discount = $product->discount;
                    $cartItem->save();
                }
            }
        }
        return redirect('cart')->with('success', "Selected Product is successfully added into cart.");
    }

    public function updateQuantityAction(Request $request)
    {
        $postData = $request->quantity;
        $cart = $this->getCart();
        foreach ($postData as $product_id => $quantity) {
            $cartItem = CartItem::where('cart_id', '=', $cart->id)->where('product_id', '=', $product_id)->first();
            $product = Product::find($product_id);
            if ($quantity == 0) {
                $cartItem->delete();
            } else if ($quantity < 0) {
                $cartItem->quantity = $quantity;
                $cartItem->price = $quantity * $product->price;
                $cartItem->discount = $quantity * $product->discount;
                $cartItem->save();
            } else {
                return redirect('cart')->with('error', "Quantity must be more than 0.");
            }
        }
        return redirect('cart')->with('success', "Quantity updated successfully");
    }

    public function clearCartAction(Request $request)
    {
        $cart = $this->getCart();
        $cartItem = CartItem::where('cart_id', '=', $cart->id)->get();
        if ($cartItem) {
            foreach ($cartItem as $key => $item) {
                $item->delete();
            }
        }
        return redirect('cart')->with('success', "Cart cleared successfully");
    }

    public function deletProductAction(Request $request)
    {
        $remove = $request->remove;
        if ($remove) {
            $cart = $this->getCart();
            foreach ($remove as $key => $cart_item_id) {
                $cartItem = CartItem::where('cart_id', '=', $cart->id)->where('id', '=', $cart_item_id)->first();
                $cartItem->delete();
            }
        }
        return redirect('cart')->with('success', "Selected productes are removed successfully.");
    }

    public function placeOrderAction(Request $request)
    {
        $cart = $this->getCart();
        $cart_item = CartItem::where('cart_id', '=', $cart->id)->get();
        $cart_address = CartAddress::where('cart_id', '=', $cart->id)->get();
        $placeorder = new PlaceOrder;
        $placeorder_item = new PlaceOrderItem;
        $placeorder_address = new PlaceOrderAddress;
        $products = Product::where('status', '=', 'enable')->get();
        $model = new Cart;
        $customerName = Customers::where('id', '=', $cart->customer_id)->first();
        $paymentMethod = Payment::where('id', '=', $cart->payment_method_id)->first();
        $shippingMethod = Shipping::where('id', '=', $cart->shipping_method_id)->first();
        $id = $placeorder->insertGetId(
            [
                'customer_id' => $cart->customer_id,
                'total' => $cart->total,
                'discount' => $cart->discount,
                'payment_method_id' => $cart->payment_method_id,
                'shipping_method_id' => $cart->shipping_method_id,
                'shipping_amount' => $cart->shipping_amount,
            ]
        );
        $cart->delete();
        $placeorder = PlaceOrder::where('customer_id', '=', $cart->customer_id)->first();
        foreach ($cart_item as $key => $item) {
            $item_id = $placeorder_item->insertGetId(
                [
                    'placeorder_id' => $id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'base_price' => $item->base_price,
                    'price' => $item->price,
                    'discount' => $item->discount,
                    ]
                );
                $item->delete();
            }
            foreach ($cart_address as $key => $address) {
                $address_id = $placeorder_address->insertGetId(
                    [
                        'placeorder_id' => $id,
                        'address_type' => $address->address_type,
                        'address' => $address->address,
                        'city' => $address->city,
                        'state' => $address->state,
                        'country' => $address->country,
                        'zipcode' => $address->zipcode,
                        'same_as_billing' => $address->same_as_billing,
                        ]
                    );
                    $address->delete();
        }
        $customerBillingAddress = $this->getCartBillingAddress();
        if (!$customerBillingAddress) {
            $customerBillingAddress = $this->getCustomerBillingAddress();
        }
        $customerShippingAddress = $this->getCartShippingAddress();
        if (!$customerShippingAddress) {
            $customerShippingAddress = $this->getCustomerShippingAddress();
        }
        // return view('cart.placeorder', compact('paymentMethod', 'shippingMethod', 'customerName', 'model', 'products', 'cart', 'customerBillingAddress', 'customerShippingAddress', 'cartItem'));
        $view = view('cart.placeorder', compact('paymentMethod', 'shippingMethod', 'customerName', 'model', 'products', 'cart', 'customerBillingAddress', 'customerShippingAddress', 'cart_item'))->render();
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
    public function create()
    {
        //
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
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        //
    }
}
