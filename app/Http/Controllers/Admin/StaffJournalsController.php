<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

use App\Models\Journal;
use App\Models\StaffResearcherId;
use App\User;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Yoeunes\Toastr\Facades\Toastr;

class StaffJournalsController extends Controller
{
    public function __construct()
    {
        // Module Data
        $this->title = trans_choice('Journals', 1);
        $this->route = 'admin.faculty-achievements.journals';
        $this->view = 'admin.faculty_achievements.journals';
        $this->path = 'journals';
        $this->access = 'journals';

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

            $data['staff_id']  = Auth::user()->staff_id;

            // $matching = Journal::where('id', '!=', null)
            // ->where('staff_id', auth()->user()->staff_id);

            // $other = Journal::where('id', '!=', null)
            // ->where('staff_id', '!=', auth()->user()->staff_id)
            // ->orderBy('staff_id', 'desc');

            // $data['journals'] = $matching->union($other)->get();

            // $data['journals'] = Journal::where('staff_id', auth()->user()->staff_id)
            // ->orderBy('year_of_publication', 'desc')->get();
            $data['journals'] = [];

            $user = Auth::user();

            if ($user->hasRole('Teacher')){
                $data['journals'] = Journal::where('staff_id', $user->staff_id)->orderBy('year_of_publication', 'desc')->get();
            } elseif ($user->hasRole('Super Admin') || $user->hasRole('Principal')){
                $data['journals'] = Journal::orderBy('year_of_publication', 'desc')->get();
            } elseif ($user->hasRole('HoD')){
                $department_id = $user->department_id;
                $under_department_users =  User::where('department_id',$department_id)->pluck('staff_id');
                $data['journals'] = Journal::whereIn('staff_id', $under_department_users)->orderBy('year_of_publication', 'desc')->get();
            }else{
                $data['journals'] = Journal::orderBy('id', 'desc')->get();
            }

            return view($this->view.'.index', $data);
        } catch(\Exception $e){

            Toastr::error(__('msg_error'), __('msg_error'));

            return redirect()->back();
        }
    }

    public function create()
    {
        return "Hello";
    }


    public function store(Request $request)
    {
       // dd($request->all());

       $journal = new Journal();

       $name_of_the_author = explode(',' , $request->name_of_the_author);

       $journal->staff_id = Auth::user()->staff_id;
       $journal->title_of_paper = $request->title_of_paper;
       $journal->name_of_the_journal = $request->name_of_the_journal;
      $journal->name_of_the_author = '';
       $journal->year_of_publication = $request->year_of_publication;
       $journal->issn_number = $request->issn_number;
       $journal->journal_website_link = $request->journal_website_link;
       $journal->paper_abstract_article_link = $request->paper_abstract_article_link;

       $journal->save();

       $journal = Journal::find($journal->id);

       $journal->name_of_the_author = json_encode($name_of_the_author);

        $journal->update();

       Toastr::success(__('msg_success'), __('msg_success'));

       return redirect()->back();
    }

    public function update(Request $request, $id)
   {
        $journal = Journal::find($id);

        if($journal->staff_id != auth()->user()->staff_id)
        {
            Toastr::error(__('Un Authorized'), __('msg_error'));

            return redirect()->route($this->route.'.index');
        }

        $name_of_the_author = explode(',' , $request->name_of_the_author);

        // $journal->staff_id = Auth::user()->staff_id;
        $journal->title_of_paper = $request->title_of_paper;
        $journal->name_of_the_journal = $request->name_of_the_journal;
        $journal->name_of_the_author = $name_of_the_author;
        $journal->year_of_publication = $request->year_of_publication;
        $journal->issn_number = $request->issn_number;
        $journal->journal_website_link = $request->journal_website_link;
        $journal->paper_abstract_article_link = $request->paper_abstract_article_link;

        $journal->update();

        Toastr::success(__('msg_success'), __('msg_success'));

        return redirect()->back();
   }

   public function destroy(Journal $journal)
    {
       // dd('12');
        //  $journal = Journal::find($id);

        $journal->delete();

        Toastr::success(__('msg_success'), __('msg_deleted'));

        return redirect()->back();
    }

}
