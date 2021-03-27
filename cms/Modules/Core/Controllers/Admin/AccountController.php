<?php

namespace Cms\Modules\Core\Controllers\Admin;


use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function __construct()
    {

    }

    public function index()
    {
        return view('Core::account.index');
    }
}