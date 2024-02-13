<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class UrlController extends Controller
{
    public function url_submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        $url = parse_url($request['url']);
        $identifier = Str::random(8);
        $shortUrl = $url['scheme'] . '://' . $url['host'] . '/' . $identifier;

        return response()->json(['short_url' => $shortUrl], 200);
    }
}
