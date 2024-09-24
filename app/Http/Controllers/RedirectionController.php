<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;

class RedirectionController extends Controller
{
    function __invoke(Request $request, Url $url){
        abort_if(!$url,404);

        $url->increment('clicks');

        return redirect($url->long_url,301);
    }
}
