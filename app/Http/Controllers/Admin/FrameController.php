<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Frames;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FrameController extends Controller
{
    private const PRESETS = [
        'classic' => [600, 1800, 3],
        'classic_hd' => [800, 2400, 3],
        'compact' => [600, 1200, 2],
        'compact_hd' => [800, 1600, 2],
        'single' => [600, 800, 1],
        'single_hd' => [1200, 1600, 1],
    ];

    public function index()
    {
        return view('admin.photobooth.index', ['frames' => Frames::latest()->get()]);
    }

    public function create()
    {
        return view('admin.photobooth.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validatedFrame($request, true);
        $validated['image_path'] = $request->file('image')->store('frames', 'public');
        Frames::create($validated);

        return redirect()->route('admin.frames.index')->with('success', 'Frame berhasil ditambahkan.');
    }

    public function edit($id)
    {
        return view('admin.photobooth.edit', ['frame' => Frames::findOrFail($id)]);
    }

    public function update(Request $request, $id)
    {
        $frame = Frames::findOrFail($id);
        $validated = $this->validatedFrame($request, false);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($frame->image_path);
            $validated['image_path'] = $request->file('image')->store('frames', 'public');
        }

        $frame->update($validated);
        return redirect()->route('admin.frames.index')->with('success', 'Frame berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $frame = Frames::findOrFail($id);
        Storage::disk('public')->delete($frame->image_path);
        $frame->delete();
        return redirect()->route('admin.frames.index')->with('success', 'Frame berhasil dihapus.');
    }

    private function validatedFrame(Request $request, bool $imageRequired): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'preset' => ['required', 'string', 'in:'.implode(',', array_keys(self::PRESETS))],
            'image' => [$imageRequired ? 'required' : 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:10240'],
        ];
        $data = $request->validate($rules);
        [$width, $height, $shots] = self::PRESETS[$data['preset']];
        $layout = match ($shots) {
            3 => ['slot_height' => 400, 'slot_gap' => 50],
            2 => ['slot_height' => 450, 'slot_gap' => 50],
            1 => ['slot_height' => 600, 'slot_gap' => 0],
        };

        return [
            'name' => $data['name'], 'width' => $width, 'height' => $height, 'shot_count' => $shots,
            'slot_width' => 500, ...$layout,
        ];
    }
}
