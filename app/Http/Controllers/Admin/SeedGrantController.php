<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Seedgrant;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Toastr;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class SeedGrantController extends Controller
{
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('seed_grant', 1);
        $this->route = 'admin.faculty-achievements.seed-grants';
        $this->view = 'admin.faculty_achievements.seed_grants';
        $this->path = 'seed_grant';
        $this->access = 'seed-grant';

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

            // $matching = Seedgrant::where('id', '!=', null)
            // ->where('staff_id', auth()->user()->staff_id);

            // $other = Seedgrant::where('id', '!=', null)
            // ->where('staff_id', '!=', auth()->user()->staff_id)
            // ->orderBy('staff_id', 'desc');

            // $data['seed_grants'] = $matching->union($other)->get();

            // $data['seed_grants'] = Seedgrant::where('staff_id', auth()->user()->staff_id)->get();
            $data['seed_grants'] = [];
            $user = Auth::user();
            if ($user->hasRole('Teacher')){
                $data['seed_grants'] = Seedgrant::where('staff_id', auth()->user()->staff_id)->orderBy('id', 'desc')->get();
            } elseif ($user->hasRole('Super Admin') || $user->hasRole('Principal')){
                $data['seed_grants'] = Seedgrant::orderBy('id', 'desc')->get();

            } elseif ($user->hasRole('HoD')){
                $department_id = $user->department_id;
                $under_department_users =  User::where('department_id',$department_id)->pluck('staff_id');
                $data['seed_grants'] = Seedgrant::whereIn('staff_id', $under_department_users)->orderBy('id', 'desc')->get();
            }else{
                $data['seed_grants'] = Seedgrant::orderBy('id', 'desc')->get();
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
    //    dd($request->all());

       $seedgrant = new Seedgrant();

    //    $pi = explode(',' , $request->pi);
    //    $co_pi = explode(',' , $request->co_pi);

      // dd($pi, $co_pi);


       $seedgrant->staff_id = auth()->user()->staff_id;;
       $seedgrant->department = auth()->user()->department_id;
       $seedgrant->application_no = $request->application_no;
       $seedgrant->title = $request->title;

       $seedgrant->duration_in_months = $request->duration_in_months;
       $seedgrant->scope = $request->scope;
       $seedgrant->research_area = $request->research_area;
       $seedgrant->amount_in_rupees = $request->amount_in_rupees;

    //   dd( $seed_grant);

       $seedgrant->save();

           $pi = explode(',' , $request->pi);
       $co_pi = explode(',' , $request->co_pi);

       $seedgrant = Seedgrant::find($seedgrant->id);

           $seedgrant->pi = $pi;
       $seedgrant->co_pi =  $co_pi;

       $seedgrant->update();

       Toastr::success(__('msg_success'), __('msg_success'));

       return redirect()->back();
    }

    public function update(Request $request, $id)
   {
        $seedgrant = Seedgrant::find($id);
        if($seedgrant->staff_id != auth()->user()->staff_id)
            {
                Toastr::error(__('Un Authorized'), __('msg_error'));

                return redirect()->route($this->route.'.index');
            }

        $pi = explode(',' , $request->pi);
       $co_pi = explode(',' , $request->co_pi);

      // dd($pi, $co_pi);


       $seedgrant->staff_id = Auth::user()->staff_id;
       $seedgrant->department = Auth::user()->department_id;
       $seedgrant->application_no = $request->application_no;
       $seedgrant->title = $request->title;
       $seedgrant->pi = array_values($pi);
       $seedgrant->co_pi = array_values( $co_pi);
       $seedgrant->duration_in_months = $request->duration_in_months;
       $seedgrant->scope = $request->scope;
       $seedgrant->research_area = $request->research_area;
       $seedgrant->amount_in_rupees = $request->amount_in_rupees;


        $seedgrant->update();

        Toastr::success(__('msg_success'), __('msg_success'));

        return redirect()->back();
   }

   public function destroy(Seedgrant $seed_grant)
    {
        $seed_grant->delete();

        Toastr::success(__('msg_success'), __('msg_deleted'));

        return redirect()->back();
    }

}
