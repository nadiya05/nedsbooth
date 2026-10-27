<?php

namespace App\Http\Controllers\Guest;

use App\Http\Controllers\Controller;
use App\Models\Frames;
use Illuminate\Http\Request;

class PhotoboothController extends Controller
{
    public function landing()
    {
        return view('landing');
    }

    public function index()
    {
        return view('guest.photobooth.index', ['frames' => Frames::latest()->paginate(3)]);
    }

    public function camera(Frames $frame)
    {
        return view('guest.photobooth.camera', compact('frame'));
    }

    public function session(Request $request)
    {
        $validated = $request->validate([
            'photo_data' => ['required', 'string', 'max:12000000', 'regex:/^data:image\/png;base64,[A-Za-z0-9+\/=]+$/'],
        ]);

        return view('guest.photobooth.result', ['dataUrl' => $validated['photo_data']]);
    }
}
