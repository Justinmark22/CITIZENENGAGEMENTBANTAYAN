<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    public function setCookieExample()
    {
        // Create cookie (name, value, expiration minutes)
        $cookie = cookie('theme', 'dark', 60);

        // Attach it to response
        return response('Theme preference saved!')->cookie($cookie);
    }

    public function getCookieExample(Request $request)
    {
        $theme = $request->cookie('theme');
        return response("Your saved theme is: $theme");
    }

    public function deleteCookieExample()
    {
        Cookie::queue(Cookie::forget('theme'));
        return response('Theme cookie deleted!');
    }
}
