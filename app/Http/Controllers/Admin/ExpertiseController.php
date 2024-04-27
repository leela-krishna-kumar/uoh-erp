<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;


use App\Models\Expertise;
use Illuminate\Http\Request;
use Toastr;

class ExpertiseController extends Controller
{
    public function store(Request $request)
    {

       //  dd($request->all());


        try{
            // $request->validate([
            //     'user_id' => 'required|numeric',
            // ]);
            $experience = Expertise::create([
                'area_of_expertise' => $request->area_of_expertise,
                'topics' => $request->topics,
                'user_id' =>$request->user_id,
                'staff_id' =>$request->staff_id,
            ]);

            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back();
        }
        catch(\Exception $e){

            dd($e);
            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }
    public function update(Request $request,Expertise $expertise)
    {
      try{
          if(!$expertise){
              return redirect()->back('error','Data Not Found!');
          }
          $request->validate([
              'user_id' => 'required|numeric',
          ]);
          $expertise->update([
              'area_of_expertise' => $request->area_of_expertise,
              'topics' => $request->topics,

          ]);
          Toastr::success(__('msg_updated_successfully'), __('msg_success'));
          return redirect()->back();
      }
      catch(\Exception $e){

          Toastr::error(__('msg_updated_error'), __('msg_error'));

          return redirect()->back();
      }
  }
  public function destroy(Expertise $expertise)
    {
        if(!$expertise){
            return redirect()->back('error','Data Not Found!');
        }
        $expertise->delete();
        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
