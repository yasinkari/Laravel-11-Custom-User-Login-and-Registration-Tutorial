<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display the order success page.
     *
     * @return \Illuminate\View\View
     */
    public function success()
    {
        return view('customer.order.status.success');
    }

    /**
     * Display the order failed page.
     *
     * @return \Illuminate\View\View
     */
    public function failed()
    {
        return view('customer.order.status.failed');
    }
}