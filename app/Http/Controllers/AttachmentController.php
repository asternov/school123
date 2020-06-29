<?php

namespace App\Http\Controllers;

use App\Attachment;
use App\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AttachmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function store(Request $request, Lesson $lesson)
    {
        if ($request->file()) {
            foreach ($request->file()['files'] as $file) {
                Storage::disk('local')->put('public/attachments', $file);
                $path = Storage::url('attachments/' . $file->hashname());
                $lesson->attachments()->create(
                    [
                        'type' => (in_array($file->extension(), ['jpeg', 'png']) ? 'image' : 'file'),
                        'path' => $path,
                    ]
                );
            }
        }

        return response('');
    }

    public function show(Lesson $lesson)
    {
        return response()->json($lesson->attachments);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function edit(Attachment $attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Attachment $attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Attachment  $attachment
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Attachment $attachment)
    {
        unlink(storage_path() . str_replace('/storage', '/app/public', $attachment->path));
        $attachment->delete();
        return response()->json();
    }
}
