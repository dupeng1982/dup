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
        $operator_id = $event->request->operator_id;
        $project_id = $event->request->project_id;
        $filename = $event->request->max_file_name;
        $mimetype = $event->receiver->file->getMimeType();
        $dir = $event->receiver->savedPath;
        $this->_uploadProjectFile($project_id, $filename, $dir, $operator_id, $mimetype);
    }

    //上传项目文件
    private function _uploadProjectFile($project_id, $filename, $dir, $operator_id, $mimetype)
    {
        Cpattachment::create(['project_id' => $project_id, 'name' => $filename, 'dir' => $dir,
            'operator_id' => $operator_id, 'mimetype' => $mimetype]);
    }
}
