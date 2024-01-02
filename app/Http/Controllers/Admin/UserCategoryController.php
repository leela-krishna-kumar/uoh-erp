<?php


namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\UserCategory;
use Illuminate\Http\Request;
use Toastr;



class UserCategoryController extends Controller
{
    //



    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('user_category', 1);
        $this->route = 'admin.user-category';
        $this->view = 'admin.user-category';
        $this->path = 'user-category';
        $this->access = 'user-category';


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
        $usercategorytype = UserCategory::query();
        $data['rows'] = $usercategorytype->orderBy('id', 'desc')->get();
        return view($this->view.'.index', $data);
    } catch(\Exception $e){

        Toastr::error(__('msg_error'), __('msg_error'));

        return redirect()->back();
    }
    }


    public function store(Request $request)
    {
        try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);
            //convert the title into array
            $text = trim($_POST['name']);
            $textAr = explode("\r\n", $text);
            $names = array_filter($textAr, 'trim');
            foreach ($names as $name) {
                // Check if the name exists in the database
                if (UserCategory::where('name', $name)->exists()) {
                    Toastr::error(__('msg_name_already_exists'), __('msg_error'));
                    return redirect()->back()->withInput();
                }
            }
            foreach ($names as $name) {
                //check record in DB
                $existName = UserCategory::where('name', $name)->first();
                if(!$existName){
                    // Insert Data if name does not exist
                    $userCategory = new UserCategory;
                    $userCategory->name = $name;
                    $userCategory->save();
                }
            }
          
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect()->back();
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    public function update(Request $request, UserCategory $userCategory)
    {
        try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);
            $userCategory->name = $request->name;
            $userCategory->save();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  
    }

    public function destroy(UserCategory $userCategory)
    {
        try{
            if($userCategory){
                if($userCategory->students->count() > 0){
                    Toastr::error(__('msg_cant_deleted'), __('msg_error'));
                    return redirect()->back();
                }else{
                    $userCategory->delete();
                }
            }
            
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }

}