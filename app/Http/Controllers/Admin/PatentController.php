<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Patent;
use App\Models\StaffResearcherId;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Yoeunes\Toastr\Facades\Toastr;

class PatentController extends Controller
{
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('Patent', 1);
        $this->route = 'admin.faculty-achievements.patent';
        $this->view = 'admin.faculty_achievements.patent';
        $this->path = 'patents';
        $this->access = 'patents';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);

    }

    public function index()
    {
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;

            // $matching = Patent::where('id', '!=', null)
            // ->where('staff_id', auth()->user()->staff_id);

            // $other = Patent::where('id', '!=', null)
            // ->where('staff_id', '!=', auth()->user()->staff_id)
            // ->orderBy('staff_id', 'desc');

            // $data['patent'] = $matching->union($other)->get();

            // $data['patent'] = Patent::where('staff_id', auth()->user()->staff_id)
            // ->orderBy('patent_published_date', 'desc')->get();
            $data['patent'] = [] ;
            $user = Auth::user();
            if ($user->hasRole('Teacher')){
                $data['patent'] = Patent::where('staff_id', auth()->user()->staff_id)->orderBy('patent_published_date', 'desc')->get();
            } elseif ($user->hasRole('Super Admin') || $user->hasRole('Principal')){
                $data['patent'] = Patent::orderBy('patent_published_date', 'desc')->get();
            } elseif ($user->hasRole('HoD')){
                $department_id = $user->department_id;
                $under_department_users =  User::where('department_id',$department_id)->pluck('staff_id');
                $data['patent'] = Patent::whereIn('staff_id', $under_department_users)->orderBy('patent_published_date', 'desc')->get();
            }else{
                $data['patent'] = Patent::orderBy('id', 'desc')->get();

            }
            return view($this->view.'.index', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    public function create()
    {
        return "Hello";
    }


    public function store(Request $request)
    {
       // dd($request->all());

       $patent = new Patent();

    //    $name_of_the_author = explode(',' , $request->name_of_the_author);

    //    $patent->patent_application_no = Auth::user()->patent_application_no;
    //    $patent->status_of_patent = Auth::user()->status_of_patent;
    $patent->staff_id = auth()->user()->staff_id;

    // $patent->staff_id = $request->staff_id;
    $patent->patent_application_no = $request->patent_application_no;
    $patent->status_of_patent = $request->status_of_patent;

       $patent->patent_inventor = $request->patent_inventor;
       $patent->title_of_patent = $request->title_of_patent;
       $patent->patent_applicant = $request->patent_applicant;
       $patent->patent_published_date = $request->patent_published_date;
       $patent->link = $request->link;


       $patent->save();

       Toastr::success(__('msg_success'), __('msg_success'));

       return redirect()->back();
    }

    public function update(Request $request, $id)
   {
        $patent = Patent::find($id);
        if($patent->staff_id != auth()->user()->staff_id)
        {
            Toastr::error(__('Un Authorized'), __('msg_error'));

            return redirect()->route($this->route.'.index');
        }

        // $name_of_the_author = explode(',' , $request->name_of_the_author);

        // $journal->staff_id = Auth::user()->staff_id;
        // $journal->department_id = Auth::user()->department_id;
        $patent->patent_application_no = $request->patent_application_no;
        $patent->status_of_patent = $request->status_of_patent;
        $patent->patent_inventor = $request->patent_inventor;
        $patent->title_of_patent = $request->title_of_patent;
        $patent->patent_applicant = $request->patent_applicant;
        $patent->patent_published_date = $request->patent_published_date;
        $patent->link = $request->link;

        $patent->update();

        Toastr::success(__('msg_success'), __('msg_success'));

        return redirect()->back();
   }

   public function destroy(Patent $patent)
    {
       // dd('12');
     //   $journal = Journal::find($id);

        $patent->delete();

        Toastr::success(__('msg_success'), __('msg_deleted'));

        return redirect()->back();
    }

 }
