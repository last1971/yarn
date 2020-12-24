<?php


namespace App\Traits;


use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait SlugFromName
{
    /**
     * @param string $value
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     */
    public function setNameAttribute(string $value)
    {
        $slug = !empty($this->attributes['slug']) ? $this->attributes['slug'] : '';
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = Str::slug($value);
        if ($slug && $this->attributes['slug'] !== $slug) {
            Storage::disk('public')->rename(
                'pictures/' . $slug,
                'pictures/' . $this->attributes['slug'],
            );
        }
    }
}
