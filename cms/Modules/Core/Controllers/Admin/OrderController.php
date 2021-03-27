<?php

namespace Cms\Modules\Core\Controllers\Admin;


use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('Core::order.index');
    }
}