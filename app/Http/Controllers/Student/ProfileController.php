<?php

namespace App\Http\Controllers\Student;

use Illuminate\Support\Facades\Crypt;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\FileUploader;
use App\Models\Student;
use Toastr;
use Auth;
use Hash;

class ProfileController extends Controller
{
    use FileUploader;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct () 
    {
        // Module Data
        $this->title     = trans_choice('module_profile', 1);
        $this->route     = 'student.profile';
        $this->view      = 'student.profile';
        $this->path      = 'student';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        $data['title']     = $this->title;
        $data['route']     = $this->route;
        $data['view']      = $this->view;
        $data['path']      = $this->path;
        
        $data['row'] = Student::where('id', Auth::guard('student')->user()->id)->firstOrFail();

        return view($this->view.'.index', $data);
    }

    public function accountSetting(Request $request)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['row'] = Student::where('id', Auth::guard('student')->user()->id)->firstOrFail();
        return view($this->view.'.student-account-setting', $data);
    }

    public function accountSettingDetails(Request $request)
    {
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['row'] = Student::where('id', Auth::guard('student')->user()->id)->firstOrFail();
        
        return view($this->view.'.student-account-details', $data);
    }

    public function photoSubmission(Request $request)
    {
        $student = Student::where('id', Auth::guard('student')->user()->id)->firstOrFail();
        if($request->photo != null && $request->photo != '')
        {
            if ($request->hasFile('photo')) {
                $attach = $request->file('photo');
                $valid_extensions = array('jpg', 'jpeg', 'png', 'svg', 'webp', 'pdf', 'csv');
                $file_ext = $attach->getClientOriginalExtension();
                if (in_array($file_ext, $valid_extensions, true)) {
    
                    //Upload Files
                    $filename = $attach->getClientOriginalName();
                    $extension = $attach->getClientOriginalExtension();
    
                    $fileNameToStore =  time() . '_' . str_replace([' ', '-', '&', '#', '$', '%', '^', ';', ':'], '_', $filename);
        
                    // Move file inside public/uploads/ directory
                    $status = $attach->move('uploads/student/', $fileNameToStore);
                    $student->photo = $fileNameToStore;
                }
            }
            $student->first_name = $request->first_name;
            $student->last_name = $request->last_name;
            $student->email = $request->email;
            $student->phone = $request->phone;

            $student->save();

            $data['title'] = $this->title;
            $data['route'] = $this->route;
            $data['view'] = $this->view;
            $data['row'] = Student::where('id', Auth::guard('student')->user()->id)->firstOrFail();
            return view($this->view.'.student-account-details', $data);
        }
    }

    public function accountSettingPrivacy(Request $request)
    {
        //
        $data['title'] = $this->title;
        $data['route'] = $this->route;
        $data['view'] = $this->view;
        $data['row'] = Student::where('id', Auth::guard('student')->user()->id)->firstOrFail();
        
        return view($this->view.'.student-account-setting-privacy', $data);
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
        $data['title']     = $this->title;
        $data['route']     = $this->route;
        $data['view']      = $this->view;
        $data['path']      = $this->path;


        if($id == Auth::guard('student')->user()->id){

            $data['row'] = Student::findOrFail($id);
        }

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
            'gender' => 'required',
        ]);

        
        if($id == Auth::guard('student')->user()->id){

            // Update data
            $student = Student::find($id);
            $student->gender = $request->gender;
            $student->marital_status = $request->marital_status;
            $student->blood_group = $request->blood_group;
            $student->save();

            Toastr::success(__('msg_updated_successfully'), __('msg_success'));
        }
        else {

            Toastr::error(__('msg_not_permitted'), __('msg_error'));
        }

        return redirect()->back();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function account()
    {
        //
        $data['title'] = trans_choice('module_admin_setting', 1);
        $data['route'] = $this->route;
        $data['view'] = $this->view;

        return view($this->view.'.account', $data);
    }

    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changeMail(Request $request)
    {
        // Field Validation
        $request->validate([
            'email' => 'required|email|unique:students,email',
        ]);

        // Check
        if($request->email != Auth::guard('student')->user()->email){

            $user = Student::find(Auth::guard('student')->user()->id);
            $user->email = $request->email;
            $user->save();
            Auth::guard('student')->logout();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));

            return redirect()->route('student.login');
        }
        else{

            Toastr::error(__('msg_email_invalid'), __('msg_error'));

            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function changePass(Request $request)
    {
        // Field Validation
        $request->validate([
            'old_password' => 'required',
            'password' => 'nullable|confirmed|min:8',
        ]);

        $oldPassword = $request->old_password;
        $hashedPassword = Auth::guard('student')->user()->password;

        // Check old password for validation
        if(Hash::check($oldPassword, $hashedPassword)){

            $user = Student::find(Auth::guard('student')->user()->id);
            $user->password = Hash::make($request->password);
            $user->password_text = Crypt::encryptString($request->password);
            $user->save();
            Auth::guard('student')->logout();
            
            Toastr::success(__('msg_updated_successfully'), __('msg_success'));

            return redirect()->route('student.login');
        }
        else{

            Toastr::error(__('msg_password_invalid'), __('msg_error'));

            return redirect()->back();
        }
    }
}
