<?php

namespace App\Listeners;

use App\Events\UploadCompleteEvent;
use App\Models\Cpattachment;
use App\Models\Cspattachment;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Auth;

class UploadCompleteListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UploadCompleteEvent $event
     * @return void
     */
    public function handle(UploadCompleteEvent $event)
    {
        $operator_id = Auth::guard('admin')->user();
//        dd($operator_id);
        $project_id = $event->request->project_id;
//        Cpattachment::create(['mimetype' => $event->receiver->file->getMimeType(),
//            'name' => $event->request->max_file_name]);
    }

    //上传项目文件
    private function _uploadProjectFile($project_id, $filename, $dir, $operator_id, $mimetype)
    {
        Cpattachment::create(['project_id' => $project_id, 'name' => $filename, 'dir' => $dir,
            'operator_id' => $operator_id, 'mimetype' => $mimetype]);
    }

    //上传子项目文件
    private function _uploadSonProjectFile($project_id, $filename, $dir, $operator_id, $mimetype, $check_status = 0)
    {
        Cspattachment::create(['project_id' => $project_id, 'name' => $filename, 'dir' => $dir,
            'operator_id' => $operator_id, 'mimetype' => $mimetype, 'check_status' => $check_status]);
    }
}
