<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Image;

class UserController extends Controller
{
    public function avatarUpload(Request $request)
    {
        $file = $request->file('picture');
        $user = $request->user();
        $fileExtension = $file->getClientOriginalExtension();
        Image::make($file)
            ->resize(300, 300)
            ->save(public_path('avatars/' . $user->id . '.' . $fileExtension));
        $user->avatar = $user->id . '.' . $fileExtension . '/?key=' . Str::uuid();
        $user->save();
        return $user;
    }
}
