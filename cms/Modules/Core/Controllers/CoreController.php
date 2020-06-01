<?php

namespace Cms\Modules\Core\Controllers;

use App\Http\Controllers\Controller;

class CoreController extends Controller
{
    public function welcome()
    {
        return view('Core::welcome');
    }
}
