<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\QuestionBank;
use App\Models\Session;
use Illuminate\Http\Request;
use App\Models\TestPaperProgress;
use App\Models\TestPaper;
use App\Models\TestPaperQuestion;
use App\Models\TestPaperUser;


class TestPaperProgressController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateProgress(Request $request)
    {        
        $test_paper = TestPaper::find($request->test_paper_id);
        $student = TestPaperUser::where('test_paper_id',$request->test_paper_id)->first();
        
        $testPaper = $test_paper->testPaperQuestions->where('id',$request->question_id)->first();
        $correct_options = $testPaper->questions->correct_options;
        if($testPaper->questions->type == 'single' || $testPaper->questions->type == 'blank' || $testPaper->questions->type == 'boolean'){
            $correct_val = $testPaper->questions->options[$correct_options];
            if($correct_val == $request->answers){
                $score = 1;
            }else{
                $score = 0;
            }
            $answer = [
                $request->answers
            ];
        }elseif($testPaper->questions->type == 'multi'){
            $values = $testPaper->questions->options;
            $indices = $correct_options-1;
            $correct_val = [];
            foreach ($indices as $index) {
            $parsedIndex = intval($index);
                if ($parsedIndex >= 0 && $parsedIndex < count($values)) {
                    $correct_val[] = $values[$parsedIndex];
                }
            }
            if(empty(array_diff($correct_val,$request->answers))){
                $score = 1;
            }else{
                $score = 0;
            }
            $answer = $request->answers;
        }
        
        $test_paper_progress = TestPaperProgress::where('test_paper_id',$request->test_paper_id)->where('question_id',$request->question_id)->where('student_id',$student->id)->first();
        if(!$test_paper_progress){
            $test_paper_progress = new TestPaperProgress;
            $test_paper_progress->test_paper_id = $request->test_paper_id;
            $test_paper_progress->student_id = $student->id;
            $test_paper_progress->question_id = $request->question_id;
            $test_paper_progress->answers = $answer;
            $test_paper_progress->score = $score;
            $test_paper_progress->save();
        }else{
            $test_paper_progress->answers = $answer;
            $test_paper_progress->score = $score;
            $test_paper_progress->save();
        }
        return true;
    }

    public function updateProgressBulk(Request $request)
    {
      //  dd($request->all());

        $test_paper = TestPaper::find($request->test_paper_id);
        $student = TestPaperUser::where('test_paper_id',$request->test_paper_id)->first();

        // $test_paper_questions = TestPaperQuestion::where('testpaper_id', $request->test_paper_id)->get();

        // $test_paper_questions =  $test_paper_questions->where()
       
        $i=0;

        $testPaperQuestions = $test_paper->testPaperQuestions;

        foreach($testPaperQuestions as $question){

            $score=0;
            
            $test_paper_progress = TestPaperProgress::where('test_paper_id',$request->test_paper_id)->where('question_id',$question->id)->where('student_id',$student->id)->first();
            
            $test_paper_questions = TestPaperQuestion::where('id', $question->id)->first();

            $question_bank = QuestionBank::where('id', $test_paper_questions->question_bank_id)->first();

          //  dd($question_bank);

            if($question_bank->type != 'multi'){

                if(in_array($question_bank->correct_options, $request->correct_answer[$i])){
                    $score = 1;
                }                
            }else{
                $result = array_diff($question_bank->correct_options, $request->correct_answer[$i]);

                if (empty($result)) {
                    $score = 1;
                } 
            }

            if(!$test_paper_progress){
                $test_paper_progress = new TestPaperProgress;
                $test_paper_progress->test_paper_id = $request->test_paper_id;
                $test_paper_progress->student_id = $student->id;
                $test_paper_progress->question_id = $question->id;
                $test_paper_progress->answers = $request->correct_answer[$i++];
                $test_paper_progress->score = $score;
                $test_paper_progress->save();
            }
        }
        $TestPaperUser = TestPaperUser::where('test_paper_id',$test_paper->id)->where('student_id',auth()->id())->first();
        $TestPaperUser->status = TestPaperUser::STATUS_COMPLETED;
        $TestPaperUser->save();

        $i++;

        return redirect()->route('student.student-exam-submitted',$test_paper->id)->with('success','Successfully submitted');
    }
}
