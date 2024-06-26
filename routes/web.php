<?php


use Spatie\Permission\Models\Role;
use App\Models\Student;

use App\Http\Controllers\Student\DashboardController;
use App\User;
use App\Http\Controllers\FilterController;

use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/qb', function() {
    return createPermissions();
   return $permissions = Spatie\Permission\Models\Permission::where('group','')->pluck('name');
  foreach ($permissions as $key => $permission) {
     $chk_permission = Spatie\Permission\Models\Permission::where('name',$permission)->first();
    if (!$chk_permission) {
        Spatie\Permission\Models\Permission::firstOrCreate(['name' => $permission]);
    }
  }
   return 'success';
    $roles = auth()->user()->roles;
    if ($roles->isNotEmpty()) {
        $roleName = $roles[0]->name;

        dd($roleName); // Display the role name
    } else {
        dd("No roles found for the user.");
    }
    $currentYear = date("Y");
        $yearsList = [];

    for ($i = $currentYear; $i >= ($currentYear - 50); $i--) {
        $yearsList[] = $i;
    }
    return $yearsList;
    return sessionSync(2020-2024);
    return $data['roles'] = Role::orderBy('name', 'asc')->get();
});



Route::middleware(['auth:web'])->name('news-feed.')->namespace('Common')->prefix('news-feed')->group(function () {
    Route::get('/', 'NewsFeedController@index')->name('index');
    Route::get('/get-likes', 'NewsFeedController@getPostLikes')->name('get-likes');
    Route::get('/get-comment-likes', 'NewsFeedController@getPostCommentLikes')->name('get-comment-likes');
    Route::get('/get-comments', 'NewsFeedController@getPostComments')->name('get-comments');
    Route::post('/store-likes', 'NewsFeedController@storePostLikes')->name('store-likes');
    Route::post('/store-comments', 'NewsFeedController@storePostComments')->name('store-comments');
    Route::post('/store-post', 'NewsFeedController@storePost')->name('store-post');
    Route::post('/store-comment-likes', 'NewsFeedController@storePostCommentLikes')->name('store-comment-likes');

});


// Web Routes
Route::middleware(['XSS'])->namespace('Web')->group(function () {

    // Home Route
    Route::get('/', function() {
       return redirect()->route('student.dashboard.index');
    });


    // SetCookie Route
    Route::get('/set-cookie', 'HomeController@setCookie')->name('setCookie');

Route::resource('application', 'ApplicationController');
});


// Ajax Filter Routes
Route::middleware(['XSS'])->group(function () {

    Route::post('filter-faculty', 'FilterController@filterFaculty')->name('filter-faculty');

    Route::post('filter-district', 'AddressController@filterDistrict')->name('filter-district');
    Route::post('filter-province', 'AddressController@filterProvince')->name('filter-province');
    Route::post('filter-batch', 'FilterController@filterBatch')->name('filter-batch');
    Route::post('filter-program', 'FilterController@filterProgram')->name('filter-program');
    Route::post('filter-session', 'FilterController@filterSession')->name('filter-session');
    Route::post('filter-semester', 'FilterController@filterSemester')->name('filter-semester');
    Route::post('filter-section', 'FilterController@filterSection')->name('filter-section');
    Route::post('filter-subject', 'FilterController@filterSubject')->name('filter-subject');
    Route::post('filter-teacher', 'FilterController@filterTeacher')->name('filter-teacher');

    Route::post('get-fee-category', 'FilterController@getFeeCategory')->name('get-fee-category');
    Route::post('get-fee-amount', 'FilterController@getFeeAmount')->name('get-fee-amount');


    Route::post('filter-question-subject', 'FilterController@filterQuestionSubject')->name('filter-question-subject');
    Route::post('filter-enroll-subject', 'FilterController@filterEnrollSubject')->name('filter-enroll-subject');
    Route::post('filter-student-subject', 'FilterController@filterStudentSubject')->name('filter-student-subject');
    Route::post('filter-students', 'FilterController@filterStudent')->name('filter-students');
    Route::post('filter-techer-subject', 'FilterController@filterTecherSubject')->name('filter-techer-subject');
    Route::get('filter-student-data', 'FilterController@filterStudentData')->name('filter-student-data');
    Route::post('filter-item', 'InventoryController@filterItem')->name('filter-item');
    Route::post('filter-quantity', 'InventoryController@filterQuantity')->name('filter-quantity');
    Route::post('filter-department', 'InventoryController@filterDepartment')->name('filter-department');
    Route::post('filter-room', 'HostelController@filterRoom')->name('filter-room');
    Route::post('filter-vehicle', 'TransportController@filterVehicle')->name('filter-vehicle');
    Route::post('filter-submission-variable', 'ApprovalSubmissionCategoryController@submissionVariable')->name('filter-submission-variable');
    Route::post('filter-chapter', 'FilterController@filterChapter')->name('filter-chapter');
    Route::post('filter-requisition', 'FilterController@filterRequisition')->name('filter-requisition');

    Route::post('filter-rooms', 'FilterController@filterHostelRooms')->name('filter-rooms');

});


// Set Lang Version
Route::get('locale/language/{locale}', function ($locale){

    \Session::put('locale', $locale);

    \App::setLocale($locale);

    return redirect()->back();

})->name('version');




// Auth Routes
Route::middleware(['XSS'])->prefix('admin')->group(function () {
    // Auth::routes();
    Auth::routes(['register' => false]);
});

Route::middleware(['auth:web'])->name('admin.')->namespace('Admin')->prefix('admin')->group(function () {

Route::post('set-password','SetpasswordController@reset')->name('password.set');
Route::get('set-password','SetpasswordController@showSetPasswordForm')->name('set-password');
});


// Admin Routes
Route::middleware(['auth:web', 'XSS'])->name('admin.')->namespace('Admin')->prefix('admin')->group(function () {


    // if (isset(Auth::user()->id) && Auth::user()->is_admin != 1) {

    //     if(Auth::user()->staff_id == Crypt::decryptString(Auth::user()->password_text)) {

    //         return redirect(route('admin.set-password'));
    //     }
    // }

    // Dashboard Route
    Route::get('/', 'DashboardController@index')->name('dashboard.index');
    Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');

    Route::get('/passwd-update', function() {

        set_time_limit(10000);

        // $users = User::all();

        // foreach($users as $user){

        //     if($user->is_admin != 1){
        //         $user->password = Hash::make('password');
        //         $user->password_text = Crypt::encryptString('password');

        //         $user->update();
        //     }
        // }


        $students = Student::all();

        foreach($students as $student){

           // dd($student->roll_no);

          // if($student->password_text != Crypt::encryptString($student->roll_no)){
            $student->password = Hash::make($student->roll_no);
            $student->password_text = Crypt::encryptString($student->roll_no);

            $student->update();

          //  dd( $student);
        //   }

        }

      dd('done');

    });


    //Question Bank Routes
    Route::post('ckeditor/upload', 'QuestionBankController@ckeditorUpload')->name('question-bank.ckeditor.upload');
    Route::get('get-question-option', 'QuestionBankController@getQOption')->name('get-question-option');


    // Student Routes

    Route::get('setting/bulk-student', 'StudentController@bulkStudent')->name('bulk.student');

    Route::get('student/change-section', 'StudentGroupEnrollController@changeSection')->name('change.section');
    Route::post('student/storeStudentSection', 'StudentGroupEnrollController@storeStudentSection')->name('store.section');

    Route::resource('admission/application', 'ApplicationController');
    Route::resource('admission/student', 'StudentController');
    Route::get('admission/student-card/{id}', 'StudentController@card')->name('student.card');
    // Route::get('admission/student-status/{id}', 'StudentController@status')->name('student.status');
    Route::post('admission/student-send-password/{id}', 'StudentController@sendPassword')->name('student.send-password');
    Route::get('admission/student-print-password/{id}', 'StudentController@printPassword')->name('student.print-password');
    Route::post('admission/student-password-change', 'StudentController@passwordChange')->name('student-password-change');

    // Admission Routes
    Route::resource('admission/student-transfer-out', 'StudentTransferOutController');
    Route::resource('admission/student-transfer-in', 'StudentTransferInController');
    Route::resource('admission/status-type', 'StatusTypeController');
    Route::resource('admission/id-card-setting', 'StudentIdCardSettingController');

    Route::resource('placement/company', 'CompanyController');
    Route::resource('placement/category', 'PlacementCategoryController');
    Route::resource('project', 'ProjectController');
    Route::resource('counselling', 'CounsellingController');
// Start Assign Student
    Route::get('counsellor-report/index', 'CounsellingController@counsellorReportIndex')->name('counsellor-report.index');

    Route::get('assgin-student/create', 'CounsellingController@assignStudentCreate')->name('assign-student.create');
    Route::post('assign-student/store', 'CounsellingController@assignStudentStore')->name('assign-student.store');
// End

    Route::resource('compliance', 'ComplianceController');
    Route::resource('placement', 'PlacementController');
    Route::get('my-approval-submissions', 'ApprovalSubmissionController@myApprovals')->name('my-approval-submissions');
    Route::resource('approval-submissions', 'ApprovalSubmissionController');
    Route::resource('banks', 'BankController');
    Route::resource('addresses', 'AddressController');
    Route::resource('user-bank', 'UserBankController');
    Route::post('update-approval/{id}', 'ApprovalSubmissionController@updateApproval')->name('update-approval');
    Route::resource('feedback', 'FeedbackController');
    Route::resource('grievance', 'GrievanceController');
    Route::post('update-grievance/{id}', 'GrievanceController@updateGrievance')->name('update-grievance');
    Route::resource('student-report', 'StudentReportController');

    Route::resource('student/guardian-detail', 'GuardianDetailController');
    Route::post('update-academic-info/{id}', 'EducationController@updateAcademicInfo')->name('update-academic-info');
    Route::resource('student/entrance', 'EntranceController');
    Route::resource('student/document', 'DocumentController');
    // for Both User & Student
    Route::resource('education','EducationController');

    // User
    Route::resource('experience','ExperienceController');
    // expertise
    Route::resource('expertise','ExpertiseController');

    Route::post('update-payroll/{id}', 'UserController@updatePayroll')->name('update-payroll');
    Route::resource('chat', 'ChatController');
    Route::resource('chat-room', 'ChatRoomController');
    Route::get('chat-room-user', 'ChatRoomController@storeChatRoomUser')->name('chat-room-user');
    Route::get('get-role-user', 'ChatRoomController@getRoleUser')->name('get-role-user');
    Route::post('get-role-student', 'ChatRoomController@getRoleStudent')->name('get-role-student');

    Route::get('user-chat', 'ConversationController@getUserConversation')->name('user-chat');
    Route::resource('chat-participant', 'ChatParticipantController');
    Route::resource('conversation', 'ConversationController');
    Route::resource('event-user', 'EventUserController');
    Route::resource('event-announcement', 'EventAnnoucementController');
    Route::resource('ecourse-assignment', 'ECourseAssignmentController');
    Route::resource('donor', 'DonorController');
    Route::resource('scholarship', 'ScholarshipController');
    Route::resource('scholarship-student', 'ScholarshipStudentController');
    Route::resource('task', 'TaskController');
    Route::resource('faq', 'FAQController');
    Route::resource('hostel-attendance', 'HostelAttendanceController');
    Route::resource('fleets', 'FleetsController');
    Route::get('driver-details', 'FleetsController@driverDetails')->name('driver-details');
    Route::resource('device-log', 'DeviceLogController');

    //Research Staff
    Route::resource('research','ResearchController');

    //professional body Staff
    Route::resource('professional-body','ProfessionalBodyController');


    // Update Task
    Route::get('task-update/{task}', 'TaskController@updateStatus')->name('update-task-status');

    //Categories
    Route::resource('project-category', 'ProjectCategoryController');
    Route::resource('counselling-category', 'CounsellingCategoryController');
    Route::resource('renewal-category', 'RenewalCategoryController');
    Route::resource('renewal', 'RenewalController');
    Route::resource('compliance-category', 'ComplianceCategoryController');
    Route::resource('student-report-category', 'StudentReportCategoryController');
    Route::resource('grievance-category', 'GrievanceCategoryController');
    Route::resource('approval-submissions-category', 'ApprovalSubmissionCategoryController');
    Route::resource('faq-category', 'FAQCategoryController');
    Route::resource('seat-type', 'SeatTypeController');
    Route::resource('admission-type', 'AdmissionTypeController');
    Route::resource('caste', 'CasteController');
    Route::resource('user-category', 'UserCategoryController');
    Route::resource('address-type', 'AddressTypeController');
    Route::resource('relation-type', 'RelationController');
    Route::resource('document-type', 'DocumentTypeController');
    Route::resource('bank', 'BankController');
    Route::resource('student-intake', 'StudentIntakeController');

    Route::resource('mother-tongue', 'MotherTongueController');
    Route::resource('student-group', 'StudentGroupController');
    Route::resource('regulation', 'RegulationController');
    Route::resource('college-bank', 'CollegeBankController');
    Route::resource('fee-register', 'FeeRegisterController');
    Route::resource('
    -comment', 'PostCommentController');
    Route::resource('achievement-category', 'AchievementCategoryController');
    Route::resource('student-achievement', 'StudentAchievementController');
    Route::resource('fitness-student', 'FitnessStudentController');
    Route::resource('sports','SportsController');

    // Route::resource('hostel-master','HostelMasterController');






    // Student Attendance Routes
    Route::resource('student-attendance', 'StudentAttendanceController');
    Route::get('student-attendance-report', 'StudentAttendanceController@report')->name('student-attendance.report');
    Route::get('student-attendance-summary', 'StudentAttendanceController@summaryReport')->name('student-attendance.summary');

    // Student Leave Manage
    Route::resource('student-leave-manage', 'StudentLeaveManagementController');
    Route::post('student-leave-manage-status/{id}', 'StudentLeaveManagementController@status')->name('student-leave-manage.status');

    // Student Action Routes
    Route::resource('student/student-note', 'StudentNoteController');
    Route::resource('student/single-enroll', 'StudentSingleEnrollController');
    Route::resource('student/group-enroll', 'StudentGroupEnrollController');
    Route::resource('student/subject-adddrop', 'SubjectAddDropController');
    Route::resource('student/course-complete', 'CourseCompleteController');
    Route::resource('student/student-alumni', 'StudentAlumniController');



    // Academic Routes
    Route::resource('academic/faculty', 'FacultyController');
    Route::resource('academic/program', 'ProgramController');
    Route::resource('academic/batch', 'BatchController');
    Route::resource('academic/session', 'SessionController');
    Route::get('academic/session-current/{id}', 'SessionController@current')->name('session.current');
    Route::resource('academic/semester', 'SemesterController');
    Route::resource('academic/section', 'SectionController');
    Route::resource('academic/year-book', 'YearBookController');
    Route::resource('academic/book-subject', 'BookSubjectController');
    Route::get('academic/section/{id}', 'SectionController@show')->name('section.show');
    Route::post('assign-teacher/{id}', 'SectionController@assignSectionSemesterTeacher')->name('assign-teacher');

    Route::resource('academic/room', 'ClassRoomController');
    Route::resource('academic/subject', 'SubjectController');
    Route::resource('academic/enroll-subject', 'EnrollSubjectController');

    //Lession Route
    Route::resource('chapter','ChapterController');
    Route::resource('topic','TopicController');
    Route::resource('ecourse','ECourseController');
    Route::resource('ecourse-user','ECourseUserController');
    // Route::resource('ecourse-progress','ECourseProgressController');
    Route::get('ecourse-progress', 'ECourseProgressController@updateProgress')->name('ecourse-progress.update');

    Route::resource('esection','ESectionController');
    Route::resource('elesson','ELessonController');
    Route::resource('lesson-progress','LessonProgressController');
    Route::resource('placed-student','PlacedStudentController');
    Route::get('placed-student-list','PlacedStudentController@studentsList')->name('placed-student.student-list');
    Route::post('elesson/{id}/edit', 'ELessonController@edit')->name('elesson.edit');



    //Post Routes
    Route::resource('post', 'PostController');
    Route::resource('post-likes', 'PostLikeController');
    Route::resource('post-comment', 'PostCommentController');
    // Route::get('post-likes/{id}/index', 'PostLikeController@showLikes')->name('post-likes.index');
    // Route::delete('post-likes/destroy/{id}', 'PostLikeController@destroy')->name('post-likes.destroy');
    //Lession Access Type Route

    Route::resource('lesson-plan-access','LessonPlanAccessController');

    // Routine Routes
    Route::resource('academic/class-routine', 'ClassRoutineController');
    Route::get('academic/class-routine-teacher', 'ClassRoutineController@teacher')->name('class-routine.teacher');
    Route::post('academic/class-routine/print', 'ClassRoutineController@print')->name('class-routine.print');
    Route::get('get-subject-teacher-list', 'ClassRoutineController@getTeachers')->name('get-subject-teacher-list');
    Route::resource('academic/exam-routine', 'ExamRoutineController');
    Route::post('academic/exam-routine/print', 'ExamRoutineController@print')->name('exam-routine.print');
    Route::get('get-teachers', 'ExamRoutineController@getTeachers')->name('get-teachers');
    Route::get('academic/routine-setting/class', 'RoutineSettingController@class')->name('routine-setting.class');
    Route::get('academic/routine-setting/exam', 'RoutineSettingController@exam')->name('routine-setting.exam');
    Route::post('academic/routine-setting/store', 'RoutineSettingController@store')->name('routine-setting.store');


    //Compliance Attachment Routes
    Route::get('compliance/show/{id}/attachment', 'ComplianceAttachmentController@index')->name('compliance-attachment.show');
    Route::post('attachment/store', 'ComplianceAttachmentController@store')->name('compliance-attachment.store');
    Route::put('attachment/update/{id}', 'ComplianceAttachmentController@update')->name('compliance-attachment.update');
    Route::delete('attachment/destroy/{id}', 'ComplianceAttachmentController@destroy')->name('compliance-attachment.destroy');

    //Question Routes
    Route::resource('question-bank', 'QuestionBankController');
    Route::resource('test-paper', 'TestPaperController');
    Route::resource('test-paper-user', 'TestPaperUserController');

    //Test Paper Questions Routes
    Route::post('test-paper-question/store', 'TestPaperQuestionController@store')->name('test-paper-question.store');
    Route::put('test-paper-question/update/{id}', 'TestPaperQuestionController@update')->name('test-paper-question.update');
    Route::get('test-paper/{id}/index', 'TestPaperQuestionController@index')->name('test-paper.show');
    Route::delete('test-paper-question/destroy/{id}', 'TestPaperQuestionController@destroy')->name('test-paper-question.destroy');

    // Exam Routes
    Route::resource('exam/exam-attendance', 'ExamAttendanceController');
    Route::resource('exam/exam-marking', 'ExamMarkingController');
    Route::get('exam/exam-result', 'ExamMarkingController@result')->name('exam-result');
    Route::resource('exam/subject-marking', 'SubjectMarkingController');
    Route::get('exam/subject-result', 'SubjectMarkingController@result')->name('subject-result');
    Route::resource('exam/exam-type', 'ExamTypeController');
    Route::resource('exam/grade', 'GradeController');
    Route::resource('exam/result-contribution', 'ResultContributionController');
    Route::resource('exam/admit-card', 'AdmitCardController');
    Route::get('exam/admit-card-print/{id}', 'AdmitCardController@print')->name('admit-card.print');
    Route::get('exam/admit-card-multiprint', 'AdmitCardController@multiPrint')->name('admit-card.multiprint');
    Route::get('exam/admit-card-download/{id}', 'AdmitCardController@download')->name('admit-card.download');
    Route::resource('exam/admit-setting', 'AdmitCardSettingController');
    Route::get('exam/credit-hours-report', 'SubjectMarkingController@creditHourReport')->name('credit-hours-report');


    // Assignment Routes
    Route::resource('download/assignment', 'AssignmentController');
    Route::post('download/assignment-marking', 'AssignmentController@marking')->name('assignment.marking');

    // Content Routes
    Route::resource('download/content', 'ContentController');
    Route::resource('download/content-type', 'ContentTypeController');



    // Fees Collection Student
    Route::get('fees-student', 'FeesStudentController@index')->name('fees-student.index');
    Route::post('fees-student-pay', 'FeesStudentController@pay')->name('fees-student.pay');
    Route::post('fees-student-unpay/{id}', 'FeesStudentController@unpay')->name('fees-student.unpay');
    Route::post('fees-student-cancel/{id}', 'FeesStudentController@cancel')->name('fees-student.cancel');
    Route::get('fees-student-report', 'FeesStudentController@report')->name('fees-student.report');
    Route::get('fees-student-print/{id}', 'FeesStudentController@print')->name('fees-student.print');

    // Quick Collection Student
    Route::get('fees-student-quick-received', 'FeesStudentController@quickReceived')->name('fees-student.quick.received');
    Route::post('fees-student-quick-received', 'FeesStudentController@quickReceivedStore')->name('fees-student.quick.received.store');
    Route::get('fees-student-quick-assign', 'FeesStudentController@quickAssign')->name('fees-student.quick.assign');
    Route::post('fees-student-quick-assign', 'FeesStudentController@quickAssignStore')->name('fees-student.quick.assign.store');

    Route::get('fees-student-quick-received-bulk', 'FeesStudentController@quickReceivedBulk')->name('fees-student.quick-received-bulk');
    Route::post('fees-student-quick-received-bulk', 'FeesStudentController@quickReceivedStoreBulk')->name('fees-student.quick.received.store.bulk');


    // Fees Collection staff
    Route::get('fees-staff', 'FeesStaffController@index')->name('fees-staff.index');
    Route::post('fees-staff-pay', 'FeesStaffController@pay')->name('fees-staff.pay');
    Route::post('fees-staff-unpay/{id}', 'FeesStaffController@unpay')->name('fees-staff.unpay');
    Route::post('fees-staff-cancel/{id}', 'FeesStaffController@cancel')->name('fees-staff.cancel');
    Route::get('fees-staff-report', 'FeesStaffController@report')->name('fees-staff.report');
    Route::get('fees-staff-print/{id}', 'FeesStaffController@print')->name('fees-staff.print');

    // Quick Collection staff
    Route::get('fees-staff-quick-received', 'FeesStaffController@quickReceived')->name('fees-staff.quick.received');
    Route::post('fees-staff-quick-received', 'FeesStaffController@quickReceivedStore')->name('fees-staff.quick.received.store');
    Route::get('fees-staff-quick-assign', 'FeesStaffController@quickAssign')->name('fees-staff.quick.assign');
    Route::post('fees-staff-quick-assign', 'FeesStaffController@quickAssignStore')->name('fees-staff.quick.assign.store');



    // Fees Routes
    Route::get('fees-master-bulk', 'FeesMasterController@bulkCreate')->name('fees-master-bulk.index');
    Route::post('fees-master-bulk', 'FeesMasterController@bulkStore')->name('fees-master-bulk.bulkStore');

    Route::resource('fees-master', 'FeesMasterController');
    Route::resource('fees-type-master', 'FeesTypeMasterController');
    Route::resource('fees-discount', 'FeesDiscountController');
    Route::resource('fees-fine', 'FeesFineController');
    Route::resource('fees-category', 'FeesCategoryController');
    Route::resource('fees-receipt', 'ReceiptSettingController');
    Route::get('fees-receipt-print/{id}', 'ReceiptSettingController@print')->name('fees-receipt.print');



    // Human Resource Routes
    Route::resource('staff/designation', 'DesignationController');
    Route::resource('staff/holiday', 'HolidayMasterController');
    Route::resource('staff/department', 'DepartmentController');
    Route::resource('staff/work-shift-type', 'WorkShiftTypeController');
    Route::resource('staff/staff-note', 'StaffNoteController');
    Route::resource('staff/tax-setting', 'TaxSettingController');


    //Staff Acheivements
    Route::resource('faculty-achievements/books-published', 'BooksPublishedController');
    Route::resource('faculty-achievements/journals', 'StaffJournalsController');
    Route::resource('faculty-achievements/it-publication', 'StaffJournalsController');
    Route::resource('faculty-achievements/seed-grants', 'SeedGrantController');
    Route::resource('faculty-achievements/workshops-attended', 'WorkShopController');
    // Route::get('faculty-achievements/getWorkshopData', 'WorkShopController@getWorkshopData');
    Route::resource('faculty-achievements/patent', 'PatentController');
    //awards
    Route::resource('faculty-achievements/awards', 'AwardsController');
    Route::resource('faculty-achievements/funded-research', 'FundedResearchController');
    Route::resource('faculty-achievements/funded-research', 'FundedResearchController');
    Route::get('faculty-achievements/bulk-import', 'AchivementsBulkImportController@index');
    Route::post('faculty-achievements/bulk-import/{table}', 'AchivementsBulkImportController@import')->name('faculty-achievements.bulk-import');
    Route::get('faculty-achievements/bulk-export/{table}', 'AchivementsBulkImportController@export')->name('faculty-achievements.bulk-export');


    // Staff Routes
    Route::resource('staff/user','UserController');
    Route::get('staff/user-status/{id}', 'UserController@status')->name('user.status');
    Route::get('admission/user-card/{id}', 'UserController@card')->name('user.card');
    Route::post('staff/user-send-password/{id}', 'UserController@sendPassword')->name('user.send-password');
    // Route::get('staff/user-print-password/{id}', 'UserController@printPassword')->name('user.print-password');
    Route::post('staff/user-password-change', 'UserController@passwordChange')->name('user-password-change');

    // User Id Card
    Route::prefix('user/id-card-setting')->name('user.id-card-setting.')->group(function(){
        Route::get('index', 'UserIdCardSettingController@index')->name('index');
        Route::post('store', 'UserIdCardSettingController@store')->name('store');
    });

    // Staff Attendance Routes
    Route::resource('staff-daily-attendance', 'StaffAttendanceController');
    Route::get('staff-daily-report', 'StaffAttendanceController@report')->name('staff-daily-attendance.report');
    Route::resource('staff-hourly-attendance', 'StaffHourlyAttendanceController');
    Route::get('staff-hourly-report', 'StaffHourlyAttendanceController@report')->name('staff-hourly-attendance.report');
    Route::get('staff-hourly-report/{id}', 'StaffHourlyAttendanceController@reportDetails')->name('staff-hourly-attendance.report.details');

    // Staff Leave Routes
    Route::resource('staff/staff-leave', 'LeaveController');
    Route::get('get-leave-balance', 'LeaveController@getLeaveBalance')->name('leave.balance');
    Route::resource('staff/leave-type', 'LeaveTypeController');
    Route::resource('staff/leave-manage', 'LeaveManagementController');
    Route::post('staff/leave-manage-status/{id}', 'LeaveManagementController@status')->name('leave-manage.status');

    // Payroll Routes
    Route::resource('staff/payroll', 'PayrollController');
    Route::get('staff/payroll-generate/{id}/{month}/{year}', 'PayrollController@generate')->name('payroll.generate');
    Route::post('staff/payroll-pay/{id}', 'PayrollController@pay')->name('payroll.pay');
    Route::post('staff/payroll-unpay/{id}', 'PayrollController@unpay')->name('payroll.unpay');
    Route::get('staff/payroll-report', 'PayrollController@report')->name('payroll.report');
    Route::get('staff/payroll-print/{id}', 'PayrollController@print')->name('payroll.print');
    Route::resource('staff/pay-slip-setting', 'PaySlipSettingController');
    Route::get('transcript/pay-slip-setting-print/{id}', 'PaySlipSettingController@print')->name('pay-slip-setting.print');



    // Income Expense Routes
    Route::resource('account/income', 'IncomeController');
    Route::resource('account/income-category', 'IncomeCategoryController');
    Route::resource('account/expense', 'ExpenseController');
    Route::resource('account/expense-category', 'ExpenseCategoryController');
    Route::resource('account/exam-fee', 'ExamFeeController');
    Route::resource('account/outcome', 'OutcomeCalculationController');
    Route::prefix('exam-fee')->name('exam-fee.')->group(function(){
        Route::get('/','ExamFeeController@index')->name('index');
        Route::post('/store','ExamFeeController@store')->name('store');
        Route::get('/edit/{income}','ExamFeeController@edit')->name('edit');
        Route::post('/update/{income}','ExamFeeController@update')->name('update');
        Route::delete('/destroy/{income}','ExamFeeController@destroy')->name('destroy');
    });


    // Communicate Routes
    Route::resource('communicate/email-notify', 'EmailNotifyController');
    Route::resource('communicate/sms-notify', 'SMSNotifyController');
    Route::resource('communicate/event', 'EventController');
    Route::resource('communicate/event-category', 'EventCategoryController');
    Route::get('communicate/event-calendar', 'EventController@calendar')->name('event.calendar');
    Route::resource('communicate/notice', 'NoticeController');
    Route::resource('communicate/notice-category', 'NoticeCategoryController');



    // Library Routes
    Route::resource('library/library-autocheckinout', 'LibraryAutoCheckInOutController');
    Route::resource('library/library-attendence', 'LibraryAttendenceController');
    Route::resource('library/book-list', 'BookController');
    Route::get('library/book-list-token-print/{id}', 'BookController@tokenPrint')->name('book-list.token.print');
    Route::get('library/book-list-multitoken-print', 'BookController@multitokenPrint')->name('book-list.multitoken.print');
    Route::resource('library/book-request', 'BookRequestController');
    Route::resource('library/book-category', 'BookCategoryController');
    Route::resource('library/issue-return', 'IssueReturnController');
    Route::resource('library/requisition', 'RequisitionController');
     Route::get('/admin/requisitions/filter/{status}','RequisitionController@filterByStatus')->name('requisitions.filter');
    Route::resource('library/book-accordion','BookAccordionController');
    Route::resource('library/subject-master','SubjectMasterController');
    Route::get('library/issue-return-over', 'IssueReturnController@dateOver')->name('issue-return.over');
    Route::post('library/issue-return-penalty/{id}', 'IssueReturnController@penalty')->name('issue-return.penalty');


    // Library Member Routes
    Route::resource('member/library-student', 'LibraryStudentController');
    Route::resource('member/library-staff', 'LibraryStaffController');
    Route::resource('member/library-outsider', 'OutSideUserController');
    Route::post('member/library-outsider-status/{id}', 'OutSideUserController@status')->name('library-outsider.status');
    Route::get('member/library-student-card/{id}', 'LibraryStudentController@libraryCard')->name('library-student.card');
    Route::get('member/library-staff-card/{id}', 'LibraryStaffController@libraryCard')->name('library-staff.card');
    Route::get('member/library-outsider-card/{id}', 'OutSideUserController@libraryCard')->name('library-outsider.card');
    Route::resource('library-card-setting', 'LibraryIdCardSettingController');



    // Inventory Routes
    Route::resource('inventory/item-list', 'ItemController');
    Route::resource('inventory/item-issue', 'ItemIssueController');
    Route::post('inventory/item-issue-penalty/{id}', 'ItemIssueController@penalty')->name('item-issue.penalty');
    Route::resource('inventory/item-stock', 'ItemStockController');
    Route::resource('inventory/item-store', 'ItemStoreController');
    Route::resource('inventory/item-supplier', 'ItemSupplierController');
    Route::resource('inventory/item-category', 'ItemCategoryController');
    Route::resource('inventory/supplier-document', 'SupplierDocumentController');

    Route::get('inventory/item-supplier/documents/{id}', 'SupplierDocumentController@index')->name('supplier-documents.index');



    // Pl Routes
    Route::resource('hostel/hostel', 'HostelController');
    Route::resource('hostel/hostel-room', 'HostelRoomController');
    Route::resource('hostel/room-type', 'HostelRoomTypeController');
    Route::resource('hostel-student', 'HostelStudentController');
    Route::resource('hostel-staff', 'HostelStaffController');
    Route::get('hostel/student-fee-defaulters', 'HostelController@studentFeeDefaulter')->name('hostel.student-fee-defaulters');
    Route::get('hostel/staff-fee-defaulters', 'HostelController@staffFeeDefaulter')->name('hostel.staff-fee-defaulters');

    //hostel gate pass 
    Route::resource('hostel/student-gatepass','HostelStudentGatePassController');

    // Transport Routes
    Route::resource('transport-route', 'TransportRouteController');
    Route::resource('transport-vehicle', 'TransportVehicleController');
    Route::resource('transport-student', 'TransportStudentController');
    Route::resource('transport-halt', 'TransportHaltController');
     Route::resource('transport-vehicle-log','VehicleLogBookController');

    Route::resource('transport-staff', 'TransportStaffController');
    Route::get('transport/student-fee-defaulters', 'TransportReportController@studentFeeDefaulter')->name('transport.student-fee-defaulters');
    Route::get('transport/staff-fee-defaulters', 'TransportReportController@staffFeeDefaulter')->name('transport.staff-fee-defaulters');



    // Visitor Routes
    Route::resource('frontdesk/visitor', 'VisitorController');
    Route::get('frontdesk/visitor-out/{id}', 'VisitorController@outTime')->name('visitor.out');
    Route::get('frontdesk/visitor-token-print/{id}', 'VisitorController@tokenPrint')->name('visitor.token.print');
    Route::resource('frontdesk/visit-purpose', 'VisitPurposeController');
    Route::resource('frontdesk/visitor-token-setting', 'VisitorTokenSettingController');

    // UserLog Routes
    Route::resource('frontdesk/user-log', 'UserLogController');

    // Phone Log Routes
    Route::resource('frontdesk/phone-log', 'PhoneLogController');

    // Enquiry Routes
    Route::resource('frontdesk/enquiry', 'EnquiryController');
    Route::post('frontdesk/enquiry-status/{id}', 'EnquiryController@status')->name('enquiry.status');
    Route::resource('frontdesk/enquiry-source', 'EnquirySourceController');
    Route::resource('frontdesk/enquiry-reference', 'EnquiryReferenceController');

    // Complain Routes
    Route::resource('frontdesk/complain', 'ComplainController');
    Route::post('frontdesk/complain-status/{id}', 'ComplainController@status')->name('complain.status');
    Route::resource('frontdesk/complain-type', 'ComplainTypeController');
    Route::resource('frontdesk/complain-source', 'ComplainSourceController');

    // Postal Exchange Routes
    Route::resource('frontdesk/postal-exchange', 'PostalExchangeController');
    Route::resource('frontdesk/postal-type', 'PostalExchangeTypeController');

    // Postal Exchange Routes
    Route::resource('frontdesk/meeting', 'MeetingScheduleController');
    Route::post('frontdesk/meeting-status/{id}', 'MeetingScheduleController@status')->name('meeting.status');
    Route::resource('frontdesk/meeting-type', 'MeetingTypeController');




    // Marksheet Routes
    Route::resource('transcript/marksheet', 'MarksheetController');
    Route::get('transcript/marksheet-print/{id}', 'MarksheetController@print')->name('marksheet.print');
    Route::get('transcript/marksheet-download/{id}', 'MarksheetController@download')->name('marksheet.download');
    Route::resource('transcript/marksheet-setting', 'MarksheetSettingController');
    // Print Preview
    Route::get('transcript/marksheet-setting-print/{id}', 'MarksheetSettingController@print')->name('marksheet-setting.print');

    // Certificate Routes
    Route::resource('transcript/certificate', 'CertificateController');
    Route::get('transcript/certificate-print/{id}', 'CertificateController@print')->name('certificate.print');
    Route::get('transcript/certificate-download/{id}', 'CertificateController@download')->name('certificate.download');
    Route::resource('transcript/certificate-template', 'CertificateTemplateController');




    // Setting Routes
    Route::get('setting', 'SettingController@index')->name('setting.index');
    Route::post('setting/siteinfo', 'SettingController@siteInfo')->name('setting.siteinfo');

    // Address Routes
    Route::resource('setting/country','CountryController');
    Route::resource('setting/province','ProvinceController');
    Route::resource('setting/district','DistrictController');

    // Language Routes
    Route::resource('setting/language', 'LanguageController');
    Route::get('setting/language-default/{id}', 'LanguageController@default')->name('language.default');

    // Translations Routes
    Route::get('translations', 'TranslateController@index')->name('translations.index');
    Route::post('translations/create', 'TranslateController@store')->name('translations.create');
    Route::post('translations/update', 'TranslateController@transUpdate')->name('translation.update.json');
    Route::post('translations/updateKey', 'TranslateController@transUpdateKey')->name('translation.update.json.key');
    Route::delete('translations/destroy/{key}', 'TranslateController@destroy')->name('translations.destroy');

    // Roles And Permission Routes
    Route::resource('setting/role','RoleController');

    // Env Setting Routes
    Route::resource('setting/mail-setting','MailSettingController');
    Route::resource('setting/sms-setting','SMSSettingController');

    // DB Import Export Routes
    Route::get('setting/bulk-import-export', 'BulkImportExportController@importExportView')->name('bulk.import-export');
    Route::get('setting/bulk-export/{table}', 'BulkImportExportController@export')->name('bulk.export');
    Route::post('setting/bulk-import/{table}', 'BulkImportExportController@import')->name('bulk.import');

    // Sechedule Setting
    Route::resource('setting/schedule-setting', 'ScheduleSettingController');

    // Application Setting
    Route::resource('setting/application-setting', 'ApplicationSettingController');




    // Profile Routes
    Route::resource('profile','ProfileController');
    Route::get('profile/account', 'ProfileController@account')->name('profile.account');
    Route::post('profile/changemail', 'ProfileController@changeMail')->name('profile.changemail');
    Route::post('profile/changepass', 'ProfileController@changePass')->name('profile.changepass');

    // Report Routes

    Route::prefix('report')->name('report.')->group(function(){
        
        Route::get('/student-attendence','ReportController@studentAttendence')->name('student-attendence');
        Route::get('/staff-attendence','ReportController@staffAttendence')->name('staff-attendence');
        Route::get('/exam-results','ReportController@examResults')->name('exam-results');

        Route::get('/admissionvsintake','ReportController@AdmissionVsIntake')->name('admissionvsintake');
        Route::get('/eamcet-rank-range','ReportController@eamcetrankrange')->name('eamcet-rank-range');
        Route::get('/seat-types','ReportController@seattypes')->name('seat-types');
        Route::get('/hostel-occupancy','ReportController@hosteloccupancy')->name('hostel-occupancy');
        Route::get('/student-management','ReportController@studentManagement')->name('student-management');
        Route::get('/employee-staff-management','ReportController@employeeStaffManagement')->name('employee-staff-management');
        Route::get('/fee-payment-tracking','ReportController@feePaymenTracking')->name('fee-payment-tracking');
        Route::get('/hostel-management','ReportController@hostelManagement')->name('hostel-management');
        Route::get('/payroll','ReportController@payroll')->name('payroll');
        Route::get('/id-cards-issue','ReportController@idCardsIssue')->name('id-cards-issue');
        Route::get('/vendor-management','ReportController@vendorManagement')->name('vendor-management');
        Route::get('/inventory-management','ReportController@inventoryManagement')->name('inventory-management');
        Route::get('/transportation-management','ReportController@transportationManagement')->name('transportation-management');
        Route::get('/asset-management','ReportController@assetManagement')->name('asset-management');
        Route::get('/receipts-and-invoices','ReportController@receiptsAndInvoices')->name('receipts-and-invoices');
        Route::get('/accounting','ReportController@accounting')->name('accounting');
        Route::get('/daily-reports','ReportController@dailyReports')->name('daily-reports');
        Route::get('/award-reports','ReportController@awardReports')->name('award-reports');
    });
    //ravi
    Route::get('dataUpdateAdmin','DataUpdateController@create');
    Route::post('getTableColumns','DataUpdateController@getTableColumns')->name('getTableColumns');
    Route::post('updateTableData','DataUpdateController@updateTableData')->name('updateTableData');

});



//End Admin Routes


//Start Student Routes
// Route::get('/', function () {
//     return view('auth.multi-login');
//     // return "ok";
// });
// Student Login Routes
Route::prefix('student')->name('student.')->namespace('Student')->group(function(){

    Route::namespace('Auth')->group(function(){

        // Login Routes
        Route::get('/login','LoginController@showLoginForm')->name('login');
        Route::post('/login','LoginController@login')->name('login.store');
        Route::post('/logout','LoginController@logout')->name('logout');

        // Register Routes
        // Route::get('/register','RegisterController@showRegisterForm')->name('register');
        // Route::post('/register','RegisterController@register')->name('register.store');

        // Forgot Password Routes
        Route::get('/password/reset','ForgotPasswordController@showLinkRequestForm')->name('password.request');
        Route::post('/password/email','ForgotPasswordController@sendResetLinkEmail')->name('password.email');

        // Reset Password Routes
        Route::get('/password/reset/{token}/{email}','ResetPasswordController@showResetForm')->name('password.reset');
    });

});

Route::middleware(['auth:student', 'XSS'])->prefix('student')->name('student.')->namespace('Student')->group(function () {
    Route::post('set-password','SetpasswordController@reset')->name('password.set');
    Route::get('set-password','SetpasswordController@showSetPasswordForm')->name('set-password');
});




// Student Dashboard Routes
Route::middleware(['auth:student', 'XSS'])->prefix('student')->name('student.')->namespace('Student')->group(function () {

    // Route::get('set-password','SetpasswordController@showSetPasswordForm')->name('set-password');

    // Dashboard Route
    Route::get('student-dashboard', 'DashboardController@studentIndex')->name('student-dashboard.index');
    
        Route::get('student-course-dashboard', 'DashboardController@studentCourseIndex')->name('student-course-dashboard.index');

    Route::get('student-courses', 'DashboardController@studentCourses')->name('student-courses');
    Route::get('student-courses-info/{id}', 'DashboardController@studentCoursesInfo')->name('student-courses-info');
    Route::get('student-books', 'DashboardController@studentBooks')->name('student-books');
    Route::get('student-exams-info', 'DashboardController@studentExams')->name('student-exams-info');
    Route::get('student-exam-disclaimer/{id}', 'DashboardController@studentExamWatch')->name('student-exam-disclaimer');
    Route::post('student-exam-started/{id}', 'DashboardController@studentExamStarted')->name('student-exam-started');
    Route::get('student-exam-submitted/{id}', 'DashboardController@studentExamSubmitted')->name('student-exam-submitted');
    Route::get('student-exam-report/{id}', 'DashboardController@studentExamReport')->name('student-exam-report');

    Route::get('student-calender', 'DashboardController@studentCalender')->name('student-calender');
    // Route::get('/', 'DashboardController@index')->name('dashboard.index');
    Route::get('/', 'DashboardController@studentIndex')->name('dashboard.index');
    // Route::get('dashboard', 'DashboardController@index')->name('dashboard.index');
    Route::get('student-course-watch/{id}', 'DashboardController@studentCoursesWatch')->name('student-course-watch');

    Route::get('student-check-my-bus', 'TransportStudentController@checkMyBus')->name('check-bus.index');
    Route::get('yearbook', 'YearbookController@index')->name('yearbook.index');
    Route::get('/preview-yearbook-doc/{mediaId}', 'YearbookController@show')->name('preview-yearbook-doc.show');


    Route::get('placements', 'PlacementController@index')->name('placements.index');
    Route::post('apply', 'PlacementController@apply')->name('placements.apply');


    // Transcript Routes
    Route::get('transcript', 'TranscriptController@index')->name('transcript.index');

    // Assignment Routes
    Route::get('student-assignments', 'AssignmentController@studentAssignments')->name('student-assignments');
    Route::get('assignment', 'AssignmentController@index')->name('assignment.index');
    Route::get('assignment/{id}', 'AssignmentController@show')->name('assignment.show');
    Route::post('assignment/{id}/update', 'AssignmentController@update')->name('assignment.update');

    // Class Routine Routes
    Route::get('student-class-routine', 'ClassRoutineController@studentClassRouting')->name('student-class-routine');
    Route::get('class-routine', 'ClassRoutineController@index')->name('class-routine.index');

    // Attendance Report
    Route::get('student-attendance', 'AttendanceController@studentAttendance')->name('student-attendance');
    Route::get('attendance', 'AttendanceController@index')->name('attendance.index');

    // Exam Routine Routes
    Route::get('student-exam-routine', 'ExamRoutineController@studentExamRoutine')->name('student-exam-routine');
    Route::get('exam-routine', 'ExamRoutineController@index')->name('exam-routine.index');
    
     //Results
    Route::get('student-results', 'ResultsController@studentResults')->name('student-results');
    Route::get('results', 'ResultsController@index')->name('results.index');


    // Fees Routes
    Route::get('fees', 'FeesController@index')->name('fees.index');

    // Library Routes
    Route::get('student-library', 'LibraryController@studentLibrary')->name('student-library');
    Route::get('library', 'LibraryController@index')->name('library.index');

    // Calendar Routes
    // Route::get('event-calendar', 'EventController@calendar')->name('event.calendar');

    // Notice Routes
    Route::get('student-notices', 'NoticeController@studentNotices')->name('student-notices');
    Route::get('notice', 'NoticeController@index')->name('notice.index');
    Route::get('notice/{id}', 'NoticeController@show')->name('notice.show');

    // Leave Routes
    Route::get('student-apply-leave', 'LeaveController@studentApplyLeave')->name('student-apply-leave');
    Route::resource('leave', 'LeaveController');


    // Leave Routes
    Route::get('student-grievance', 'GrievanceController@studentGrievance')->name('student-grievance');
    Route::resource('grievance', 'GrievanceController');

    // Approval Submission
    Route::get('student-approval-submissions', 'ApprovalSubmissionController@studentApprovals')->name('student-approval-submissions');
    Route::resource('approval-submissions', 'ApprovalSubmissionController');

    //Transportation

    Route::resource('transport-student', 'TransportStudentController');


    // Projects
    Route::get('student-projects', 'ProjectController@index')->name('projects.index');
    Route::post('student-projects/store', 'ProjectController@store')->name('projects.store');
    Route::get('student-projects/edit/{id}', 'ProjectController@edit')->name('projects.edit');
    Route::post('student-projects/update{project}', 'ProjectController@update')->name('projects.update');
    Route::delete('student-projects/destroy/{project}', 'ProjectController@destroy')->name('projects.destroy');


    // Counselling
    Route::get('student-counselling', 'CounsellingController@index')->name('counselling.index');
    Route::post('student-counselling/store', 'CounsellingController@store')->name('counselling.store');
    Route::get('student-counselling/edit/{id}', 'CounsellingController@edit')->name('counselling.edit');
    Route::post('student-counselling/update{counselling}', 'CounsellingController@update')->name('counselling.update');
    Route::delete('student-counselling/destroy/{counselling}', 'CounsellingController@destroy')->name('counselling.destroy');



    // Download Routes
    Route::get('student-download', 'DownloadCenterController@studentDownload')->name('student-download');
    Route::get('download', 'DownloadCenterController@index')->name('download.index');
    Route::get('download/{id}', 'DownloadCenterController@show')->name('download.show');

    // Profile Routes
    Route::resource('profile','ProfileController');
    Route::get('student-account-setting', 'ProfileController@accountSetting')->name('student-account-setting-general');
    Route::get('student-account-details', 'ProfileController@accountSettingDetails')->name('student.student-account-details');
    Route::post('student-photo-submission', 'ProfileController@photoSubmission');

    Route::get('student-account-setting-privacy', 'ProfileController@accountSettingPrivacy')->name('student-account-setting-privacy');
    Route::get('profile/account', 'ProfileController@account')->name('profile.account');
    // Route::post('profile/changemail', 'ProfileController@changeMail')->name('profile.changemail');
    // Route::post('profile/changepass', 'ProfileController@changePass')->name('profile.changepass');

    // Route::resource('test-paper-progress', 'TestPaperProgressController');
    Route::get('test-paper-progress', 'TestPaperProgressController@updateProgress')->name('test-paper-progress.update');
    Route::get('test-paper-progress-bulk', 'TestPaperProgressController@updateProgressBulk')->name('test-paper-progress.update-bulk');

    Route::resource('chat', 'ChatController');
    Route::get('chat-room-user', 'ChatRoomController@storeChatRoomUser')->name('chat-room-user');
    Route::get('user-chat', 'ConversationController@getUserConversation')->name('user-chat');
    Route::resource('conversation', 'ConversationController');
    Route::get('get-role-user', 'ChatRoomController@getRoleUser')->name('get-role-user');
    Route::post('get-role-student', 'ChatRoomController@getRoleStudent')->name('get-role-student');


});
Route::get('/getCourseLesson', [DashboardController::class, 'getLesson']);
Route::get('/login', [FilterController::class, 'login']);
Route::get('/json-data', [FilterController::class, 'getData']);

//kaleyra api's
Route::get('/kaleyraHttp', [FilterController::class, 'kaleyraHttp']);
Route::get('/kaleyraCurl', [FilterController::class, 'kaleyraCurl']);
Route::get('/mobileNotification', [FilterController::class, 'mobileNotification']);


