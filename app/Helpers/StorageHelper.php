<?php

if (!function_exists('uploadFile')) {
    /**
     * Upload file to public/uploads directory (shared hosting compatible)
     * 
     * @param \Illuminate\Http\UploadedFile $file
     * @param string $folder
     * @return string
     */
    function uploadFile($file, $folder = 'uploads')
    {
        // Create folder structure in public/uploads
        $path = public_path('uploads/' . $folder);
        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        // Generate unique filename
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        
        // Move file
        $file->move($path, $filename);
        
        // Return relative path for database storage
        return 'uploads/' . $folder . '/' . $filename;
    }
}

if (!function_exists('getFileUrl')) {
    /**
     * Get public URL for uploaded file
     * 
     * @param string $path
     * @return string
     */
    function getFileUrl($path)
    {
        if (empty($path)) {
            return asset('images/placeholder.png');
        }

        // If already full URL, return as is
        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        // Remove 'uploads/' prefix if exists (for backward compatibility)
        $path = ltrim($path, 'uploads/');
        $path = ltrim($path, '/');

        // Return asset URL
        return asset($path);
    }
}

if (!function_exists('deleteFile')) {
    /**
     * Delete uploaded file
     * 
     * @param string $path
     * @return bool
     */
    function deleteFile($path)
    {
        if (empty($path)) {
            return false;
        }

        $filePath = public_path($path);
        
        if (file_exists($filePath)) {
            return unlink($filePath);
        }

        return false;
    }
}

