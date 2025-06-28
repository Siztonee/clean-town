<?php
namespace App\Services\Admin;

use App\Models\Gallery;
use App\Models\GalleryItem;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class GalleryItemService
{
    protected function storeMedia(UploadedFile $file, $gallery_id): string
    {
        return $file->store("gallery/{$gallery_id}", 'public');
    }

    public function createGalleryItem(int $gallery_id, array $medias): JsonResponse
    {   
        DB::beginTransaction();

        try {
            foreach ($medias as $media) {
                $path = $this->storeMedia($media, $gallery_id);
                
                $type = str_starts_with($media->getMimeType(), 'image/') ? 'image' : 'video';

                GalleryItem::create([
                    'gallery_id' => $gallery_id,
                    'type' => $type,
                    'path' => $path,
                    'size' => $media->getSize()
                ]);
            }
    
            DB::commit();

            return response()->json(['message' => 'Success'], 201);

        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
        
    }


    public function deleteGalleryItem(int $media_id): bool
    {
        $galleryItem = GalleryItem::findOrFail($media_id);
        return $galleryItem->delete();
    }
}