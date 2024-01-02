<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\YearBook;
use Illuminate\Http\Request;
use Toastr;


class YearBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_year_book', 1);
        $this->route = 'admin.year-book';
        $this->view = 'admin.year-book';
        $this->path = 'year-book';
        $this->access = 'year-book';
      
        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-action|'.$this->access.'-delete', ['only'
        => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-action', ['only' =>
        ['create','store','edit','update','penalty']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
        $this->middleware('permission:'.$this->access.'-over', ['only' => ['dateOver']]);
    }


    public function index()
    {
        //
         $data['title'] = $this->title;
         $data['route'] = $this->route;
         $data['view'] = $this->view;
         $data['path'] = $this->path;
         $data['access'] = $this->access;
         $events = YearBook::query();
         $data['rows'] = $events->orderBy('id', 'asc')->get();
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
        'title' => 'required',
        // 'pdfFiles.*' => 'required|mimes:pdf|max:2048',
        ]);
            if ($request->hasFile('pdfFiles')) {
            $attach = $request->file('pdfFiles');

            $file_ext = $attach->getClientOriginalExtension();
            // Upload Files
            $filename = $attach->getClientOriginalName();
            $extension = $attach->getClientOriginalExtension();
            $fileNameToStore = str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_', $filename) . '_' . time() . '.' .
            $extension;

            // Move file inside public/uploads/ directory
            $attach->move('uploads/' . $this->path . '/', $fileNameToStore);
            $yearBook = new YearBook;
            $yearBook->title = $request->title;
            $yearBook->year = $request->year;
            $yearBook->description = $request->description;
            $yearBook->file = $fileNameToStore;
            $yearBook->save();

            Toastr::success(__('msg_created_successfully'), __('msg_success'));
            return redirect()->back();
            } else {
            // Handle the case where no file is uploaded
            Toastr::error(__('msg_no_file_uploaded'), __('msg_error'));
            return redirect()->back();
            }

    
}
        
    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Admin\YearBook  $yearBook
     * @return \Illuminate\Http\Response
     */
    public function show(YearBook $yearBook)
    {
        //
         
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Admin\YearBook  $yearBook
     * @return \Illuminate\Http\Response
     */
    public function edit(YearBook $yearBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Admin\YearBook  $yearBook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $yearBook = YearBook::find($id);
        // dd($YearBook);
        // return $request->title;
        $yearBook->title = $request->title;
        $yearBook->year = $request->year;
        $yearBook->description = $request->description;
       
        $yearBook->save();
         Toastr::success(__('msg_updated_successfully'), __('msg_success'));
         return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Admin\YearBook  $yearBook
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
         try{
         $yearBook = YearBook::find($id);
         if($yearBook){
         $yearBook->delete();
         }
         Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
         return redirect()->back();
         }catch(\Exception $e){
         Toastr::error(__('msg_deleted_fail'), __('msg_error'));

         return redirect()->back();
         }


 

    }
}
