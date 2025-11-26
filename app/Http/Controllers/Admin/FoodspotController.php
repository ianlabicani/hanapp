<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Foodspot;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FoodspotController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $foodspots = Foodspot::latest()->paginate(10);

        return view('admin.foodspots.index', compact('foodspots'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.foodspots.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'open_time' => 'nullable|string',
            'close_time' => 'nullable|string',
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'category_tag' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'tagline' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120',
            'thumbnail_index' => 'nullable|integer|min:0',
        ]);

        // allow admin to optionally set an owner via `user_id`; default to null
        $data['user_id'] = $request->input('user_id') ?? null;

        $foodspot = Foodspot::create($data + ['images' => []]);

        // handle uploads (resize & store)
        if ($request->hasFile('images')) {
            $stored = [];
            foreach ($request->file('images') as $file) {
                $path = $this->resizeAndStore($file, 'foodspots/'.$foodspot->id);
                $stored[] = $path;
            }
            $foodspot->images = $stored;
            $foodspot->save();
        }

        // handle thumbnail selection (index relative to images array)
        $thumbnailIndex = $request->input('thumbnail_index');
        if ($thumbnailIndex !== null) {
            $images = $foodspot->images ?? [];
            $idx = (int) $thumbnailIndex;
            if (isset($images[$idx])) {
                $foodspot->thumbnail = $images[$idx];
                $foodspot->save();
            }
        } else {
            // default thumbnail to first image if available
            $images = $foodspot->images ?? [];
            if (! empty($images) && empty($foodspot->thumbnail)) {
                $foodspot->thumbnail = $images[0];
                $foodspot->save();
            }
        }

        return redirect()->route('admin.foodspots.index')->with('success', 'Foodspot created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Foodspot $foodspot)
    {
        // admin can view any foodspot
        return view('admin.foodspots.show', compact('foodspot'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Foodspot $foodspot)
    {
        // admin can edit any foodspot
        return view('admin.foodspots.edit', compact('foodspot'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Foodspot $foodspot)
    {
        // admin may update any foodspot

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'open_time' => 'nullable|string',
            'close_time' => 'nullable|string',
            'contact_number' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'category_tag' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'tagline' => 'nullable|string|max:255',
            'category' => 'nullable|string|max:100',
            'images' => 'nullable|array',
            'images.*' => 'image|mimes:jpg,jpeg,png,gif,webp|max:5120',
        ]);

        $foodspot->update($data);

        // handle new uploads (append)
        if ($request->hasFile('images')) {
            $existing = $foodspot->images ?? [];
            foreach ($request->file('images') as $file) {
                $path = $this->resizeAndStore($file, 'foodspots/'.$foodspot->id);
                $existing[] = $path;
            }
            $foodspot->images = $existing;
            $foodspot->save();
        }

        // handle thumbnail selection on update
        $thumbnailIndex = $request->input('thumbnail_index');
        if ($thumbnailIndex !== null) {
            $images = $foodspot->images ?? [];
            $idx = (int) $thumbnailIndex;
            if (isset($images[$idx])) {
                $foodspot->thumbnail = $images[$idx];
                $foodspot->save();
            }
        } else {
            // if no thumbnail provided and current thumbnail missing, set to first
            $images = $foodspot->images ?? [];
            if (! empty($images) && (empty($foodspot->thumbnail) || ! in_array($foodspot->thumbnail, $images, true))) {
                $foodspot->thumbnail = $images[0];
                $foodspot->save();
            }
        }

        return redirect()->route('admin.foodspots.index')->with('success', 'Foodspot updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Foodspot $foodspot)
    {
        // admin may delete any foodspot
        $foodspot->delete();

        return redirect()->route('admin.foodspots.index')->with('success', 'Foodspot deleted.');
    }

    /**
     * Remove an image from a foodspot.
     */
    public function destroyImage(Request $request, Foodspot $foodspot)
    {
        // admin may remove images from any foodspot
        $request->validate([
            'image_index' => 'required|integer|min:0',
        ]);

        $index = (int) $request->input('image_index');
        $images = $foodspot->images ?? [];

        if (! isset($images[$index])) {
            return back()->with('error', 'Image not found.');
        }

        $path = $images[$index];
        // delete file from storage
        if (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }

        // remove from array and save
        array_splice($images, $index, 1);
        $foodspot->images = $images;
        // adjust thumbnail if necessary
        if (! empty($foodspot->thumbnail) && $foodspot->thumbnail === $path) {
            $foodspot->thumbnail = count($images) ? $images[0] : null;
        }
        $foodspot->save();

        return back()->with('success', 'Image removed.');
    }

    /**
     * Resize an uploaded image and store it on the public disk.
     * Returns the storage path.
     */
    private function resizeAndStore($file, string $directory)
    {
        try {
            $mime = $file->getMimeType();
            $ext = $file->getClientOriginalExtension();

            // create image resource from uploaded file
            $src = null;
            if ($mime === 'image/jpeg' || $mime === 'image/jpg') {
                $src = @imagecreatefromjpeg($file->getRealPath());
                $ext = 'jpg';
            } elseif ($mime === 'image/png') {
                $src = @imagecreatefrompng($file->getRealPath());
                $ext = 'png';
            } elseif ($mime === 'image/gif') {
                $src = @imagecreatefromgif($file->getRealPath());
                $ext = 'gif';
            } elseif ($mime === 'image/webp' && function_exists('imagecreatefromwebp')) {
                $src = @imagecreatefromwebp($file->getRealPath());
                $ext = 'webp';
            }

            // if we couldn't create a resource, fallback to storing original
            if (! $src) {
                return $file->store($directory, 'public');
            }

            $max = 1200; // max width / height
            $width = imagesx($src);
            $height = imagesy($src);

            $ratio = $width / $height;
            if ($width > $max || $height > $max) {
                if ($ratio > 1) {
                    $newW = $max;
                    $newH = intval($max / $ratio);
                } else {
                    $newH = $max;
                    $newW = intval($max * $ratio);
                }
            } else {
                $newW = $width;
                $newH = $height;
            }

            $dst = imagecreatetruecolor($newW, $newH);

            // preserve transparency for PNG/GIF/WebP
            if (in_array($ext, ['png', 'gif', 'webp'])) {
                imagecolortransparent($dst, imagecolorallocatealpha($dst, 0, 0, 0, 127));
                imagealphablending($dst, false);
                imagesavealpha($dst, true);
            }

            imagecopyresampled($dst, $src, 0, 0, 0, 0, $newW, $newH, $width, $height);

            ob_start();
            $quality = 85;
            if ($ext === 'png') {
                imagepng($dst);
            } elseif ($ext === 'gif') {
                imagegif($dst);
            } elseif ($ext === 'webp' && function_exists('imagewebp')) {
                imagewebp($dst, null, $quality);
            } else {
                imagejpeg($dst, null, $quality);
                $ext = 'jpg';
            }
            $contents = ob_get_clean();

            imagedestroy($src);
            imagedestroy($dst);

            $filename = uniqid('', true).'.'.$ext;
            $path = rtrim($directory, '/').'/'.$filename;

            Storage::disk('public')->put($path, $contents);

            return $path;
        } catch (\Throwable $e) {
            // on any failure, fallback to default store
            return $file->store($directory, 'public');
        }
    }
}
