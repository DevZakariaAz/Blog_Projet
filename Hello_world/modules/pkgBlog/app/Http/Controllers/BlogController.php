<?php

namespace Modules\pkgBlog\app\Http\Controllers;

use Illuminate\Routing\Controller;

class BlogController extends Controller
{
    public function index()
    {
        return view('pkgBlog::index');
    }
}
