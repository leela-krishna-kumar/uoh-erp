<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\StudentEnroll;
use App\Models\Session;
use App\Models\Program;
use App\Models\Section;
use App\Models\Student;
use App\Models\Faculty;
use App\Models\StatusType;
use App\Models\Province;
use App\Models\Batch;
use App\Models\Semester;
use App\Models\ProjectCategory;
use Illuminate\Http\Request;
use Toastr;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_project', 1);
        $this->route = 'student.projects';
        $this->view = 'student.projects';
        $this->path = 'student-projects';
        $this->access = 'student-projects';

    }

    public function index(Request $request)
    {
        try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;

            $projects = Project::query();

            if(request()->has('project_category_id') && request()->get('project_category_id') != null) {
                $projects->where('project_category_id',request()->get('project_category_id'));
            }

            $data['rows'] = $projects->where('type',Student::class)->where('type_id',auth()->id())->get();
            $data['categories'] = ProjectCategory::orderBy('name', 'asc')->select('name','id')->get();
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

    public function create(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['categories'] = ProjectCategory::orderBy('name', 'asc')->select('name','id')->get();
        return view($this->view.'.create', $data);
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
            'title' => 'required',
            'project_category_id' => 'required',
        ]);
        // Insert Data
        $student = Student::where('id',auth()->id())->select('id','program_id')->first();
        $program = Program::where('id',$student->program_id)->first();
        $enroll = StudentEnroll::where('id',$student->id)->first();
        
        $project = new Project;
        $project->program_id = @$enroll->program_id;
        $project->faculty_id = $program->faculty_id;
        $project->session_id = @$enroll->session_id;
        $project->semester_id = @$enroll->semester_id;
        $project->section_id = @$enroll->section_id;
        $project->title = $request->title;
        $project->description = $request->description;
        $project->status = Project::STATUS_DRAFT;
        $project->project_category_id = $request->project_category_id;
        $project->type = Student::class;
        $project->type_id = $student->id;
        $project->save();

        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
   
       $data['title'] = $this->title;
       $data['route'] = $this->route;
       $data['view'] = $this->view;
       $data['path'] = $this->path;

       $data['row'] = $project;
       $data['project_categories'] = ProjectCategory::orderBy('name', 'asc')->select('id','name')->get();
       $data['statuses'] = Project::STATUSES;


       return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        try{
                // Field Validation
            $request->validate([
                'title' => 'required',
            ]);
            // Update Data
            $project->title = $request->title;
            $project->description = $request->description;
            $project->project_category_id = $request->project_category_id;
            $project->save();
            
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
     * @param  \App\Models\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        try{
            if($project){
                $project->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
