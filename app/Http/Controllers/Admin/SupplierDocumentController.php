<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileUploader;
use App\Models\ItemSupplier;
use App\Models\Document;
use App\Models\DocumentType;
use Toastr;

class SupplierDocumentController extends Controller
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
        $this->title = trans_choice('module_supplier_document', 1);
        $this->route = 'admin.supplier-document';
        $this->view = 'admin.supplier-document';
        $this->path = 'supplier-document';
        $this->access = 'supplier-document';


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
    public function index(Request $request, $id)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;
        $data['access'] = $this->access;

        $itemSupplier = ItemSupplier::where('id', $id)->first();
        $data['itemSupplier'] = $itemSupplier;
        $data['rows'] = $itemSupplier->documents;
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

        $data['types'] = DocumentType::select('id','name')->get();


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
        $request->validate([
            'title' => 'required|max:191',
        ]);

        // Insert Data
        $document = new Document;
        $document->title = $request->title;
        $document->type_id = $request->type_id;
        $document->attach = $this->updateImage($request, 'document', $this->path, 300, 300, $document, 'document');
        $document->save();
        // Attach
        $document->itemSupplier()->sync($request->item_supplier_id);


        Toastr::success(__('msg_created_successfully'), __('msg_success'));

        return redirect()->route('admin.supplier-documents.index',$request->item_supplier_id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ItemSupplier $itemSupplier)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['row'] = $itemSupplier;

        return view($this->view.'.show', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemSupplier $itemSupplier)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['path'] = $this->path;

        $data['row'] = $itemSupplier;

        $data['types'] = DocumentType::select('id','name')->get();

        return view($this->view.'.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemSupplier $itemSupplier)
    {
        // Field Validation
        $request->validate([
            'title' => 'required|max:191',
        ]);

        // Update Data
        $itemSupplier->title = $request->title;
        $itemSupplier->email = $request->email;
        $itemSupplier->phone = $request->phone;
        $itemSupplier->address = $request->address;
        $itemSupplier->contact_person = $request->contact_person;
        $itemSupplier->designation = $request->designation;
        $itemSupplier->contact_person_email = $request->contact_person_email;
        $itemSupplier->contact_person_phone = $request->contact_person_phone;
        $itemSupplier->description = $request->description;
        $itemSupplier->status = $request->status;
        $itemSupplier->save();


        Toastr::success(__('msg_updated_successfully'), __('msg_success'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $document = Document::find($id);
        // Delete Data
        $document->delete();

        Toastr::success(__('msg_deleted_successfully'), __('msg_success'));

        return redirect()->back();
    }

    public function supplierDocuments(Request $request,$id)
    {
        //
        $data['path'] = $this->path;
        $itemSupplier = ItemSupplier::where('id',$id)->first();
        
        $data['rows'] = $itemSupplier->documents;

        return view('admin.supplier-document.index', $data);
    }
}
