<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\StaffResearcherId;
use Toastr;

class ResearchController extends Controller
{
   public function store(Request $request)
   {

    $i=0;

  //  dd($request->all());

    try{
        $request->validate([
            'user_id' => 'required|numeric',
        ]);
        
        if($request->vidwan_id == null)
        {
            $vidwan_id = '';
        } else {
            $vidwan_id = $request->vidwan_id;
            $i=1;
        }

        if($request->orcid_id == null)
        {
            $orcid_id = '';
        } else {
            $orcid_id = $request->orcid_id;
            $i=1;
        }

        if($request->researcher_id == null)
        {
            $researcher_id = '';
        } else {
            $researcher_id = $request->researcher_id;
            $i=1;
        }

        if($request->scopus_id == null)
        {
            $scopus_id = '';
        } else {
            $scopus_id = $request->scopus_id;
            $i=1;
        }

        if($request->google_scholar_id == null)
        {
            $google_scholar_id = '';
        } else {
            $google_scholar_id = $request->google_scholar_id;
            $i=1;
        }

        if($request->wos_id == null)
        {
            $wos_id = '';
        } else {
            $wos_id = $request->wos_id;
            $i=1;
        }

        if($i == 0){
            return redirect()->back();
        }

        $research_staff = StaffResearcherId::create([
            'user_id' => $request->user_id,
            'staff_id' => $request->staff_id,
            'vidwan_id' => $vidwan_id,
            'orcid_id' => $orcid_id,
            'researcher_id' => $researcher_id,
            'scopus_id' => $scopus_id,
            'google_scholar_id' => $google_scholar_id,
            'wos_id' => $wos_id
        ]);
        Toastr::success(__('msg_stored_successfully'), __('msg_success'));
        return redirect()->back();
    }
    catch(\Exception $e){

        Toastr::error(__('msg_stored_error'), __('msg_error'));

        return redirect()->back();
    }
   }

   public function update(Request $request)
   {

    $i=0;

    try{
        $request->validate([
            'user_id' => 'required|numeric',
        ]);

        if($request->vidwan_id != null || $request->orcid_id != null || $request->researcher_id != null || $request->scopus_id != null || $request->google_scholar_id != null || $request->wos_id != null)
        {
            $i=1;
        } 

        if($i == 0){
            return redirect()->back();
        }

        $research_staff = StaffResearcherId::where('user_id', $request->user_id)->first();
        if($research_staff) 
        {
            $research_staff->update([
                'vidwan_id' => $request->vidwan_id,
                'orcid_id' => $request->orcid_id,
                'researcher_id' => $request->researcher_id,
                'scopus_id' => $request->scopus_id,
                'google_scholar_id' => $request->google_scholar_id,
                'wos_id' => $request->wos_id
            ]);
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back();
        }
    }
    catch(\Exception $e){

        Toastr::error(__('msg_updated_error'), __('msg_error'));
        return redirect()->back();
    }
   }
   public function destroy(StaffResearcherId $research)
    {
        if(!$research){
            return redirect()->back('error','Data Not Found!');
        }
        $research->delete();
        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
