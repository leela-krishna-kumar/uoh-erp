<?php

namespace App\Models;
use App\User;

use Illuminate\Notifications\Notifiable;
use App\Notifications\ContentNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Student extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $guarded = ['id'];
    protected $table= 'students';
    protected $hidden = [
        'password', 'remember_token',
    ];
    protected $appends = [
        'full_name' , 'name' 
      ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'managed_by' => 'array',
    ];

  

    public function faculty()
    {
        return $this->belongsTo(Faculty::class, 'faculty_id');
    }
    public function batch()
    {
        return $this->belongsTo(Batch::class, 'batch_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }

    public function session()
    {
        return $this->belongsTo(Session::class, 'session_id');
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class, 'semester_id');
    }
    public function section()
    {
        return $this->belongsTo(Section::class, 'section_id');
    }

    public function statusType()
    {
        return $this->belongsTo(StatusType::class, 'status');
    }

    public function studentEnrolls()
    {
        return $this->hasMany(StudentEnroll::class, 'student_id');
    }

    public function currentEnroll()
    {
        return $this->hasOne(StudentEnroll::class, 'student_id')->ofMany([
            'id' => 'max',
        ], function ($query) {
            $query->where('status', '1');
        });
    }

    public function relatives()
    {
        return $this->hasMany(StudentRelative::class, 'student_id', 'id');
    }

    public function exams()
    {
        return $this->hasMany(Exam::class, 'student_id', 'id');
    }

    public function leaves()
    {
        return $this->hasMany(StudentLeave::class,'student_id', 'id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'student_id', 'id');
    }

    public function presentProvince()
    {
        return $this->belongsTo(Address::class, 'id','model_id')->where('model_type',Student::class);
    }

    public function presentDistrict()
    {
        return $this->belongsTo(Address::class, 'id','model_id')->where('model_type',Student::class);
    }

    public function permanentProvince()
    {
        return $this->belongsTo(Address::class, 'id','model_id')->where('model_type',Student::class)->where('is_permanent',1);
    }

    public function permanentDistrict()
    {
        return $this->belongsTo(Address::class, 'id','model_id')->where('model_type',Student::class)->where('is_permanent',1);
    }

    public function statuses()
    {
        return $this->belongsToMany(StatusType::class, 'status_type_student', 'student_id', 'status_type_id');
    }

    public function studentTransfer()
    {
        return $this->hasOne(StudentTransfer::class, 'student_id');
    }

    public function transferCreadits()
    {
        return $this->hasMany(TransferCreadit::class, 'student_id');
    }
    

    // Polymorphic relations
    public function documents()
    {
        return $this->morphToMany(Document::class, 'docable');
    }

    public function contents()
    {
        return $this->morphToMany(Content::class, 'contentable');
    }

    public function notices()
    {
        return $this->morphToMany(Notice::class, 'noticeable');
    }

    public function member()
    {
        return $this->morphOne(LibraryMember::class, 'memberable');
    }

    public function hostelRoom()
    {
        return $this->morphOne(HostelMember::class, 'hostelable');
    }

    public function transport()
    {
        return $this->morphOne(TransportMember::class, 'transportable');
    }

    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }

    public function transactions()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    // Get Current Enroll
    public static function enroll($id)
    {
        $enroll = StudentEnroll::where('student_id', $id)
                                ->where('status', '1')
                                ->orderBy('id', 'desc')
                                ->first();

        return $enroll;
    }
   
    public function eCourseUser()
    {
        return $this->hasMany(ECourseUser::class, 'student_id');
    }

    public function testPaperUser()
    {
        return $this->hasMany(TestPaperUser::class, 'student_id');
    }
    public function getFullNameAttribute() {
        return ucwords($this->first_name.' '.$this->last_name);
     }
     public function getNameAttribute() {
         return ucwords($this->first_name.' '.$this->last_name);
      } 
     
      public function permanentAddress()
    {
        return $this->belongsTo(Address::class, 'id','model_id')->where('model_type',Student::class)->where('is_permanent',1);
    }
    public function presentAddress()
    {
        return $this->belongsTo(Address::class, 'id','model_id')->where('model_type',Student::class);
    }
    public function motherTongue()
    {
        return $this->belongsTo(MotherTongue::class, 'mother_tongue', 'id');
    }
    public function userCategory()
    {
        return $this->belongsTo(UserCategory::class, 'user_category_id', 'id');
    }
    public function casteName()
    {
        return $this->belongsTo(Caste::class, 'caste', 'id');
    }
    public function seatType()
    {
        return $this->belongsTo(SeatType::class, 'seat_type_id', 'id');
    }
    public function group()
    {
        return $this->belongsTo(StudentGroup::class, 'group_id', 'id');
    }
    
      public function userBank()
    {
        return $this->belongsTo(UserBank::class, 'id','mother_tongue');
    }


    public function teacher()
    {
        return $this->belongsTo(User::class, 'counselled_by');
    }

}
