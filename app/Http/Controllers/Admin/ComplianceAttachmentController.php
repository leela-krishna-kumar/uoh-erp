<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ComplianceAttachment;
use App\Models\Compliance;
use App\Traits\FileUploader;
use Illuminate\Http\Request;
use Toastr;

class ComplianceAttachmentController extends Controller
{
    use FileUploader;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
         // Module Data
        $this->title = trans_choice('module_compliance_attachment', 1);
        $this->route = 'admin.compliance-attachment';
        $this->view = 'admin.compliance-attachment';
        $this->path = 'compliance-attachment';
        $this->access = 'compliance-attachment';
 
 
        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request,$id)
    {
        try{ 
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $complianceAttachments = ComplianceAttachment::query();
            $data['compliance'] = Compliance::where('id',$id)->first();

            $data['rows'] = $complianceAttachments->where('compliance_id',$id)->get();
            return view($this->view.'.index', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_error'), __('msg_error'));

            return redirect()->back();
        }
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'file' => 'required'
        ]);

        //Attachment Store
        $attachment = new ComplianceAttachment;
        $attachment->name = $request->name;
        $attachment->file = $this->uploadImage($request, 'file', $this->path, 300, 300);
        $attachment->compliance_id = $request->compliance_id;
        $attachment->save();

        Toastr::success(__('msg_created_successfully'), __('msg_success'));
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        try{
            $attachment = ComplianceAttachment::where('id',$id)->first();
                $request->validate([
                    'name' => 'required',
                ]);
            
            // Update Data
            $attachment->name = $request->name;
            $attachment->compliance_id = $request->compliance_id;
            $attachment->file = $this->updateImage($request, 'file', $this->path, 300, 300, $attachment, 'file');
            $attachment->save();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back();
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ComplianceAttachment $complianceAttachment,$id)
    {
        try{
            $attachment = ComplianceAttachment::where('id',$id)->first();
            if($attachment){
                $attachment->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
