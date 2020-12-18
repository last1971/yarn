<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PictureRequest;
use App\Models\Category;
use App\Models\Picture;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class PictureController extends Controller
{
    private $models = [
        'category' => Category::class,
    ];

    public function store(PictureRequest $request)
    {
        $file = $request->file('picture');
        $id = $request->get('id');
        $class = new $this->models[$request->get('model')];
        $model = $class->find($id);
        if (!Storage::disk('public')->exists('pictures/' . $model->slug . '/' . $id)) {
            Storage::disk('public')->makeDirectory('pictures/' . $model->slug . '/' . $id);
        }
        $name = Str::uuid() . '.' . $file->getClientOriginalExtension();
        Image::make($file)->save(public_path('pictures/' . $model->slug . '/' . $id . '/' . $name));
        return $model->pictures()->save(new Picture(['file' => $name]));
    }
}
