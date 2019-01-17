<?php

namespace Candidatos\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class LanguageController extends Controller {

    public function index(Request $request) {
        $request->session()->put('language',$request->input('locate'));
        App::setlocale($request->input('locate'));
        return Redirect::back();
    }

}
