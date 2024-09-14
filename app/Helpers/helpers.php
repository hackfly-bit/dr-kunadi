<?php

use Illuminate\Support\Facades\Storage;

if (!function_exists('paginate')) {
    function paginate($data, $page, $limit)
    {
        $total = $data->count();
        $skip = ($page - 1) * $limit;
        $data = $data->slice($skip, $limit);
        return [
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
        ];
    }
}

if (!function_exists('generateUniqueFileName')) {
    function generateUniqueFileName($file)
    {
        return uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
    }
}

if (!function_exists('removeFile')) {
    function removeFile($filePath)
    {
        if ($filePath && Storage::disk('public')->exists($filePath)) {
            Storage::disk('public')->delete($filePath);
        }
    }
}
