<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\PlacementCategory;
use Illuminate\Http\Request;
use Toastr;


class PlacementCategoryController extends Controller
{
    //

    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('field_placement_category', 1);
        $this->route = 'admin.category';
        $this->view = 'admin.placement-category';
        $this->path = 'category';
        $this->access = 'category';


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
        $placementCategories = PlacementCategory::query();
        $data['rows'] = $placementCategories->orderBy('id', 'desc')->get();
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
                //check record in DB
                $existName = PlacementCategory::where('name', $name)->first();
                if(!$existName){
                    // Insert Data if name does not exist
                    $placementCategory = new PlacementCategory;
                    $placementCategory->name = $name;
                    $placementCategory->save();
                }else{
                    Toastr::error(__('Duplicate entry not allowed'), __('msg_error'));

                    return redirect()->back();
                }
            }
            Toastr::success(__('msg_created_successfully'), __('msg_success'));

            return redirect()->back();
        } catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    public function update(Request $request, $id, PlacementCategory  $placementCategory)
    {
        try{
            // Field Validation
            $request->validate([
                'name' => 'required',
            ]);

          //  dd($id);

            $placementCat = PlacementCategory::where('name', $request->name)->first();

            if(!$placementCat){

            $placementCategory = PlacementCategory::find($id);

            $placementCategory->name = $request->name;
            $placementCategory->update();

            Toastr::success(__('msg_updated_successfully'), __('msg_success'));

            }else{
            Toastr::error(__('duplicate entry not allowed'), __('msg_success'));

            }
            
            return redirect()->back()->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  
    }

    public function destroy($id)
    {
        try{
            $placementCategory = PlacementCategory::find($id);
            if($placementCategory){
                $placementCategory->delete();
            }
            
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }

}