<?php
namespace App\Services\Admin;

use Illuminate\Http\UploadedFile;
use App\Models\Gallery;

class GalleryService
{
    protected function storeImage(UploadedFile $image): string
    {
        return $image->store('galleries', 'public');
    }

    public function createGallery(array $data, ?UploadedFile $image = null): Gallery
    {
        if (!$image) {
            return abort(403);
        }

        $data['preview'] = $this->storeImage($image);

        return Gallery::create($data);
    }

    public function updateGallery(Gallery $gallery, array $data, ?UploadedFile $image = null): bool
    {
        if ($image) {
            $data['preview'] = $this->storeImage($image);
        }

        return $gallery->update($data);
    }

    public function deleteGallery(Gallery $gallery): bool
    {
        return $gallery->delete();
    }
}