<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use App\Models\AchievementCategory;
use Illuminate\Http\Request;
use Toastr;

class AchievementCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         // Module Data
         $this->title = trans_choice('field_achievement_category', 1);
         $this->route = 'admin.achievement-category';
         $this->view = 'admin.achievement-category';
         $this->path = 'achievement-category';
         $this->access = 'achievement-category';
 
 
         $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
         $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
         $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
         $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
     }
    public function index()
    {
        //  try{  
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['types'] = AchievementCategory::TYPES;
            $achievementCategory = AchievementCategory::query();
            $data['rows'] = $achievementCategory->orderBy('id', 'desc')->get();
            return view($this->view.'.index', $data);
        // } catch(\Exception $e){

            Toastr::error(__('msg_error'), __('msg_error'));

            return redirect()->back();
        // }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Field Validation
            $request->validate([
                'name' => 'required',
                'type' => 'required', // Add validation for 'type' field
            ]);
    
            // Check if a record with the same name and type already exists
            $achievement = AchievementCategory::where('name', $request->name)
                // ->where('type', $request->type)
                ->first();
    
            if ($achievement) {
                // Record already exists, show error message and redirect back
                Toastr::error(__('Record already Created'), __('msg_error'));
                return redirect()->back();
            }
    
            // If the record does not exist, create a new one
            $achievementCategory = new AchievementCategory;
            $achievementCategory->name = $request->name;
            $achievementCategory->type = $request->type;
            $achievementCategory->save();
    
            // Success message and redirect
            Toastr::success(__('msg_created_successfully'), __('msg_success'));
            return redirect()->back();
        } catch (\Exception $e) {
            // Handle any exceptions that may occur
            Toastr::error(__('msg_updated_error'), __('msg_error'));
            return redirect()->back();
        }
    }
    

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\AchievementCategory  $achievementCategory
     * @return \Illuminate\Http\Response
     */
    public function show(AchievementCategory $achievementCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\AchievementCategory  $achievementCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(AchievementCategory $achievementCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\AchievementCategory  $achievementCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AchievementCategory $achievementCategory)
    {

        // try{
            // Field Validation
            // return $request->all();
            $request->validate([
                'name' => 'required|unique:achievement_categories,name,'.$achievementCategory->id,
            ]);
            $achievementCategory->name = $request->name;
            $achievementCategory->type = $request->type;
            $achievementCategory->save();
            
            // Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        // }
        // catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        // }  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\AchievementCategory  $achievementCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(AchievementCategory $achievementCategory)
    {
        
        try{
            if($achievementCategory){
                $achievementCategory->delete();
            }
            
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
