<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\PostalExchange;
use Illuminate\Http\Request;
use App\Models\Application;
use App\Models\Complain;
use App\Models\PhoneLog;
use Illuminate\Support\Facades\Http;
use App\Models\Visitor;
use App\Models\Expense;
use App\Models\Enquiry;
use App\Models\Payroll;
use App\Models\Student;
use App\Models\Income;
use App\Models\Book;
use App\Models\ClassRoutine;
use App\Models\Entrance;
use App\Models\Fee;
use App\Models\Grievance;
use App\Models\HostelMember;
use App\Models\Session;
use App\Models\StudentIntake;
use Carbon\Carbon;
use App\User;
use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class DashboardController extends Controller
{
   /**
   * Create a new controller instance.
   *
   * @return void
   */
   public function __construct()
   {
      // Module Data
      $this->title = trans_choice('module_dashboard', 1);
      $this->route = 'admin.dashboard';
      $this->view = 'admin';

      // $this->middleware(function ($request, Closure $next) {

      //  // dd(Crypt::decryptString(Auth::user()->password_text));

      //  if (isset(Auth::user()->id) && Auth::user()->is_admin != 1) {

      //         if(Auth::user()->staff_id == Crypt::decryptString(Auth::user()->password_text)) {

      //             return redirect(route('admin.set-password'));
      //         }
      //     }

      //     return $next($request);
      // });

   }

   /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
   public function index()
   {

    // $entrance_data = Entrance::all();

    // foreach($entrance_data as $entrance){

    //   if($entrance->rank == 0){

    //     $entrance->rank = NULL;

    //     $entrance->update();
    //   }
        
    // }


      // dd(auth()->user());

      $this->mobileNotification();
      //
      $data['title'] = $this->title;
      $data['route'] = $this->route;
      $data['view'] = $this->view;


      $today_date = Carbon::parse(Carbon::today())->format('Y-m-d');
      $year = Carbon::parse(Carbon::today())->format('Y');
      $month = Carbon::parse(Carbon::today())->format('m');


      // Counter Data
      $data['pending_applications'] = Application::where('status', '1')->get();
      $data['active_students'] = Student::where('status', '1')->get();

      $data['intake_total'] = StudentIntake::sum('intake_count');

      //dd( $data['intake_students']);

      $data['min_eamcet_rank'] = Entrance::select('rank')->where('exam_name', 'EAMCET')->min('rank');
      $data['max_eamcet_rank'] = Entrance::select('rank')->where('exam_name', 'EAMCET')->max('rank');

      $eamcet[1] = [
        'range' => '1-1000',
        "student_count" => Entrance::select('rank')->where('exam_name', 'EAMCET')->where('rank', '>', '0')->where('rank', '<', '1001')->count()
      ];

      $eamcet[2] = [
        'range' => '1001-5000',
        "student_count" => Entrance::select('rank')->where('exam_name', 'EAMCET')->where('rank', '>', '1000')->where('rank', '<', '5001')->count()
      ];

      $eamcet[3] = [
        'range' => '5001-10000',
        "student_count" => Entrance::select('rank')->where('exam_name', 'EAMCET')->where('rank', '>', '5000')->where('rank', '<', '10001')->count()
      ];

      $eamcet[4] = [
        'range' => '10001-20000',
        "student_count" => Entrance::where('exam_name', 'EAMCET')->where('rank', '>', '10001')->where('rank', '<', '20000')->count()
      ];

      $data['eamcet'] = $eamcet;

      $data['seat_type_ids'] = Student::groupBy( 'seat_type_id')
               ->select('seat_type_id', \DB::raw('count(*) as seat_type_count'))
               ->get();


               $data['seat_type_ids_branch_wise'] = Student::groupBy('faculty_id', 'program_id', 'batch_id' , 'session_id', 'seat_type_id')
               ->select('faculty_id', 'program_id', 'batch_id' , 'session_id', 'semester_id', 'seat_type_id', \DB::raw('count(*) as seat_type_count_bw'))
               ->get();


              //  dd( $data['seat_type_ids']);

      $data['active_students_branch_wise'] = Student::groupBy('faculty_id', 'program_id', 'batch_id', 'session_id', 'semester_id' )
               ->select('faculty_id', 'program_id', 'batch_id','session_id', 'semester_id', \DB::raw('count(*) as count'))
               ->get();

      // dd($data['active_students_branch_wise']);

      // $addresses = Address::select('model_type', 'model_id', 'state_id')->where('model_type', 'App\Models\Student')->distinct()->get();

      // dd($addresses);

      // $data['state_wise_students'] = $addresses->groupBy('state_id')
      //                       ->select('state_id', \DB::raw('count(*) as count'))
      //                       ->get();

      //         dd($data['state_wise_students']);

      $data['hostel_data'] = HostelMember::groupBy('hostel_id')
                ->select('hostel_id', \DB::raw('count(*) as count'))
                ->get();

      $data['hostel_std_count'] = $data['hostel_data']->sum('count');

      $data['complaints_count'] = Grievance::count();


      // Teacher Filter
      $teachers = User::where('status', '1');
      $teachers->with('roles')->whereHas('roles', function ($query){
          $query->where('slug', 'teacher');
      });
      $data['teachers'] = $teachers->orderBy('staff_id', 'asc')->get();

      // $data['selected_staff'] = $request->teacher;

            $session = Session::where('status', '1')->where('current', '1')->first();

            if(isset($session)){
            $data['rows'] = ClassRoutine::where('status', '1')
                        // ->where('session_id', $session->id)
                        ->where('teacher_id', Auth::user()->id)
                        ->orderBy('start_time', 'asc')
                        ->get();
            }

      // dd($data['complaints_count']);

      // $data['active_staffs'] = User::where('status', '1')->get();
      // $data['library_books'] = Book::where('status', '1')->get();

      // $data['daily_visitors'] = Visitor::where('date', $today_date)->where('status', '1')->get();
      // $data['daily_phone_logs'] = PhoneLog::where('date', $today_date)->where('status', '1')->get();
      // $data['daily_enqueries'] = Enquiry::where('date', $today_date)->where('status', '1')->get();
      // $data['daily_postals'] = PostalExchange::where('date', $today_date)->where('status', '1')->get();


      $months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];


      //Line Chart
      $salaries = [];
      $fees = [];
      $expenses = [];
      $incomes = [];

      // for($l = 1; $l <= $month; $l++){
      //   $salaries[] = Payroll::where('status', '1')->whereYear('pay_date', $year)->whereMonth('pay_date', $l)->sum('net_salary');
      // }
      // for($i = 1; $i <= $month; $i++){
      //   $fees[] = Fee::where('status', '1')->whereYear('pay_date', $year)->whereMonth('pay_date', $i)->sum('paid_amount');
      // }
      // for($j = 1; $j <= $month; $j++){
      //   $expenses[] = Expense::where('status', '1')->whereYear('date', $year)->whereMonth('date', $j)->sum('amount');
      // }
      // for($k = 1; $k <= $month; $k++){
      //   $incomes[] = Income::where('status', '1')->whereYear('date', $year)->whereMonth('date', $k)->sum('amount');
      // }


      //Pie Chart
      $student_fee = Fee::where('status', '1')->whereYear('pay_date', $year)->sum('fee_amount');
      $discounts = Fee::where('status', '1')->whereYear('pay_date', $year)->sum('discount_amount');
      $fines = Fee::where('status', '1')->whereYear('pay_date', $year)->sum('fine_amount');
      $fee_paid = Fee::where('status', '1')->whereYear('pay_date', $year)->sum('paid_amount');



      //Line Chart
      $total_allowance = [];
      $total_deduction = [];
      $total_tax = [];
      $net_salary = [];

      for($q = 1; $q <= $month; $q++){
        $total_allowance[] = Payroll::where('status', '1')->whereYear('pay_date', $year)->whereMonth('pay_date', $q)->sum('total_allowance');
      }
      for($p = 1; $p <= $month; $p++){
        $total_deduction[] = Payroll::where('status', '1')->whereYear('pay_date', $year)->whereMonth('pay_date', $p)->sum('total_deduction');
      }
      for($o = 1; $o <= $month; $o++){
        $total_tax[] = Payroll::where('status', '1')->whereYear('pay_date', $year)->whereMonth('pay_date', $o)->sum('tax');
      }
      for($m = 1; $m <= $month; $m++){
        $net_salary[] = Payroll::where('status', '1')->whereYear('pay_date', $year)->whereMonth('pay_date', $m)->sum('net_salary');
      }

      return view($this->view.'.index', $data)->with('months', json_encode($months,JSON_NUMERIC_CHECK))->with('fees', json_encode($fees,JSON_NUMERIC_CHECK))->with('expenses', json_encode($expenses, JSON_NUMERIC_CHECK))->with('incomes', json_encode($incomes, JSON_NUMERIC_CHECK))->with('salaries', json_encode($salaries, JSON_NUMERIC_CHECK))->with('student_fee', json_encode($student_fee, JSON_NUMERIC_CHECK))->with('discounts', json_encode($discounts, JSON_NUMERIC_CHECK))->with('fines', json_encode($fines, JSON_NUMERIC_CHECK))->with('fee_paid', json_encode($fee_paid, JSON_NUMERIC_CHECK))->with('net_salary', json_encode($net_salary, JSON_NUMERIC_CHECK))->with('total_tax', json_encode($total_tax, JSON_NUMERIC_CHECK))->with('total_deduction', json_encode($total_deduction, JSON_NUMERIC_CHECK))->with('total_allowance', json_encode($total_allowance, JSON_NUMERIC_CHECK));
   }

   private function mobileNotification()
    {
        $headers = [
            'Content-Type' => 'application/json',
            'Authorization' => 'key=AAAAo8t_JQI:APA91bGIFOxbWcLpClr6myWH2Bct3bjKvUkH0l9Ucf1iuqcOqtzDz6KbMV5tJha0Fm1Q6NxDfxW-MrtMyupARTJrvK9ioDZOu3ot_Ol8yf83eqobZGqgRoUo1O_WapZdy-c7P977CIKK',
        ];
        $data = [
            "registration_ids" => [
                auth()->user()->fcm_token
            ],
            "notification" => [
                "body" => "Venkat testing Announcement",
                "content_available" => true,
                "priority" => "high",
                "subtitle" => "Notification testing by Venkat",
                "Title" => "Venkat Testing"
            ],
            "data" => [
                "priority" => "high",
                "sound" => "app_sound.wav",
                "content_available" => true,
                "bodyText" => "Notification test by venkat",
                "organization" => "venkat testing"
            ]
        ];
        $response = Http::withHeaders($headers)
            ->post('https://fcm.googleapis.com/fcm/send', $data);
    }
}
