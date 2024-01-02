<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use App\Models\Experience;
use Toastr;

class ExperienceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $request->validate([
                'user_id' => 'required|numeric',
            ]);
            $experience = Experience::create([
                'user_id' => $request->user_id,
                'type' => $request->type,
                'subject' => $request->subject,
                'organization' => $request->organization,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'remark' => $request->remark,
            ]);
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back();
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Experience $experience)
    {
        try{
            if(!$experience){
                return redirect()->back('error','Data Not Found!');
            }
            $request->validate([
                'user_id' => 'required|numeric',
            ]);
            $experience->update([
                'user_id' => $request->user_id,
                'type' => $request->type,
                'subject' => $request->subject,
                'organization' => $request->organization,
                'from_date' => $request->from_date,
                'to_date' => $request->to_date,
                'remark' => $request->remark,
            ]);
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Experience $experience)
    {
        if(!$experience){
            return redirect()->back('error','Data Not Found!');
        }
        $experience->delete();
        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
