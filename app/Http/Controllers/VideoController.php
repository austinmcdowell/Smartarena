<?php

namespace App\Http\Controllers;

use Auth;
use DateTime;

use App\User;
use App\Human;
use App\Video;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function get($id)
    {
        $video = Video::find($id);
        $user = Auth::user();
        
        if ($user) {
            $user->human;
        }

        if (!$video) {
            return redirect('/');
        }

        return view('video', [
            'user' => $user
        ]);
    }
    
    public function data($id)
    {
        $video = Video::find($id);

        if (!$video) {
            return response()->json(['success' => false, 'message' => 'Something went wrong, please contact support.'], 401);
        }

        return $video;
    }

    public function upload(Request $request)
    {
        $user = Auth::user();
        $video_id = $request->input('videoId');
        $video = Video::find($video_id);
        $original_file = $request->file('video');
        $tmp_dir = sys_get_temp_dir();
        $mime_type = $original_file->getClientMimeType();
        $date = new DateTime;
        $original_filename = $original_file->getClientOriginalName();
        $filename = $user->id . "-" . $date->getTimestamp() . "-" . uniqid();
        
        // move the file to tmp so we can start processing
        $moved_file = $original_file->move($tmp_dir, $filename);

        // Create video data on table
        if (!$video) {
            $video = new Video;
        }
        
        $video->file_name = $filename;
        $video->processing_complete = false;
        $video->human_id = $user->human->id;

        $video->save();

        // Let's queue it up
        $this->dispatch(new \App\Jobs\ProcessVideo($video));
        
        return $video;
    }
}
