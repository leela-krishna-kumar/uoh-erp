<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookCategory;
use App\Models\SubjectMaster;
use Illuminate\Http\Request;
use App\Traits\FileUploader;
use App\Models\Book;
use App\Models\BookAccordion;
use Toastr;
use Image;
use File;
use Auth;

class BookController extends Controller
{
    use FileUploader;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('module_book', 1);
        $this->route = 'admin.book-list';
        $this->view = 'admin.book';
        $this->path = 'book';
        $this->access = 'book';


        $this->middleware('permission:'.$this->access.'-view|'.$this->access.'-create|'.$this->access.'-edit|'.$this->access.'-delete|'.$this->access.'-print', ['only' => ['index','show']]);
        $this->middleware('permission:'.$this->access.'-create', ['only' => ['create','store']]);
        $this->middleware('permission:'.$this->access.'-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:'.$this->access.'-delete', ['only' => ['destroy']]);
        $this->middleware('permission:'.$this->access.'-print', ['only' => ['tokenPrint', 'multitokenPrint']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;


        if(!empty($request->category) || $request->category != null){
            $data['selected_category'] = $category = $request->category;
        }
        else{
            $data['selected_category'] = $category = '0';
        }

        if(!empty($request->title) || $request->title != null){
            $data['selected_title'] = $title = $request->title;
        }
        else{
            $data['selected_title'] = $title = null;
        }


        // Search Filter
        $data['categories'] = BookCategory::where('status', '1')
                            ->orderBy('title', 'asc')->get();

        $rows = Book::where('title', 'LIKE', '%'.$request->title.'%');
                    if(!empty($request->category) || $request->category != null){
                        $rows->where('category_id', $category);
                    }
        // $data['rows'] = $rows->orderBy('id', 'desc')->limit(20)->get();
        $data['rows'] = $rows->orderBy('id', 'desc')->paginate(50);

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

        $data['categories'] = BookCategory::where('status', '1')
                            ->orderBy('title', 'asc')->get();
        $data['subjects'] = SubjectMaster::get();
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

        // Field Validation
        // return $request->all();
        $request->validate([
            'category' => 'required',
            'title' => 'required|max:191',
            'isbn' => 'required|max:30|unique:books,isbn',
            // 'code' => 'nullable|max:191|unique:books,code',
            'author' => 'required',
            'price' => 'nullable|numeric',
            'attach' => 'nullable|image|mimes:jpg,jpeg,png|max:20480',
        ]);

        $fromAccNo = floatval($request->from_acc_no);
        $toAccNo = floatval($request->to_acc_no);

        // if ($fromAccNo >= $toAccNo) {
        //     Toastr::error(__('To Accession No must be greater than From Accession No'), __('msg_success'));
        //     return redirect()->route($this->route.'.index');
        // }
        // image upload, fit and store inside public folder
        if($request->hasFile('attach')){
            //Upload New Image
            $filenameWithExt = $request->file('attach')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('attach')->getClientOriginalExtension();
            $fileNameToStore = str_replace([' ','-','&','#','$','%','^',';',':'],'_',$filename).'_'.time().'.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/'.$this->path.'/');
            if (! File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            //Resize And Crop as Fit image here (100 width, 150 height)
            $thumbnailpath = $path.$fileNameToStore;
            $img = Image::make($request->file('attach')->getRealPath())->fit(100, 150, function ($constraint) { $constraint->upsize(); })->save($thumbnailpath);
        }
        else{
            $fileNameToStore = Null;
        }

        // Insert Data
        $book = new Book;
        $book->category_id = $request->category;
        $book->title = $request->title;
        $book->isbn = $request->isbn;
        $book->subject_id = $request->subject_id;
        $book->code = $request->code;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->edition = $request->edition;
        $book->publish_year = $request->publish_year;
        $book->language = $request->language;
        $book->price = $request->price;
        $book->is_e_book = $request->is_e_book;
        $book->is_physical_book= $request->is_physical_book;
        $book->description = $request->description;
        $book->note = $request->note;
        $book->link = $request->link;
        $book->attach = $fileNameToStore;
        $book->call_no = $request->call_no;
        // $book->from_acc_no = $request->from_acc_no;
        // $book->to_acc_no = $request->to_acc_no;
        $book->acc_no = $request->acc_no;
        $book->volume = $request->volume;
        $book->currency = $request->currency;
        $book->department = $request->department;
        // $book->subject = $request->subject;
        $book->course = $request->course;
        $book->book_type = $request->book_type;
        $book->book_size = $request->book_size;
        $book->no_of_pages = $request->no_of_pages;
        $book->issue_books = $request->issue_books;
        $book->ref_books = $request->ref_books;
        $book->supplier = $request->supplier;
        $book->invoice_no = $request->invoice_no;
        $book->invoice_date = $request->invoice_date;
        $book->enclose_type = $request->enclose_type;
        $book->enclose_items = $request->enclose_items;
        $book->ddc_1 = $request->ddc_1;
        $book->ddc_2 = $request->ddc_2;
        $book->ddc_3 = $request->ddc_3;
        $book->prefix = $request->prefix;
        $book->suffix = $request->suffix;
        $book->rack_no = $request->rack_no;
        $book->sub_rack_no = $request->sub_rack_no;
        $book->publisher_place = $request->publisher_place;

        $book->created_by = Auth::guard('web')->user()->id;
        $book->save();

        // Create bookAccordion
        $totalNumberOfAccordion = $toAccNo - $fromAccNo;
        for ($i = 1 ; $i <= $totalNumberOfAccordion ; $i++){
            $bookAccordion = new BookAccordion;
            $bookAccordion->book_id = $book->id;
            $bookAccordion->status = 1;
            $bookAccordion->accordion_no = $fromAccNo;
            $bookAccordion->save();
        }

        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route($this->route.'.index');
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
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['row'] = Book::findOrFail($id);

        return view($this->view.'.show', $data);
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
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['row'] = Book::findOrFail($id);
        $data['subjects'] = SubjectMaster::get();
        $data['categories'] = BookCategory::where('status', '1')
                            ->orderBy('title', 'asc')->get();

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // Field Validation
        $request->validate([
            'category' => 'required',
            'title' => 'required|max:191',
            'isbn' => 'required|max:191|unique:books,isbn,'.$id,
            // 'code' => 'nullable|max:191|unique:books,code,'.$id,
            'author' => 'required',
            // 'from_acc_no' => 'required',
            // 'to_acc_no' => 'required',
            'author' => 'required',
            'price' => 'nullable|numeric',
            'attach' => 'nullable|image|mimes:jpg,jpeg,png|max:20480',
        ]);


        $book = Book::findOrFail($id);

        // image upload, fit and store inside public folder
        if($request->hasFile('attach')){

            $file_path = public_path('uploads/'.$this->path.'/'.$book->attach);
            if(File::isFile($file_path)){
                File::delete($file_path);
            }

            //Upload New Image
            $filenameWithExt = $request->file('attach')->getClientOriginalName();
            $filename = pathinfo($filenameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('attach')->getClientOriginalExtension();
            $fileNameToStore = str_replace([' ','-','&','#','$','%','^',';',':'],'_',$filename).'_'.time().'.'.$extension;

            //Crete Folder Location
            $path = public_path('uploads/'.$this->path.'/');
            if (! File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }

            //Resize And Crop as Fit image here (100 width, 150 height)
            $thumbnailpath = $path.$fileNameToStore;
            $img = Image::make($request->file('attach')->getRealPath())->fit(100, 150, function ($constraint) { $constraint->upsize(); })->save($thumbnailpath);
        }
        else{
            $fileNameToStore = $book->attach;
        }


        // Update Data
        $book->category_id = $request->category;
        $book->title = $request->title;
        $book->isbn = $request->isbn;
        $book->code = $request->code;
        $book->author = $request->author;
        $book->publisher = $request->publisher;
        $book->edition = $request->edition;
        $book->publish_year = $request->publish_year;
        $book->language = $request->language;
        $book->price = $request->price;
        $book->quantity = $request->quantity;
        $book->section = $request->section;
        $book->description = $request->description;
        $book->is_e_book = $request->is_e_book;
        $book->is_physical_book= $request->is_physical_book;
        $book->note = $request->note;
        $book->link = $request->link;
        $book->attach = $fileNameToStore;
        $book->status = $request->status;
        $book->call_no = $request->call_no;
        $book->from_acc_no = $request->from_acc_no;
        $book->to_acc_no = $request->to_acc_no;
        $book->acc_no = $request->acc_no;
        $book->volume = $request->volume;
        $book->currency = $request->currency;
        $book->department = $request->department;
        $book->subject_id = $request->subject_id;
        // $book->subject = $request->subject;
        $book->course = $request->course;
        $book->book_type = $request->book_type;
        $book->book_size = $request->book_size;
        $book->no_of_pages = $request->no_of_pages;
        $book->issue_books = $request->issue_books;
        $book->ref_books = $request->ref_books;
        $book->supplier = $request->supplier;
        $book->invoice_no = $request->invoice_no;
        $book->invoice_date = $request->invoice_date;
        $book->enclose_type = $request->enclose_type;
        $book->enclose_items = $request->enclose_items;
        $book->ddc_1 = $request->ddc_1;
        $book->ddc_2 = $request->ddc_2;
        $book->ddc_3 = $request->ddc_3;
        $book->prefix = $request->prefix;
        $book->suffix = $request->suffix;
        $book->rack_no = $request->rack_no;
        $book->sub_rack_no = $request->sub_rack_no;
        $book->publisher_place = $request->publisher_place;
        $book->updated_by = Auth::guard('web')->user()->id;
        $book->save();

        Toastr::success(__('msg_updated_successfully'), __('msg_success'));
        return redirect('admin/library/book-list')->with( __('msg_success'), __('msg_updated_successfully'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Delete Data
        $book = Book::findOrFail($id);
        $this->deleteMedia($this->path, $book);

        $book->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function tokenPrint($id)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        // View
        $data['rows'] = Book::where('id', $id)->orderBy('id', 'desc')->get();

        return view($this->view.'.print', $data);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function multitokenPrint(Request $request)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        $books = explode(",",$request->books);

        // View
        $data['rows'] = Book::whereIn('id', $books)->orderBy('id', 'desc')->get();

        return view($this->view.'.print', $data);
    }
}
