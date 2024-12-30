<?php

namespace App\Http\Services\Admin;

use App\Enums\StatusEnum;
use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class DepartmentService extends Controller
{
    public function saveDepartment($data): bool {
        
        $flag = false;
        $item_id = $data['id'];
        $item_name = $data['name'];
        $item_description = $data['description'];
        $item_image = '';

        if (array_key_exists('previews', $data)) {

            $paths = getFilePaths();
            $location = $paths['department']['path'];
            $size = $paths['department']['size'];
            $item_image_url = $data['previews']['icon_with_landscape_preview']['icon_url'];
            $item_image = $this->processAndStoreImage($item_image_url, $location, $size);
        }

        $departmentData = [
            'id' => $item_id,
            'name' => $item_name,
            'slug' => Str::slug($item_name),
            'description' => $item_description,
            'image' => $item_image,
            'envato_payload' => $data,
            'status' => StatusEnum::true->status()
        ];

        try {
            $this->createOrUpdateDepartment($departmentData);
            $flag = true; 
        } catch (\Exception $e) {
        }
        return $flag; 
    }

    protected function createOrUpdateDepartment(array $data)
    {
        $department = Department::updateOrCreate(
            ['envato_item_id' => $data['id']],
            values: [
                'name' => $data['name'],
                'slug' => $data['slug'],
                'description' => $data['description'],
                'image' => $data['image'],
                'envato_payload' => $data['envato_payload'],
                'status' => $data['status']
            ]
        );
        $department->save();
    }

    public function processAndStoreImage(string $imageUrl, string $location, string $size)
    {
        try {
            $image_content   = file_get_contents($imageUrl);
            $temp_image      = tmpfile();
            $temp_image_path = stream_get_meta_data($temp_image)['uri'];
            file_put_contents($temp_image_path, $image_content);
            $file = new \Illuminate\Http\UploadedFile($temp_image_path, basename($imageUrl));
            $stored_image_name = storeImage($file, $location, $size);
            return $stored_image_name;
        } catch (\Exception $e) {
            return '';
        }
    }
}