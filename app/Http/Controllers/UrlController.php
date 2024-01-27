<?php

namespace App\Http\Controllers;

use App\Models\Url;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $urls = Url::where('user_id', $user->id)->get();
        return view('urls.index', compact('urls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('urls.create');
    }

    public function shorten(Request $request)
    {
        $request->validate([
            'url' => 'required|url|max:255',
        ]);

        $user = Auth::user();

        $url = new Url([
            'original_url' => $request->input('url'),
            'code' => $this->generateUniqueCode(),
            'user_id' => $user->id,
        ]);

        $url->save();

        return redirect()->back()
            ->with('shortened_url', route('url.redirect', ['code' => $url->code]))
            ->with('original_url', $url->original_url);
    }

    public function redirect($code)
    {
        $url = Url::where('code', $code)->first();
        if (!$url) {
            abort(404);
        }
        $url->increment('clicks');
        return redirect($url->original_url);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Url $url)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Url $url)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Url $url)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $url = Url::findOrFail($id);
        if (Auth::user()->id !== $url->user_id) {
            return redirect()->back()->with('error', 'Unauthorized to delete url');
        }

        $url->delete();
        return redirect()->back()->with('success', 'URL deleted successfully.');
    }

    private function generateUniqueCode($length = 6)
    {
        do {
            $code = Str::random($length);
        } while (Url::where('code', $code)->exists());

        return $code;
    }
}
