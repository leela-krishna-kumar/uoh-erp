<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Country;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Toastr;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
         // Module Data
         $this->title = trans_choice('module_country', 1);
         $this->route = 'admin.country';
         $this->view = 'admin.country';
         $this->path = 'country';
         $this->access = 'country';
 
 
         $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
         $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
         $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
     }
 
    public function index()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        
        $data['rows'] = Country::orderBy('title', 'asc')->get();

        return view($this->view.'.index', $data);
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
        //

         // Field Validation
         $request->validate([
            'title' => 'required|max:191|unique:countries,title',
        ]);

        // Insert Data
        $country = new country;
        $country->title = $request->title;
        $country->slug = Str::slug($request->title, '-');
        $country->description = $request->description;
        $country->save();


        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\country  $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\country  $country
     * @return \Illuminate\Http\Response
     */
    public function edit(country $country)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\country  $country
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Country $country)
    {
         // Field Validation
         $request->validate([
            'title' => 'required|max:191|unique:countries,title,'.$country->id,
        ]);

        // Update Data
        $country->title = $request->title;
        $country->slug = Str::slug($request->title, '-');
        $country->description = $request->description;
        $country->status = $request->status;
        $country->save();


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\country  $country
     * @return \Illuminate\Http\Response
     */
    public function destroy(Country $country)
    {
        //
          // Delete Data
          $country->delete();

          Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
  
          return redirect()->back();
    }
}
