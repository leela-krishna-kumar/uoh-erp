<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IncomeCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Toastr;

class IncomeCategoryController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_institutional_revenue_categories', 1);
        $this->route = 'admin.income-category';
        $this->view = 'admin.income-category';
        $this->path = 'income-category';
        $this->access = 'income-category';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;
        
        $data['rows'] = IncomeCategory::orderBy('title', 'asc')->get();

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
        // Field Validation
        $request->validate([
            'title' => 'required|max:191|unique:income_categories,title',
        ]);
        $text = trim($_POST['title']);
        $textAr = explode("\r\n", $text);
        $titles = array_filter($textAr, 'trim');

        foreach ($titles as $title) {
            //check record in DB
            $existName = IncomeCategory::where('title', $title)->first();
            if(!$existName){
                // Insert Data if name does not exist
                $incomeCategory = new IncomeCategory;
                $incomeCategory->title = $title;
                $incomeCategory->slug = Str::slug($title, '-');
                $incomeCategory->amount = $request->amount;
                $incomeCategory->description = $request->description;
                $incomeCategory->save();
            }
        }


        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(IncomeCategory $incomeCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(IncomeCategory $incomeCategory)
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
    public function update(Request $request, IncomeCategory $incomeCategory)
    {
        // Field Validation
        $request->validate([
            'title' => 'required|max:191|unique:income_categories,title,'.$incomeCategory->id,
        ]);

        // Update Data
        $incomeCategory->title = $request->title;
        $incomeCategory->slug = Str::slug($request->title, '-');
        $incomeCategory->description = $request->description;
        $incomeCategory->amount = $request->amount;
        $incomeCategory->status = $request->status;
        $incomeCategory->save();


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(IncomeCategory $incomeCategory)
    {
        if($incomeCategory){
            if($incomeCategory->incomes->count() > 0){
                Toastr::error(__('msg_cant_deleted'), __('msg_error'));
                return redirect()->back();
            }else{
                // Delete Data
                $incomeCategory->delete();
            }
        }
        

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }
}
