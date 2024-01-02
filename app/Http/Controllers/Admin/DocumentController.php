<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Student;
use App\User;
use App\Traits\FileUploader;
use Toastr;
use DB;

class DocumentController extends Controller
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
        $this->path = 'student';
    }

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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    try {
            if($request->type == "user"){
                $request->validate([
                    'photo' => 'nullable|image',
                    'signature' => 'nullable|image',
                    'resume' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar,csv,xls,xlsx,ppt,pptx|max:20480',
                    'joining_letter' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar,csv,xls,xlsx,ppt,pptx|max:20480',
                ]);
                $user = User::where('id', $request->user_id)->first();

                $user->photo = $this->updateImage($request, 'photo', $this->path, 300, 300, $user, 'photo');
                $user->signature = $this->updateImage($request, 'signature', $this->path, 300, 100, $user, 'signature');
                $user->resume = $this->updateMultiMedia($request, 'resume', $this->path, $user, 'resume');
                $user->joining_letter = $this->updateMultiMedia($request, 'joining_letter', $this->path, $user, 'joining_letter');
                $user->updated_by = Auth::guard('web')->user()->id;
                if(is_array($request->documents)){
                    $documents = $request->file('documents');
                    foreach($documents as $key =>$attach){

                        // Valid extension check
                        $valid_extensions = array('jpg','jpeg','png','gif','ico','svg','webp','pdf','doc','docx','txt','zip','rar','csv','xls','xlsx','ppt','pptx','mp3','avi','mp4','mpeg','3gp');
                        $file_ext = $attach->getClientOriginalExtension();
                        if(in_array($file_ext, $valid_extensions, true))
                        {

                        //Upload Files
                        $filename = $attach->getClientOriginalName();
                        $extension = $attach->getClientOriginalExtension();
                        $fileNameToStore = str_replace([' ','-','&','#','$','%','^',';',':'],'_',$filename).'_'.time().'.'.$extension;

                        // Move file inside public/uploads/ directory
                        $attach->move('uploads/'.$this->path.'/', $fileNameToStore);

                        // Insert Data
                        $document = new Document;
                        $document->title = $request->titles[$key];
                        $document->attach = $fileNameToStore;
                        $document->save();

                        // Attach
                        $document->users()->sync($user->id);

                        }
                    }
                }

            }else{
                $request->validate([
                    'student_id' => 'required',
                    'photo' => 'nullable|image',
                    'signature' => 'nullable|image',
                ]);
                //Store Student Documents
                $student = Student::where('id', $request->student_id)->first();
                $student->photo = $this->updateImage($request, 'photo', $this->path, 300, 300, $student, 'photo');
                $student->signature = $this->updateImage($request, 'signature', $this->path, 300, 100, $student, 'signature');
                $student->save();
                
                // Student Documents
                if(is_array($request->documents)){
                    $documents = $request->file('documents');
                    foreach($documents as $key =>$attach){
                        // Valid extension check
                        $valid_extensions = array('jpg','jpeg','png','gif','ico','svg','webp','pdf','doc','docx','txt','zip','rar','csv','xls','xlsx','ppt','pptx','mp3','avi','mp4','mpeg','3gp');
                        $file_ext = $attach->getClientOriginalExtension();
                        if(in_array($file_ext, $valid_extensions, true))
                        {
        
                        //Upload Files
                        $filename = $attach->getClientOriginalName();
                        $extension = $attach->getClientOriginalExtension();
                        $fileNameToStore = str_replace([' ','-','&','#','$','%','^',';',':'],'_',$filename).'_'.time().'.'.$extension;
        
                        // Move file inside public/uploads/ directory
                        $attach->move('uploads/'.$this->path.'/', $fileNameToStore);
        
                        // $text = trim($_POST['title']);
                        // $textAr = explode("\r\n", $text);
                        // $titles = array_filter($textAr, 'trim');

                        // foreach ($titles as $title) {
                        //     // Check if the name exists in the database
                        //     if (Document::where('title', $title)->exists()) {
                        //         Toastr::error(__('msg_name_already_exists'), __('msg_error'));
                        //         return redirect()->back()->withInput();
                        //     }
                        // }
            
                        $existType = $student->documents->where('type_id', $request->type_ids[$key])->first();
                        if($existType){
                            Toastr::error(__('msg_document_type_already_exists'), __('msg_error'));
                            return redirect()->back()->withInput();
                        }
                        // Insert Data
                        $document = new Document;
                        $document->title = $request->titles[$key];
                        $document->type_id = $request->type_ids[$key];
                        $document->attach = $fileNameToStore;
                        $document->save();
        
                        // Attach
                        $document->students()->sync($request->student_id);
        
                        }
                    }
                }
            }
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        } catch (\Throwable $th) {
            Toastr::error(__('msg_updated_error'), __('msg_error'));
            return redirect()->back();
        }
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
        try {
            $document = Document::where('id',$id)->first();
            if (!$document) {
                Toastr::error(__('Document not found!'), __('msg_error'));
                return redirect()->back();
            }
            $document->update([
                'title' => $request->title,
                'type_id' => $request->type_id,
            ]);
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        } catch (\Throwable $th) {
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
    public function destroy($id)
    {
        $document = Document::where('id',$id)->first();
            if (!$document) {
                Toastr::error(__('Document not found!'), __('msg_error'));
                return redirect()->back();
            }
            $document->delete();
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
        return redirect()->back();
    }
}
