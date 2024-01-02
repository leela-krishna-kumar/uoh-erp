<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\BookAccordion;
use App\Models\Book;
use App\Models\Department;
use Illuminate\Http\Request;
use Toastr;

class BookAccordionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

      public function __construct()
      {
      // Module Data
      $this->title = trans_choice('module_accordion', 1);
      $this->route = 'admin.book-accordion';
      $this->view = 'admin.book-accordion';
      $this->path = 'book-accordion';
      $this->access = 'book-accordion';
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
        $data['books'] = Book::where('status', '1')->get();
        $data['statuses'] = BookAccordion::STATUSES;
        $data['depatments'] = Department::get();
        $bookAccordions = BookAccordion::query();
        if (request()->has('status') && request()->get('status')) {
            $bookAccordions = $bookAccordions->where('status',request()->get('status'));
        }
        if (request()->has('department_id') && request()->get('department_id')) {
            $bookAccordions = $bookAccordions->where('department_id',request()->get('department_id'));
        }
        if (request()->has('book_id') && request()->get('book_id')) {
            $bookAccordions = $bookAccordions->where('book_id',request()->get('book_id'));
        }
        $data['rows'] = $bookAccordions->orderBy('book_id', 'asc')->get();

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
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['books'] = Book::where('status', '1')->get();
        $data['statuses'] = BookAccordion::STATUSES;
        $data['depatments'] = Department::get();
         return view($this->view.'.create', $data);
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
            $bookAccordion = new BookAccordion;
            $bookAccordion->book_id = $request->book_id;
            $bookAccordion->department_id = $request->department_id;
            $bookAccordion->status = $request->status;
            $bookAccordion->accordion_no = $request->accordion_no;
            $bookAccordion->note = $request->note;
            $bookAccordion->save();
            Toastr::success(__('msg_created_successfully'), __('msg_success'));
             return redirect()->route($this->route.'.index');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookAccordion  $bookAccordion
     * @return \Illuminate\Http\Response
     */
    public function show(BookAccordion $bookAccordion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookAccordion  $bookAccordion
     * @return \Illuminate\Http\Response
     */
    public function edit(BookAccordion $bookAccordion)
    {
        //
        $data['books'] = Book::where('status', '1')->get();
        $data['statuses'] = BookAccordion::STATUSES;
        $data['depatments'] = Department::get();

         return view($this->view.'.index', $data);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookAccordion  $bookAccordion
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //
         $bookAccordion = BookAccordion::find($id);
         $bookAccordion->book_id = $request->book_id;
         $bookAccordion->department_id = $request->department_id;
         $bookAccordion->status = $request->status;
         $bookAccordion->accordion_no = $request->accordion_no;
         $bookAccordion->note = $request->note;
         $bookAccordion->save();
         Toastr::success(__('msg_updated_successfully'), __('msg_success'));
         return redirect()->back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookAccordion  $bookAccordion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try{
            $bookAccordion = BookAccordion::find($id);
            if($bookAccordion){
            $bookAccordion->delete();
        }
        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
        return redirect()->back();
        }catch(\Exception $e){

        Toastr::error(__('msg_deleted_fail'), __('msg_error'));

        return redirect()->back();
        }
    }
}
