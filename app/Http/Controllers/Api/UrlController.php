<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Url;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UrlController extends Controller
{
    public function index(Request $request)
    {
        $user_id=$request->header('id');
        $user = User::findOrFail($user_id);
        $urls = Url::where('user_id', $user->id)->get();
        return response()->json(['urls' => $urls], 200);
    }

    public function shorten(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'url' => 'required|url|max:255',
        ]);

        $user_id=$request->header('id');

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 400);
        }

        $url = new Url([
            'original_url' => $request->input('url'),
            'code' => $this->generateUniqueCode(),
            'user_id' => $user_id,
        ]);

        $url->save();

        return response()->json([
            'original_url' => $url->original_url,
            'shortened_url' => route('url.redirect', ['code' => $url->code]),
        ], 201);
    }

    public function redirect($code)
    {
        $url = Url::where('code', $code)->first();
        if (!$url) {
            return response()->json(['error' => 'Url not found'], 404);
        }
        $url->increment('clicks');
        return redirect()->away($url->original_url);
    }

    public function destroy(Request $request, $id)
    {
        $user_id=$request->header('id');
        $url = Url::findOrFail($id);
        if ($user_id != $url->user_id) {
            return response()->json(['error' => 'Unauthorized to delete url'], 403);
        }
        $url->delete();
        return response()->json(['success' => 'URL deleted successfully.'], 203);

    }

    private function generateUniqueCode($length = 6)
    {
        do {
            $code = Str::random($length);
        } while (Url::where('code', $code)->exists());
        return $code;
    }
}
