<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\awards;
use App\Models\StaffResearcherId;
use App\User;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;


use Illuminate\Http\Request;
use Yoeunes\Toastr\Facades\Toastr;

class AwardsController extends Controller
{
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('Awards', 1);
        $this->route = 'admin.faculty-achievements.awards';
        $this->view = 'admin.faculty_achievements.awards';
        $this->path = 'awards-recognition';
        $this->access = 'awards-recognition';

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

            $data['staff_id']  = Auth::user()->staff_id;

            // $matching = Awards::where('id', '!=', null)
            // ->where('staff_id', auth()->user()->staff_id);

            // $other = Awards::where('id', '!=', null)
            // ->where('staff_id', '!=', auth()->user()->staff_id)
            // ->orderBy('staff_id', 'desc');

            // $data['awards'] = $matching->union($other)->get();

            // $data['awards'] = Awards::where('staff_id', auth()->user()->staff_id)
            // ->orderBy('date', 'desc')->get();
            $data['awards'] = [] ;
            $user = Auth::user();
            // return $user->getRoleNames();
            if ($user->hasRole('Teacher')){
                $data['awards'] = Awards::where('staff_id', auth()->user()->staff_id)->orderBy('date', 'desc')->get();
            } elseif ($user->hasRole('Super Admin') || $user->hasRole('Principal')){
                $data['awards'] = Awards::orderBy('date', 'desc')->get();

            } elseif ($user->hasRole('HoD')){
                $department_id = $user->department_id;
                $under_department_users =  User::where('department_id',$department_id)->pluck('staff_id');
                $data['awards'] = Awards::whereIn('staff_id', $under_department_users)->orderBy('date', 'desc')->get();
            }
            else
            {
                $data['awards'] = Awards::orderBy('id', 'desc')->get();

            }
            return view('admin.faculty_achievements.awards.index', $data);
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
        if ($request->hasFile('image')) {
            $attach = $request->file('image');
            $valid_extensions = array('jpg', 'jpeg', 'png', 'svg', 'webp', 'pdf', 'csv');
            $file_ext = $attach->getClientOriginalExtension();
            if (in_array($file_ext, $valid_extensions, true)) {

                $filename = $attach->getClientOriginalName();
                $extension = $attach->getClientOriginalExtension();

                $fileNameToStore =  time() . '_' . str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_', $filename);

                // Move file inside public/uploads/ directory
                $status = $attach->move('uploads/user/', $fileNameToStore);
              }  // return $status;

               }   // dd($request->all());
       $awards = new awards();


        $awards->staff_id = auth()->user()->staff_id;

       $awards->award_name = $request->award_name;
       $awards->awarding_agency = $request->awarding_agency;
       $awards->date = $request->date;
       $awards->image = $fileNameToStore;



       $awards->save();

       Toastr::success(__('msg_success'), __('msg_success'));

       return redirect()->back();
    }

    public function update(Request $request, $id)
   {
        $awards = Awards::find($id);

        if ($request->hasFile('image')) {
            $attach = $request->file('image');
            $valid_extensions = array('jpg', 'jpeg', 'png', 'svg', 'webp', 'pdf', 'csv');
            $file_ext = $attach->getClientOriginalExtension();
            if (in_array($file_ext, $valid_extensions, true)) {

                //Upload Files
                $filename = $attach->getClientOriginalName();
                $extension = $attach->getClientOriginalExtension();

                $fileNameToStore = time() . '_' .str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_', $filename);
                // return $fileNameToStore;
                // Move file inside public/uploads/ directory
                $status = $attach->move('uploads/user/', $fileNameToStore);
            }
          }else{
            $fileNameToStore = $awards->image;
          }
           // return $status;
        if($awards->staff_id != auth()->user()->staff_id)
        {
            Toastr::error(__('Un Authorized'), __('msg_error'));

            return redirect()->route($this->route.'.index');
        }

        $awards->award_name = $request->award_name;
        $awards->awarding_agency = $request->awarding_agency;
        $awards->date = $request->date;
        $awards->image = $fileNameToStore;

        $awards->update();

        Toastr::success(__('msg_success'), __('msg_success'));

        return redirect()->back();
   }

   public function destroy(Awards $award)
    {
     //  dd('12');
     //   $journal = Journal::find($id);

        $award->delete();

        Toastr::success(__('msg_success'), __('msg_deleted'));

        return redirect()->back();
    }



 }
