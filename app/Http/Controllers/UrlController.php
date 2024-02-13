<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    private $url;

    public function __construct(Url $url)
    {
        $this->url = $url;
    }

    public function submit(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url',
        ]);

        if ($validator->fails()) {
            return back()->with('error', 'Please enter valid url !');
        }

        $shortUrl = $this->generateShortUrl($request['url']);

        $url = $this->url;
        $url['user_id'] = auth()->id();
        $url['long_url'] = $request['url'];
        $url['short_url'] = $shortUrl;
        $url->save();

        return back()->with('success', 'Successfully converted.');
    }

    private function generateShortUrl($originalUrl)
    {
        $url = parse_url($originalUrl);
        $identifier = Str::random(8);
        return $url['scheme'] . '://' . $url['host'] . '/' . $identifier;
    }

    public function click($id)
    {
        $url = $this->url->findOrFail($id);
        $url->click_count += 1;
        $url->save();

        return redirect($url->long_url);
    }
}
