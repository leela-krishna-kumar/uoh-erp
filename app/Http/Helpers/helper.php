<?php
use Illuminate\Support\Facades\DB;
if (!function_exists('scopedYear')) {
    function scopedYear()
    {
        $currentYear = date("Y");
        $yearsList = [];

        for ($i = $currentYear; $i >= ($currentYear - 50); $i--) {
            $yearsList[] = $i;
        }

        return $yearsList;
    }
}

if (!function_exists('getStudentAttendance')) {
    function getStudentAttendance($from,$to)
    {
        $attendance = DB::table('student_attendances')
            ->whereBetween('date', [$from, $to])
            ->count();
        return $attendance;
    }
}

if (!function_exists('getFacultyAttendance')) {
    function getFacultyAttendance($from,$to)
    {
        $teachersIds = App\User::role('Teacher')->pluck('id')->toArray();
        $attendance = DB::table('staff_attendances')
            ->whereIn('user_id', $teachersIds)
            ->whereBetween('date', [$from, $to])
            ->count();
        return $attendance;
    }
}


if (!function_exists('getStaffAttendance')) {
    function getStaffAttendance($from,$to)
    {
        $attendance = DB::table('staff_attendances')
            ->whereBetween('date', [$from, $to])
            ->count();
        return $attendance;
    }
}

if (!function_exists('getHostelAttendance')) {
    function getHostelAttendance($from,$to)
    {
        $attendance = DB::table('hostel_attendances')
            ->whereBetween('date', [$from, $to])
            ->count();
        return $attendance;
    }
}

if (!function_exists('getcomplains')) {
    function getcomplains($from,$to)
    {
        $complains = DB::table('complains')
            ->count();
        return $complains;
    }
}

if (!function_exists('getDueFee')) {
    function getDueFee()
    {
        $dues = DB::table('fees')
            ->whereStatus('0')
            ->sum('fee_amount');
        return $dues;
    }
}

if(!function_exists('getRegulationName')){
    function getRegulationName($id){
      return  $check = \App\Models\Regulation::where('id', $id)
            ->first()->name ?? "--";
    }
}

if (! function_exists('getAnnualIncomeType')) {
    function getAnnualIncomeType($id = -1)
    {
        if($id == -1){
            return [
                ['id'=>1,'name'=>"Below 1 Lac"],
                ['id'=>2,'name'=>"1 - 3 Lacs"],
                ['id'=>3,'name'=>"3 -5 Lacs"],
                ['id'=>4,'name'=>"5 - 8 Lacs"],
                ['id'=>5,'name'=>"8 - 10 Lacs"],
                ['id'=>6,'name'=>"10 - 15 Lacs"],
                ['id'=>7,'name'=>"More than 15 Lacs"],
            ];
            }else{
                foreach(getAnnualIncomeType() as $row){
                    if($id == $row['id']){
                    return $row;
                }
            }
            return ['id'=>0,'name'=>''];
        }
    }
}
if (! function_exists('getPermission')) {
    function getPermission()
    {
        return ['fees-student-due', 'fees-student-quick-assign', 'fees-student-quick-received', 'fees-student-report', 'fees-student-print', 'fees-master-view', 'fees-master-create', 'fees-category-view', 'fees-category-create', 'fees-discount-view', 'fees-discount-create', 'fees-fine-view', 'fees-fine-create', 'fees-receipt-view','college-bank-view','college-bank-create','college-bank-edit','fee-register-view','fee-register-create','fee-register-edit','fee-register-delete','income-create', 'income-view', 'income-category-create', 'income-category-view', 'expense-create', 'expense-view', 'expense-category-create', 'expense-category-view', 'outcome-view','fees-student-due', 'fees-student-quick-assign', 'fees-student-quick-received', 'fees-student-report', 'fees-student-print', 'fees-master-view', 'fees-master-create', 'fees-category-view', 'fees-category-create', 'fees-discount-view', 'fees-discount-create', 'fees-fine-view', 'fees-fine-create', 'fees-receipt-view','college-bank-view','college-bank-create','college-bank-edit','fee-register-view','fee-register-create','fee-register-edit','fee-register-delete','faculty-create', 'faculty-view', 'program-create', 'program-view', 'batch-create', 'batch-view', 'session-create', 'session-view', 'semester-create', 'semester-view', 'section-create', 'section-view', 'class-room-create', 'class-room-view', 'subject-create', 'subject-view', 'enroll-subject-create', 'enroll-subject-view', 'class-routine-create', 'class-routine-view', 'class-routine-print', 'exam-routine-create', 'exam-routine-view', 'exam-routine-print', 'class-routine-teacher', 'routine-setting-class', 'routine-setting-exam','faculty-create','assignment-create', 'assignment-view', 'assignment-marking', 'content-create', 'content-view', 'content-type-view', 'content-type-create','lms-view','ecourse-view','ecourse-create','ecourse-edit','ecourse-delete','esection-view','esection-create','esection-edit','esection-delete','elesson-view','elesson-edit','elesson-delete','elesson-create','test-paper-view','test-paper-create','test-paper-edit','test-paper-delete','test-paper-question-view','test-paper-question-create','test-paper-question-edit','test-paper-question-delete','question-bank-view','question-bank-create','question-bank-edit','question-bank-delete','exam-attendance', 'exam-marking','credit-hours-report', 'exam-result', 'subject-marking', 'subject-result','admin/exam/credit-hours-report', 'grade-view', 'grade-create', 'exam-type-view', 'exam-type-create', 'admit-card-view', 'admit-card-print', 'admit-card-download', 'admit-setting-view', 'result-contribution-view','email-notify-create', 'email-notify-view', 'sms-notify-create', 'sms-notify-view', 'event-create', 'event-view','event-category-view','event-category-create','event-category-edit',
'event-category-delete', 'event-calendar', 'notice-create', 'notice-view', 'notice-category-create', 'notice-category-view','book-issue-return-action', 'book-issue-return-view', 'book-issue-return-over', 'library-member-view', 'library-member-create', 'library-member-card', 'book-create', 'book-view', 'book-print', 'book-request-create', 'book-request-view', 'book-category-create', 'book-category-view', 'library-card-setting-view','compliance-view','compliance-create','compliance-edit','compliance-delete','compliance-category-view','compliance-category-create','compliance-category-edit','compliance-category-delete','counselling-view','counselling-create','counselling-edit','counselling-delete','counselling-category-view','counselling-category-create','counselling-category-edit','counselling-category-delete','assign-student-index','assign-student-create','hostel-member-create', 'hostel-member-view', 'hostel-room-create', 'hostel-room-view', 'hostel-create', 'hostel-view', 'room-type-create', 'room-type-view','item-issue-action', 'item-issue-view', 'item-stock-create', 'item-stock-view', 'item-create', 'item-view', 'item-store-create', 'item-store-view', 'item-supplier-create', 'item-supplier-view', 'item-category-create', 'item-category-view','transport-member-create', 'transport-member-view', 'transport-vehicle-create', 'transport-vehicle-view', 'transport-route-create', 'transport-route-view','profile-view', 'profile-edit','project-view','project-create','project-edit','project-delete','project-category-view', 'project-category-create','project-category-edit','project-category-delete','project-view','project-category-view','project-create','project-edit','project-view','project-category-view','project-category-create','placement-view', 'placement-create', 'placement-edit', 'placement-delete','company-view', 'company-create', 'company-edit', 'company-delete','student-report-view','student-report-create','student-report-edit','student-report-delete','student-report-category-view','student-report-category-create','student-report-category-edit','student-report-category-delete','student-report-view', 'student-report-create','student-report-view','student-report-category-view','student-report-category-create','approval-submissions-view','approval-submissions-create','approval-submissions-edit','approval-submissions-delete','approval-submissions-show','approval-submissions-category-view','approval-submissions-category-create','approval-submissions-category-edit','approval-submissions-category-delete','approval-submissions-view', 'approval-submissions-create','approval-submissions-view','approval-submissions-category-view','approval-submissions-category-create','scholarship-view', 'scholarship-create', 'scholarship-edit', 'scholarship-delete','donor-view', 'donor-create', 'donor-edit', 'donor-delete','scholarship-student-view', 'scholarship-student-create','scholarship-student-edit','scholarship-student-delete','task-view','task-create','task-edit','task-delete','feedback-view','feedback-create','feedback-edit','feedback-delete','report-view','student-achievement-view','student-achievement-create','fitness-student-view','fitness-student-create','grievance-view','grievance-category-create','faqs-view','faqs-create','faqs-edit','faqs-delete','visitor-create', 'visitor-view', 'visitor-print', 'visit-purpose-create', 'visit-purpose-view', 'visitor-token-setting-view', 'enquiry-create', 'enquiry-view', 'enquiry-source-create', 'enquiry-source-view', 'enquiry-reference-create', 'enquiry-reference-view', 'phone-log-create', 'phone-log-view', 'complain-create', 'complain-view', 'complain-type-create', 'complain-type-view', 'complain-source-create', 'complain-source-view', 'postal-exchange-create', 'postal-exchange-view', 'postal-type-create', 'postal-type-view', 'meeting-create', 'meeting-view', 'meeting-type-create', 'meeting-type-view','marksheet-view', 'marksheet-print', 'marksheet-download', 'marksheet-setting-view', 'certificate-view', 'certificate-create', 'certificate-print', 'certificate-download', 'certificate-template-view', 'certificate-template-create','setting-view', 'province-view', 'province-create', 'district-view', 'district-create', 'language-view', 'language-create', 'translations-view', 'translations-create', 'mail-setting-view', 'sms-setting-view', 'application-setting-view', 'schedule-setting-view', 'bulk-import-export-view', 'role-view', 'role-edit','address-type-view','address-type-create','address-type-edit','address-type-delete','achievement_category-view','achievement_category-create',
];
    }
}


if(!function_exists('getStudentFeeByType')){
    function getStudentFeeByType($student ,$department ,$category_id = null){
        $currentEnroll = $student->currentEnroll;
        $criteriaFee = null;
        //check student are enroll or not
        if($currentEnroll){
            $criteriaFee = App\Models\FeesTypeMaster::where('session_id',$currentEnroll->session_id)->
            where('program_id',$currentEnroll->program_id)->where('session_id',$currentEnroll->session_id)
            ->where('seat_type_id',$student->seat_type_id)->first();
        }
        if($department == 'Hostel'){
            $memberId = App\Models\HostelMember::where('hostelable_type','App\Models\Student')->where('status',1)->where('hostelable_id',$student->id)->first();
        }elseif($department == 'Transportation'){
            $memberId = App\Models\TransportMember::where('transportable_type','App\Models\Student')->where('status',1)->where('transportable_id',$student->id)->first();
        }
        if(!$category_id){
            if($department == 'Hostel'){
                if($memberId->room->roomType){
                    $category_id = $memberId->room->roomType->fee_id;
                }
            }elseif($department == 'Transportation'){
                if($memberId){
                    $category_id = $memberId->fee_category_id;
                }
            }
           
        }
        //if student are enroll execute if part otherwise else
        // if($criteriaFee){
        //     $studentFee = $criteriaFee->amount;
        // }else{
        //     //get hostel detail of student
        //     if($memberId->room->roomType){
        //         $fee_id = $memberId->room->roomType->fee_id;
        //         $feeType = App\Models\FeesCategory::where('id',$fee_id)->first();
        //         $studentFee = $feeType ? $feeType->amount : 0;
        //     }else{
        //         $studentFee = 0;
        //     }
        // }
        $remaingniFee = 0;
        $totalFee = 0;
        $paidFee = 0;
        if($category_id){
            if($student->currentEnroll){
                $feeAmount = App\Models\Fee::where('student_enroll_id',$student->currentEnroll->id)->where('category_id',$category_id)->whereIn('status', ['0', '1'])->sum('fee_amount');
               
           //     dd($feeAmount);
               
                $fineAmount = App\Models\Fee::where('student_enroll_id',$student->currentEnroll->id)->where('category_id',$category_id)->sum('fine_amount');
                $discountAmount = App\Models\Fee::where('student_enroll_id',$student->currentEnroll->id)->where('category_id',$category_id)->sum('discount_amount');
                $paidFee = App\Models\Fee::where('student_enroll_id',$student->currentEnroll->id)->where('category_id',$category_id)->sum('paid_amount');
                // if($fee){
                //     $totalFee = $fee->fee_amount + $fee->fine_amount - $fee->discount_amount;
                //     $paidFee = $fee->paid_amount;
                // }
                $totalFee = $feeAmount + $fineAmount - $discountAmount;
                $remaingniFee = $totalFee - $paidFee;

             //   dd($totalFee);
            }
        }
        // if($unpaidFee){
        //     $unpaidFeeAmmont = $unpaidFee->amount;
        //     $remaingniFee = $studentFee - $unpaidFeeAmmont;
        // }
        $data = [
            'total_fee' => $totalFee,
            'remaining_fee' => $remaingniFee
        ];
        return  $data;
    }
}

if(!function_exists('getStaffFeeByType')){
    function getStaffFeeByType($user ,$department ,$category_id = null){
        if($department == 'Hostel'){
            $memberId = App\Models\HostelMember::where('hostelable_type','App\User')->where('status',1)->where('hostelable_id',$user->id)->first();
        }elseif($department == 'Transportation'){
            $memberId = App\Models\TransportMember::where('transportable_type','App\User')->where('status',1)->where('transportable_id',$user->id)->first();
        }
        if(!$category_id){
            if($department == 'Hostel'){
                if($memberId->room->roomType){
                    $category_id = $memberId->room->roomType->fee_id;
                }
            }elseif($department == 'Transportation'){
                if($memberId){
                    $category_id = $memberId->fee_category_id;
                }
            }
           
        }
        $remaingniFee = 0;
        $totalFee = 0;
        $paidFee = 0;
        if($category_id){
            if($user){
                $feeAmount = App\Models\Fee::where('staff_id',$user->id)->where('category_id',$category_id)->sum('fee_amount');
                $fineAmount = App\Models\Fee::where('staff_id',$user->id)->where('category_id',$category_id)->sum('fine_amount');
                $discountAmount = App\Models\Fee::where('staff_id',$user->id)->where('category_id',$category_id)->sum('discount_amount');
                $paidFee = App\Models\Fee::where('staff_id',$user->id)->where('category_id',$category_id)->sum('paid_amount');
               
                $totalFee = $feeAmount + $fineAmount - $discountAmount;
                $remaingniFee = $totalFee - $paidFee;
            }
        }
        
        $data = [
            'total_fee' => $totalFee,
            'remaining_fee' => $remaingniFee
        ];
        return  $data;
    }
}
if(!function_exists('getSportsNameById')){
    function getSportsNameById($id){
    return $check = \App\Models\Sports::where('id',$id)
    ->first()->name ?? "--";
    }
}
if (!function_exists('generateTransactionNumber')) {
    function generateTransactionNumber()
    {
        $transaction_number = random_int(100000, 999999);
        $recordExist = App\Models\Fee::where("transaction_number", "=", $transaction_number)->first();
        if($recordExist){
            generateTransactionNumber();
        }else{
            return $transaction_number;
        }
    }
}
if (!function_exists('createPermissions')) {
    function createPermissions()
    {
        $permissions = ['Fitness Student'];

        $permission_array = [];

        foreach ($permissions as $permission) {
            $permission_name = strtolower(str_replace(' ', '-', $permission));
            
            // // For Reports
            // $permissionArray[] = [
            //     'name' => $permission_name . '-view',
            //     'group' => 'Report',
            //     'title' => $permission,
            //     'guard_name' => 'web',
            // ];

            // For Permissions
            $permissionArray[] = [
                'name' => $permission_name . '-view',
                'group' => $permission,
                'title' => 'View',
                'guard_name' => 'web',
            ];

            $permissionArray[] = [
                'name' => $permission_name . '-create',
                'group' => $permission,
                'title' => 'Create',
                'guard_name' => 'web',
            ];
    
    
            $permissionArray[] = [
                'name' => $permission_name . '-edit',
                'group' => $permission,
                'title' => 'Edit',
                'guard_name' => 'web',
            ];
    
            $permissionArray[] = [
                'name' => $permission_name . '-delete',
                'group' => $permission,
                'title' => 'Delete',
                'guard_name' => 'web',
            ];
        }
        // return $permissionArray;
        
        DB::table('permissions')->insert($permissionArray);
        return 'success';
        // You can now insert this array into your database if needed
    }
}
