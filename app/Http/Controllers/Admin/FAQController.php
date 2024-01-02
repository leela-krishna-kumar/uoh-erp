<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\FAQ;
use App\Models\FAQCategory;
use Illuminate\Http\Request;
use Toastr;

class FAQController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


     public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_faqs', 1);
        $this->route = 'admin.faq';
        $this->view = 'admin.faq';
        $this->path = 'faq';
        $this->access = 'faq';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-card', ['only' => ['index','show','status','sendPassword']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update','status']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
        $this->middleware('permission:'.$this->access.'-show', ['only' => ['show']]);

    }
    public function index(Request $request)
    {
      
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        $data['statuses'] = FAQ::STATUSES;
        $faq = FAQ::query();
        $data['rows'] = $faq->orderBy('id', 'desc')->get();
        

        if(request()->has('status') && request()->has('status')){
            $task->where('status', $request->get('status'));
            }

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

        try {
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['statuses'] = FAQ::STATUSES;
            $data['faqsCategory'] = FAQCategory::get();
            return view($this->view.'.create', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_error'));

            return redirect()->back();
        } 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        // return $request->all();
        // Insert Data
        $request->validate([
            'question' => 'required',
            'category_id' => 'required',
            'explaination' => 'required',
            'status' => 'required',
           
        ]);
        $faq = new FAQ;
        $faq->question = $request->question;
        $faq->category_id = $request->category_id;
        $faq->explaination = $request->explaination;
        $faq->status = $request->status;
        $faq->save();
        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
    }

    /**
     * Display the specified resource.
     
     * @param  \App\Models\FAQ  $faq
     * @return \Illuminate\Http\Response
     */
    public function show(FAQ $faq)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FAQ  $faq
     * @return \Illuminate\Http\Response
     */
    public function edit(FAQ $faq , Request $request)
    {
        //

        // try {
            // return $request->all();
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['path'] = $this->path;
            $data['access'] = $this->access;
            $data['statuses'] = FAQ::STATUSES;
            $data['faqsCategory'] = FAQCategory::get();

            $data['row'] = $faq;
            return view($this->view.'.edit', $data);
        // } catch(\Exception $e){

            Toastr::error(__('msg_error'));

            return redirect()->back();
        // } 
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FAQ  $faqs
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FAQ $faq)
    {
      try{  //

        $faq->question = $request->question;
        $faq->category_id = $request->category_id;
        $faq->explaination = $request->explaination;
        $faq->status = $request->status;
        $faq->save();

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));
        return redirect('admin/faq')->with( __('msg_success'), __('msg_updated_successfully'));
        }
        catch(\Exception $e){

            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->back();
        }  


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FAQ  $faqs
     * @return \Illuminate\Http\Response
     */
    public function destroy(FAQ $faq)
    {
        //

        try{
            $faq;
            if ($faq) {
                 $faq->delete();
            }
            Toastr::success(__('msg_deleted_successfully'), __('msg_success'));
            return redirect()->back();
        }catch(\Exception $e){

            Toastr::error(__('msg_deleted_fail'), __('msg_error'));

            return redirect()->back();
        }
    }
}
