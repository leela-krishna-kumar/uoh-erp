<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileUploader;
use App\Models\Student;
use App\Models\Subject;
use App\Models\Program;
use App\Models\Note;
use Toastr;
use Auth;

class StudentNoteController extends Controller
{
    use FileUploader;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // dd("123");
        // Module Data
        $this->title = trans_choice('module_student_note', 1);
        $this->route = 'admin.student-note';
        $this->view = 'admin.student-note';
        $this->path = 'note';
        $this->access = 'student-note';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $notes = Note::query();

        if(request()->has('program') && request()->get('program') != null) {
            $notes->where('program_id',request()->get('program'));
        }
        if(request()->has('subject') && request()->get('subject') != null) {
            $notes->where('subject_id',request()->get('subject'));
        }
        if(request()->has('noteable_id') && request()->get('noteable_id') != null) {
            $notes->where('noteable_id',request()->get('noteable_id'));
        }

        $programSubjects = Subject::where('status', 1);
        $programSubjects->with('programs')->whereHas('programs', function ($query) use ($data){
            $query->where('program_id', request()->program);
        });
        $data['subjects']  = $programSubjects->orderBy('code', 'asc')->get();

        if(auth()->user()->designation_id == 33){

            // dd('123');

              $program_ids = json_decode(auth()->user()->program_ids);

              $data['programs'] = Program::where('status', '1')->whereIn('id', $program_ids)->orderBy('title', 'asc')->get();

            }else{
            $data['programs'] = Program::where('status', '1')->orderBy('title', 'asc')->get();
          }



        $data['students'] = Student::where('program_id',request()->program)->get();

        $data['rows'] = $notes->where('noteable_type', 'App\Models\Student')->orderBy('id', 'desc')->get();

        return view($this->view.'.index', $data);
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
        // Field Validation
        $request->validate([
            'student' => 'required',
            'title' => 'required|max:191',
            'note' => 'required',
            'attach' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar,csv,xls,xlsx,ppt,pptx|max:20480',
        ]);

        $student = Student::findOrFail($request->student);

        // Insert Data
        $note = new Note();
        $note->title = $request->title;
        $note->description = $request->note;
        $note->program_id = $request->program;
        $note->subject_id = $request->subject;
        $note->attach = $this->uploadMedia($request, 'attach', $this->path);
        $note->created_by = Auth::guard('web')->user()->id;

        $student->notes()->save($note);


        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function show(Note $note)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function edit(Note $note)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Field Validation
        $request->validate([
            'title' => 'required|max:191',
            'note' => 'required',
            'attach' => 'nullable|file|mimes:jpg,jpeg,png,pdf,doc,docx,zip,rar,csv,xls,xlsx,ppt,pptx|max:20480',
        ]);

        // Update Data
        $note = Note::findOrFail($id);
        $note->title = $request->title;
        $note->description = $request->note;
        $note->attach = $this->updateMedia($request, 'attach', $this->path, $note);
        $note->status = $request->status;
        $note->updated_by = Auth::guard('web')->user()->id;
        $note->save();


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Note  $note
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete Attach
        $note = Note::findOrFail($id);
        $this->deleteMedia($this->path, $note);

        // Delete data
        $note->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
