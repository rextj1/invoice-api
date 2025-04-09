<?php

namespace App\Http\Controllers;

use App\Models\MediaUpload;
use App\Http\Requests\UploadMediaUploadRequest;
use App\Http\Resources\V1\MediaCollection;
use App\Http\Resources\V1\MediaResource;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MediaUploadController extends Controller
{
    public function getUploadedFiles()
    {
        //  return new MediaCollection(MediaUpload::all());
         $f = new MediaCollection(MediaUpload::paginate(13));

         info([$f]);
    }
    // public function getUploadedFiles()
    // {
    //     $files = MediaUpload::orderBy('created_at', 'desc')->get()->map(function ($file) {
    //         return [
    //             'id' => $file->id,
    //             'original_name' => $file->original_name,
    //             'url' => asset('storage/' . $file->stored_path), // ✅ Correct path
    //             'created_at' => $file->created_at,
    //         ];
    //     });

    //     return response()->json(['files' => $files]);
    // }

    public function uploadMedia(UploadMediaUploadRequest $request)
    {
        // ✅ Validate incoming request
        // $request->validate([
        //     'files' => 'required|array',
        //     'files.*' => 'file|mimes:jpg,jpeg,png,gif,mp4,mov,avi|max:10240',
        // ], [
        //     'files.required' => 'You must select at least one file.',
        //     'files.*.mimes' => 'Only images and videos (JPG, PNG, MP4, etc.) are allowed.',
        //     'files.*.max' => 'File size must not exceed 10MB.',
        // ]);

        if (!$request->hasFile('files')) {
            return response()->json(['message' => 'No files uploaded.'], 400);
        }

        $uploadedFiles = [];
        $duplicateFiles = [];

        foreach ($request->file('files') as $file) {
            $fileHash = md5_file($file->path()); // ✅ Generate unique hash

            // ✅ Check if file already exists in DB
            $existingFile = MediaUpload::where('hash', $fileHash)->first();
            if ($existingFile) {
                Log::warning("Duplicate file detected: " . $file->getClientOriginalName());

                $duplicateFiles[] = $file->getClientOriginalName(); // Track duplicates
                continue;
            }

            // ✅ Store the file in "storage/app/public/uploads"
            $storedPath = $file->store('uploads', 'public');

            // ✅ Save file details in DB
            $media = MediaUpload::create([
                'original_name' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'hash' => $fileHash,
                'stored_path' => $storedPath,
            ]);

            $uploadedFiles[] = [
                'id' => $media->id,
                'original_name' => $media->original_name,
                'url' => Storage::url($media->stored_path), // ✅ Generate URL dynamically
                'size' => $media->size,
                'created_at' => $media->created_at,
            ];

            Log::info("File uploaded: " . $file->getClientOriginalName());
        }

        // ✅ If duplicates were found, return an error response
        if (!empty($duplicateFiles)) {
            return response()->json([
                'message' => 'Some files were already uploaded.',
                'duplicates' => $duplicateFiles
            ], 422);
        }

        // ✅ If all files were uploaded successfully, return success response
        return response()->json(['files' => $uploadedFiles], 201);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MediaUpload $mediaUpload)
    {
        //
    }
}
