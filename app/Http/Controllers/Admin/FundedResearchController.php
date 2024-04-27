<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FundedResearch;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Yoeunes\Toastr\Facades\Toastr;

class FundedResearchController extends Controller
{
    public function __construct()
    {
        $this->title = trans_choice('funded_research_consultancy_projects', 1);
        $this->route = 'admin.funded-research';
        $this->view = 'admin.faculty_achievements.funded-research';
        $this->path = 'funded-research';
        $this->access = 'funded-research';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        // return $user->getRoleNames();
        // return $data = $user->hasRole('Super Admin');
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;

            $data['staff_id']  = Auth::user()->staff_id;

            // $matching = FundedResearch::where('id', '!=', null)
            // ->where('staff_id', auth()->user()->staff_id);

            // $other = FundedResearch::where('id', '!=', null)
            // ->where('staff_id', '!=', auth()->user()->staff_id)
            // ->orderBy('staff_id', 'desc');

            // $data['funded_research'] = $matching->union($other)->get();
            $data['funded_research'] = [];
            $user = Auth::user();
            if ($user->hasRole('Teacher')){
                $data['funded_research'] = FundedResearch::where('staff_id', $user->staff_id)->orderBy('id', 'desc')->get();
            } elseif ($user->hasRole('Super Admin')|| $user->hasRole('Principal')){
                $data['funded_research'] = FundedResearch::orderBy('id', 'desc')->get();
            } elseif ($user->hasRole('HoD')){
                $department_id = $user->department_id;
                $under_department_users =  User::where('department_id',$department_id)->pluck('staff_id');
                $data['funded_research'] = FundedResearch::whereIn('staff_id',$under_department_users)->orderBy('id', 'desc')->get();
            }else{
                $data['funded_research'] = FundedResearch::orderBy('id', 'desc')->get();
            }

           

            return view($this->view.'.index', $data);
        } catch(\Exception $e){
            Toastr::error(__('msg_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try{
            $research = new FundedResearch();
            $research->staff_id = Auth::user()->staff_id;
            $research->pi_or_co_pi = $request->pi_or_co_pi_name;
            $research->funding_agency = $request->funding_agency;
            $research->sponsored_project = $request->sponsord_project;
            $research->funds_provided = $request->funds_provided;
            $research->grant_month_and_year = $request->grant_month_year;
            $research->project_duration = $request->project_duration;
            $research->type = $request->type;
            $research->status = $request->status;
            $research->save();

            Toastr::success(__('Funded Research & Consultancy Projects stored Successfully.'), __('msg_success'));
            return redirect()->route($this->route.'.index');
        } catch(\Exception $e){
            Toastr::error(__('msg_stored_error'), __('msg_error'));

            return redirect()->route($this->route.'.index');
        }
    }

    public function update(Request $request)
    {
        try{
            $research = FundedResearch::find($request->research_id);

            if($research->staff_id != auth()->user()->staff_id)
        {
            Toastr::error(__('Un Authorized'), __('msg_error'));

            return redirect()->route($this->route.'.index');
        }
            // $research->staff_id = Auth::user()->staff_id;
            $research->pi_or_co_pi = $request->pi_or_co_pi_name;
            $research->funding_agency = $request->funding_agency;
            $research->sponsored_project = $request->sponsord_project;
            $research->funds_provided = $request->funds_provided;
            $research->grant_month_and_year = $request->grant_month_year;
            $research->project_duration = $request->project_duration;
            $research->type = $request->type;
            $research->status = $request->status;
            $research->save();

            Toastr::success(__('Funded Research & Consultancy Projects updated Successfully.'), __('msg_success'));
            return redirect()->back();
        } catch(\Exception $e){
            Toastr::error(__('msg_stored_error'), __('msg_error'));

            return redirect()->back();
        }
    }
    public function destroy(Request $request)
    {

        try {
            $research = FundedResearch::find($request->research_id);
            $research->delete();

            Toastr::success(__('msg_success'), __('msg_deleted'));
            return redirect()->back();

        }catch(\Exception $e){
            Toastr::error(__('msg_stored_error'), __('msg_error'));
            return redirect()->back();
        }
    }
}
