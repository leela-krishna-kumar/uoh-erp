<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\StaffBookPublish;
use App\Models\StaffResearcherId;
use App\User;
use Illuminate\Http\Request;
use Toastr;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;

class BooksPublishedController extends Controller
{
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('books-published', 1);
        $this->route = 'admin.books-published';
        $this->view = 'admin.faculty_achievements.books-published';
        $this->path = 'books-conferences';
        $this->access = 'books-conferences';

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

            // $matchingPublishions = StaffBookPublish::where('staff_id', auth()->user()->staff_id);

            // $otherPublishions = StaffBookPublish::where('staff_id', '!=', auth()->user()->staff_id)
            // ->orderBy('staff_id', 'desc');

            // $data['book_publishions'] = $matchingPublishions->union($otherPublishions)->get();

            // $data['book_publishions'] = StaffBookPublish::where('staff_id', auth()->user()->staff_id)
            // ->orderBy('publication_year', 'desc')->get();
            $data['book_publishions'] =[];
            $user = Auth::user();
            if ($user->hasRole('Teacher')){
                $data['book_publishions'] = StaffBookPublish::where('staff_id', $user->staff_id)->orderBy('publication_year', 'desc')->get();
            } elseif ($user->hasRole('Super Admin') || $user->hasRole('Principal')){
                $data['book_publishions'] = StaffBookPublish::orderBy('publication_year', 'desc')->get();
            } elseif ($user->hasRole('HoD')){
                $department_id = $user->department_id;
                $under_department_users =  User::where('department_id',$department_id)->orderBy('id', 'desc')->pluck('staff_id');
                $data['book_publishions'] = StaffBookPublish::whereIn('staff_id', $under_department_users)->orderBy('publication_year', 'desc')->get();
            }else{
                $data['book_publishions'] = StaffBookPublish::orderBy('publication_year', 'desc')->get();
            }

            return view('admin.faculty_achievements.book_publish.index', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    public function create()
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        $teachers = User::where('status', '1');
        $teachers->with('roles')->whereHas('roles', function ($query) {
            $query->where('slug', 'teacher');
        });
        $data['users'] = $teachers->orderBy('staff_id', 'desc')->get();
        return view('admin.faculty_achievements.book_publish.create', $data);
    }


    public function store(Request $request)
    {
        try{
            $publish = new StaffBookPublish();
            $publish->staff_id = auth()->user()->staff_id;
            $publish->published_book_title = $request->published_book_title;
            $publish->published_chapter_title = $request->published_chapter_title;
            $publish->publication_year = $request->publication_year;
            $publish->isbn_number = $request->isbn_number;
            $publish->same_affiliating_institute = $request->same_affiliating_institute;
            $publish->publisher_name = $request->publisher_name;
            $publish->save();
            Toastr::success(__('Book Publish Data stored Successfully.'), __('msg_success'));
            return redirect()->route($this->route.'.index');
        } catch(\Exception $e){
            Toastr::error(__('msg_stored_error'), __('msg_error'));

            return redirect()->route($this->route.'.index');
        }
    }

    public function edit($id)
    {
        $publish = StaffBookPublish::findOrFail($id);
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['publish'] = $publish;

        $teachers = User::where('status', '1');
        $teachers->with('roles')->whereHas('roles', function ($query) {
            $query->where('slug', 'teacher');
        });
        $data['users'] = $teachers->orderBy('staff_id', 'desc')->get();

        return view('admin.faculty_achievements.book_publish.edit', $data);
    }

    public function show($id)
    {
        $publish = StaffBookPublish::findOrFail($id);
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['publish'] = $publish;

        return view('admin.faculty_achievements.book_publish.show', $data);
    }

    public function update(Request $request, $id)
   {
       try{
            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;

            $publish = StaffBookPublish::findOrFail($id);
            if($publish->staff_id != auth()->user()->staff_id)
            {
                Toastr::error(__('Un Authorized'), __('msg_error'));

                return redirect()->route($this->route.'.index');
            }
            if($publish)
            {
                $publish->staff_id = auth()->user()->staff_id;
                $publish->published_book_title = $request->published_book_title;
                $publish->published_chapter_title = $request->published_chapter_title;
                $publish->publication_year = $request->publication_year;
                $publish->isbn_number = $request->isbn_number;
                $publish->same_affiliating_institute = $request->same_affiliating_institute;
                $publish->publisher_name = $request->publisher_name;
                $publish->save();
                Toastr::success(__('Book Publish Data updated Successfully.'), __('msg_success'));
                return redirect()->route($this->route.'.index');
            }
        } catch(\Exception $e){
            Toastr::error(__('msg_updated_error'), __('msg_error'));

            return redirect()->route($this->route.'.index');
        }
   }

   public function destroy($id)
    {
        $publish = StaffBookPublish::findOrFail($id);
        $publish->delete();
        Toastr::success(__('msg_success'), __('Publishion is deleted Successfully'));

        return redirect()->route($this->route.'.index');
    }

}
