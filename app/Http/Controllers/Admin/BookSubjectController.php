<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookSubject;
use Illuminate\Http\Request;
use App\Models\Book;
use Carbon\Carbon;
use Toastr;

class BookSubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
     // Module Data
     $this->title = trans_choice('module_book_subject',1);
     $this->route = 'admin.book-subject';
     $this->view = 'admin.book-subject';
     $this->path = 'book-subject';
     $this->access = 'book-subject';


     $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete',
     ['only' => ['index','show']]);
     $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
     $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
     $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
     }

    public function index(Request $request)
    {
        //
         $data['title'] = $this->title;
         $data['route'] = $this->route;
         $data['view'] = $this->view;
         $data['path'] = $this->path;
         $data['access'] = $this->access;
         $data['books'] = Book::get();
         $events = BookSubject::query();

          if(!empty($request->start_date) || $request->start_date != null){
          $data['selected_start_date'] = $start_date = $request->start_date;
          }
          else{
          $data['selected_start_date'] = $start_date = date('Y-m-d', strtotime(Carbon::now()->subYear()));
          }

          if(!empty($request->end_date) || $request->end_date != null){
          $data['selected_end_date'] = $end_date = $request->end_date;
          }
          else{
          $data['selected_end_date'] = $end_date = date('Y-m-d', strtotime(Carbon::today()));
          }

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

         $bookSubject = new BookSubject;
         $bookSubject->book_id = $request->book_id;
         $bookSubject->subject = $request->subject;
         $bookSubject->save();
         Toastr::success(__('msg_created_successfully'), __('msg_success'));
         return redirect()->back();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\BookSubject  $bookSubject
     * @return \Illuminate\Http\Response
     */
    public function show(BookSubject $bookSubject)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\BookSubject  $bookSubject
     * @return \Illuminate\Http\Response
     */
    public function edit(BookSubject $bookSubject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\BookSubject  $bookSubject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $bookSubject = BookSubject::find($id);
        // dd($bookSubject);
        // return $request->title;
        $bookSubject->book_id = $request->book_id;
        $bookSubject->subject = $request->subject;
        $bookSubject->save();
        Toastr::success(__('msg_updated_successfully'), __('msg_success'));
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\BookSubject  $bookSubject
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //

         try{
         $bookSubject = BookSubject::find($id);
         if($bookSubject){
         $bookSubject->delete();
         }
         Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
         return redirect()->back();
         }catch(\Exception $e){
         Toastr::error(__('msg_deleted_fail'), __('msg_error'));

         return redirect()->back();
         }
    }
}
