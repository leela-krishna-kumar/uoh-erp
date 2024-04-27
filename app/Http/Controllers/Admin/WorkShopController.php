<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\StaffWorkShop;
use App\User;
use Toastr;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Crypt;

class WorkShopController extends Controller
{

    public function __construct()
    {
        $this->title = trans_choice('Workshops Attended', 1);
        $this->route = 'admin.workshops-attended';
        $this->view = 'admin.faculty_achievements.attended_workshops';
        $this->path = 'workshops-attended';
        $this->access = 'workshops-attended';

        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);

    }

    public function index(Request $request)
    {
        try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;

            // $matching = StaffWorkShop::where('id', '!=', null)
            // ->where('staff_id', auth()->user()->staff_id);

            // $other = StaffWorkShop::where('id', '!=', null)
            // ->where('staff_id', '!=', auth()->user()->staff_id)
            // ->orderBy('staff_id', 'desc');

            // $data['workshops'] = $matching->union($other)->get();

            // $data['workshops'] = StaffWorkShop::where('staff_id', auth()->user()->staff_id)->get();
            $data['workshops'] = [] ;
            $user = Auth::user();
            if ($user->hasRole('Teacher')){
                $workshops = StaffWorkShop::where('staff_id', auth()->user()->staff_id);

                if($request->type != null && $request->type != '')
                {
                    $workshops->where('workshop_type', $request->type);
                }

                if($request->from_date != null && $request->from_date != '')
                {
                    $workshops->where('from_date', '>=', $request->from_date);
                }

                if($request->to_date != null && $request->to_date != '')
                {
                    $workshops->where('to_date', '<=', $request->to_date);
                }
                $data['workshops'] = $workshops->get();
            }
            elseif ($user->hasRole('Super Admin') || $user->hasRole('Principal')){
                $workshops = StaffWorkShop::query();

                if($request->type != null && $request->type != '')
                {
                    $workshops->where('workshop_type', $request->type);
                }


                if($request->from_date != null && $request->from_date != '')
                {
                    $workshops->where('from_date', '>=', $request->from_date);
                }

                if($request->to_date != null && $request->to_date != '')
                {
                    $workshops->where('to_date', '<=', $request->to_date);
                }

                $data['workshops'] = $workshops->orderBy('id', 'desc')->limit(10)->get();
            }
            elseif ($user->hasRole('HoD')){
                $workshops = StaffWorkShop::where('staff_id', auth()->user()->staff_id);

                if($request->type != null && $request->type != '')
                {
                    $workshops->where('workshop_type', $request->type);
                }

                if($request->from_date != null && $request->from_date != '')
                {
                    $workshops->where('from_date', '>=', $request->from_date);
                }

                if($request->to_date != null && $request->to_date != '')
                {
                    $workshop->where('to_date', '<=', $request->to_date);
                }
                $data['workshops'] = $workshops->orderBy('id', 'desc')->limit(10)->get();
            }else{
                $workshops = StaffWorkShop::orderBy('id', 'desc')->get();
            }

            return view('admin.faculty_achievements.conducted_workshops.index', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    public function store(Request $request)
    {
        try{
            $workshop = new StaffWorkShop();
        $workshop->staff_id = auth()->user()->staff_id;
        $workshop->workshop_name = $request->workshop_name;
        $workshop->workshop_type = $request->workshop_type;
        $workshop->no_of_participants = $request->no_of_participants;
        $workshop->from_date = $request->from_date;
        $workshop->to_date = $request->to_date;
        $workshop->brochure_link = $request->brochure_link;

        if ($request->hasFile('brochure_attach')) {
            $attach = $request->file('brochure_attach');
            $valid_extensions = array('jpg', 'jpeg', 'png', 'svg', 'webp', 'pdf', 'csv');
            $file_ext = $attach->getClientOriginalExtension();
            if (in_array($file_ext, $valid_extensions, true)) {
                $filename = $attach->getClientOriginalName();
                $extension = $attach->getClientOriginalExtension();
                $brochurefileNameToStore =  time() . '_' . str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_', $filename);
                $status = $attach->move('uploads/user/', $brochurefileNameToStore);
                $workshop->brochure_attach = $brochurefileNameToStore;
            }
        }

        if ($request->hasFile('certificate_attach')) {
            $attach = $request->file('certificate_attach');
            $valid_extensions = array('jpg', 'jpeg', 'png', 'svg', 'webp', 'pdf', 'csv');
            $file_ext = $attach->getClientOriginalExtension();
            if (in_array($file_ext, $valid_extensions, true)) {
                $filename = $attach->getClientOriginalName();
                $extension = $attach->getClientOriginalExtension();
                $certificatefileNameToStore =  time() . '_' . str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_', $filename);
                $status = $attach->move('uploads/user/', $certificatefileNameToStore);
                $workshop->certificate_attach = $certificatefileNameToStore;
            }
        }
        $workshop->certificate_link = $request->certificate_link;

        if ($request->hasFile('schedule_attach')) {
            $attach = $request->file('schedule_attach');
            $valid_extensions = array('jpg', 'jpeg', 'png', 'svg', 'webp', 'pdf', 'csv');
            $file_ext = $attach->getClientOriginalExtension();
            if (in_array($file_ext, $valid_extensions, true)) {
                $filename = $attach->getClientOriginalName();
                $extension = $attach->getClientOriginalExtension();
                $schedule_attachfileNameToStore =  time() . '_' . str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_', $filename);
                $status = $attach->move('uploads/user/', $schedule_attachfileNameToStore);
                $workshop->schedule_attach = $schedule_attachfileNameToStore;
            }
        }
        $workshop->schedule_link = $request->schedule_link;

        $workshop->save();
        Toastr::success(__('Conducted Workshop Data stored Successfully.'), __('msg_success'));
        return redirect()->route($this->route.'.index');
        } catch(\Exception $e){
            Toastr::error(__('msg_stored_error'), __('msg_error'));

            return redirect()->route($this->route.'.index');
        }
    }

    public function update(Request $request, $id)
    {
       try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;

            $workshop = StaffWorkShop::findOrFail($id);
            if($workshop->staff_id != auth()->user()->staff_id)
            {
                Toastr::error(__('Un Authorized'), __('msg_error'));

                return redirect()->route($this->route.'.index');
            }
            if($workshop)
            {
                $workshop->workshop_name = $request->workshop_name;
                $workshop->workshop_type = $request->workshop_type;
                $workshop->no_of_participants = $request->no_of_participants;
                $workshop->from_date = $request->from_date;
                $workshop->to_date = $request->to_date;
                $workshop->brochure_link = $request->brochure_link;

                if ($request->hasFile('brochure_attach')) {
                    $attach = $request->file('brochure_attach');
                    $valid_extensions = array('jpg', 'jpeg', 'png', 'svg', 'webp', 'pdf', 'csv');
                    $file_ext = $attach->getClientOriginalExtension();
                    if (in_array($file_ext, $valid_extensions, true)) {
                        $filename = $attach->getClientOriginalName();
                        $extension = $attach->getClientOriginalExtension();
                        $brochurefileNameToStore =  time() . '_' . str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_', $filename);
                        $status = $attach->move('uploads/user/', $brochurefileNameToStore);
                        $workshop->brochure_attach = $brochurefileNameToStore;
                    }
                }

                if ($request->hasFile('certificate_attach')) {
                    $attach = $request->file('certificate_attach');
                    $valid_extensions = array('jpg', 'jpeg', 'png', 'svg', 'webp', 'pdf', 'csv');
                    $file_ext = $attach->getClientOriginalExtension();
                    if (in_array($file_ext, $valid_extensions, true)) {
                        $filename = $attach->getClientOriginalName();
                        $extension = $attach->getClientOriginalExtension();
                        $certificatefileNameToStore =  time() . '_' . str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_', $filename);
                        $status = $attach->move('uploads/user/', $certificatefileNameToStore);
                        $workshop->certificate_attach = $certificatefileNameToStore;
                    }
                }
                $workshop->certificate_link = $request->certificate_link;

                if ($request->hasFile('schedule_attach')) {
                    $attach = $request->file('schedule_attach');
                    $valid_extensions = array('jpg', 'jpeg', 'png', 'svg', 'webp', 'pdf', 'csv');
                    $file_ext = $attach->getClientOriginalExtension();
                    if (in_array($file_ext, $valid_extensions, true)) {
                        $filename = $attach->getClientOriginalName();
                        $extension = $attach->getClientOriginalExtension();
                        $schedule_attachfileNameToStore =  time() . '_' . str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_', $filename);
                        $status = $attach->move('uploads/user/', $schedule_attachfileNameToStore);
                        $workshop->schedule_attach = $schedule_attachfileNameToStore;
                    }
                }
                $workshop->schedule_link = $request->schedule_link;

                $workshop->save();
                Toastr::success(__('Workshop Data updated Successfully.'), __('msg_success'));
                return redirect()->route($this->route.'.index');
            }
        } catch(\Exception $e){
            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->route($this->route.'.index');
        }
   }

   public function destroy($id)
    {
        $publish = StaffWorkShop::findOrFail($id);
        $publish->delete();
        Toastr::success(__('msg_success'), __('Workshop is deleted Successfully'));

        return redirect()->route($this->route.'.index');
    }

    public function getWorkshopData(Request $request)
    {

    }
}
