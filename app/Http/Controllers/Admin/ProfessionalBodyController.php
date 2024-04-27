<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProfessionalBody;
use Illuminate\Http\Request;
use Toastr;

class ProfessionalBodyController extends Controller
{
    public function store(Request $request)
    {
      
        if ($request->hasFile('idcard')) {
            $attach = $request->file('idcard');
            $valid_extensions = array('jpg', 'jpeg', 'png', 'svg', 'webp', 'pdf', 'csv');
            $file_ext = $attach->getClientOriginalExtension();
            if (in_array($file_ext, $valid_extensions, true)) {

                //Upload Files
                $filename = $attach->getClientOriginalName();
                $extension = $attach->getClientOriginalExtension();

                $fileNameToStore =  time() . '_' . str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_', $filename);
    
                // Move file inside public/uploads/ directory
                $status = $attach->move('uploads/student/', $fileNameToStore);
                // return $status;

                $professions_array = [
                    '0' => 'IEEE',
                    '1' => 'IETE',
                    '2' => 'ISTE',
                    '3' => 'CSI',
                    '4' => 'IEI',
                    '5' => 'ACE',
                    '6' => 'others'
                ];
                // Insert Data
                $membership = new ProfessionalBody();
                $membership->user_id = $request->user_id;
                $membership->profession_id = $request->profession_id;
                $membership->membership_name = $professions_array[$request->profession_id];
                $membership->membership_id = $request->membership_id;
                $membership->others_membership_type = $request->others_membership_type;
                $membership->idcard = $fileNameToStore;
                $membership->save();
                if ($membership) {
                    Toastr::success(__('msg_updated_successfully'), __('msg_success'));
                    return redirect()->back()->with(__('msg_success'), __('msg_updated_successfully'));
                }
            }
        } else {
            Toastr::error('File not detected ', __('msg_error'));
            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request)
    {
        // return $request->all();
        if ($request->hasFile('idcard')) {
            $attach = $request->file('idcard');
            $valid_extensions = array('jpg', 'jpeg', 'png', 'svg', 'webp', 'pdf', 'csv');
            $file_ext = $attach->getClientOriginalExtension();
            if (in_array($file_ext, $valid_extensions, true)) {

                //Upload Files
                $filename = $attach->getClientOriginalName();
                $extension = $attach->getClientOriginalExtension();

                $fileNameToStore = time() . '_' .str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_', $filename);
                // return $fileNameToStore;
                // Move file inside public/uploads/ directory
                $status = $attach->move('uploads/student/', $fileNameToStore);
               // return $status;

                $professions_array = [
                    '0' => 'IEEE',
                    '1' => 'IETE',
                    '2' => 'ISTE',
                    '3' => 'CSI',
                    '4' => 'IEI',
                    '5' => 'ACE',
                    '6' => 'others'
                ];
                // Insert Data
                $membership = ProfessionalBody::where('id', $request->profesion_model_id)->first();
                // $membership->user_id = $request->user_id;
                $membership->profession_id = $request->profession_id;
                $membership->membership_name = $professions_array[$request->profession_id];
                $membership->membership_id = $request->membership_id;
                $membership->others_membership_type = $request->others_membership_type;
                $membership->idcard = $fileNameToStore;
                $membership->save();
                if ($membership) {
                    Toastr::success(__('msg_updated_successfully'), __('msg_success'));
                    return redirect()->back()->with(__('msg_success'), __('msg_updated_successfully'));
                }
            }
        } else {
            $professions_array = [
                '0' => 'IEEE',
                '1' => 'IETE',
                '2' => 'ISTE',
                '3' => 'CSI',
                '4' => 'IEI',
                '5' => 'ACE',
                '6' => 'others'
            ];
            $membership = ProfessionalBody::where('id', $request->profesion_model_id)->first();
            $membership->profession_id = $request->profession_id;
            $membership->membership_name = $professions_array[$request->profession_id];
            $membership->membership_id = $request->membership_id;
            $membership->others_membership_type = $request->others_membership_type;
          //  $membership->idcard = $request->idcard;
            $membership->update();
            if ($membership) {
                Toastr::success(__('msg_updated_successfully'), __('msg_success'));
                return redirect()->back()->with(__('msg_success'), __('msg_updated_successfully'));
            } else {
                Toastr::error('Somthing went wrong ', __('msg_error'));
                return redirect()->back()->withInput();
            }
        }
    }

    public function destroy($id)
    {
        $membership = ProfessionalBody::where('id', $id)->first();
        if (!$membership) {
            Toastr::error(__('Document not found!'), __('msg_error'));
            return redirect()->back();
        }
        $membership->delete();
        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
        return redirect()->back();
    }
}
