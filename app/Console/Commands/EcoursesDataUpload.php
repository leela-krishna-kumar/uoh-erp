<?php

namespace App\Console\Commands;

use App\Models\ECourse;
use App\Models\ELesson;
use App\Models\ESection;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EcoursesDataUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'e_courses_data_upload';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'e_courses_data_upload';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        dd("please check table name");
        $result = $this->dataUpload();
        dd($result);
    }

    public function dataUpload()
    {
        $table = 'course_etm_gnits';
        // $records = DB::table($table)->where('corse_status',0)->get();
        $distinct_courses = DB::table($table)->select('course','semester_id')->distinct()->get();
        // return ($distinct_courses);
        $this->info('total recirds '.count($distinct_courses));
        foreach ($distinct_courses as $course_gnits){
            // return ($course_gnits->course);
            $course_exist = ECourse::where('title',$course_gnits->course)->first();
            if ($course_exist){

                DB::table($table)->where('course',$course_gnits->course)->update(['course_status'=>$course_exist->id]);
                $this->info('inside');
                continue ;
            }
            $course = new ECourse();
            $course->title = $course_gnits->course;
            $course->semester_id = $course_gnits->semester_id;
            $course->is_published = 1;
            $course->created_by = 1;
            $course->save();

            if ($course) {
                $this->info("course created ".$course->id);
                Log::info("course created ".$course->id);
                // return $course;
                $course_update = DB::table($table)->where('course',$course->title)->update(['course_id'=>$course->id,'course_status'=>1]);//
                if ($course_update) {
                    // $this->createdSection()
                    $sections = DB::table($table)->where('course_id',$course->id)->select('section','course_id')->distinct()->get();

                    $this->info('total sections '.count($sections));
                    Log::info('total sections '.count($sections));
                    // dd("ravi");
                    $sequence = 1;
                    foreach ($sections as $section_gnits) {
                        // return $section_gnits;

                        $section = new ESection();
                        $section->title = $section_gnits->section;
                        $section->e_course_id = $section_gnits->course_id;
                        $section->created_by = 1;
                        $section->sequence = $sequence;
                        $section->short_description = $section_gnits->section;
                        $section->save();
                        if ($section) {
                            $this->info("section created ".$section->id);
                            Log::info("section created ".$section->id);
                        $update_section = DB::table($table)->where('course_id',$course->id)->where('section',$section_gnits->section)->update(['section_id'=>$section->id]);
                        }
                        if ($update_section){
                            // return $section;
                        $lesson_create = $this->createlessons($section->id,$course->id);
                        }
                        $sequence ++;
                    }

                }

            }else {
                Log::info("course not created ");
            }
        }
        return "done";
    }
    public function createlessons($section_id,$course_id)
    {
        $table = 'course_etm_gnits';
        $leasson_records = DB::table($table)->where('section_id',$section_id)->where('course_id',$course_id)->get();
        $this->info('total lessons '.count($leasson_records));
        Log::info('total lessons '.count($leasson_records));
        foreach ($leasson_records as $lesson_gnits){
            $leasson = new ELesson();
            $leasson->title = $lesson_gnits->lesson;
            $leasson->is_published = 1;
            $leasson->type =  'Video';
            // $leasson->type_id = 'null'
            $leasson->e_section_id = $lesson_gnits->section_id;
            $leasson->created_by = 1;
            $leasson->short_description = $lesson_gnits->lesson;
            $leasson->link = $lesson_gnits->url;
            $leasson->save();
            if ($leasson){
                $this->info("leasson created ".$leasson->id);
                Log::info("leasson created ".$leasson->id);

            }
        }
    }
}
