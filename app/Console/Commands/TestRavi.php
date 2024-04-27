<?php

namespace App\Console\Commands;

use App\Models\EnrollSubject;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TestRavi extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'test_ravi';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'test_ravi';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $result = $this->updateProgram();
        // dd($result);
        $this->info($result);
    }
    public function updateProgram()
    {
        $enroll_subjects_all = DB::table('enroll_subjects')->where('id','>',34)->get();
        dd(count($enroll_subjects_all));
        foreach ($enroll_subjects_all as $enroll_subjects){
            // dd($enroll_subjects);
            $subjects = DB::table('gnits_btech_subjects')
                ->where('program_id',$enroll_subjects->program_id)
                ->where('semester_id',$enroll_subjects->semester_id)
                ->where('section_id',$enroll_subjects->section_id)
                ->pluck('subject_id');
                // ->select('subject_id')
                // ->get();
            // return $subjects;
            $enrollSubject = EnrollSubject::where('id',$enroll_subjects->id)->first();

            // Attach Update
            $enrollSubject->subjects()->sync($subjects);
            // return $enrollSubject;
            // break;
            $this->info("processed ".$enroll_subjects->id);

        }
        return "done";

    }
}
