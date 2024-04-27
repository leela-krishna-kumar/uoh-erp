@extends('student.layouts.student-master')

@section('content')

<!-- Start Content-->
@section('content')
<style>


    .quiz-title {
      grid-area: quiz-title;
      font-weight: 800;
      font-size: 20px;
      
    }
    .question-section {
      grid-area: question-section
    }
    
    .question {
      padding: 0.5rem;
      border: 2px solid #799efe;
      border-radius: 0.5rem;
      margin-bottom: 1.5rem;
    }
    .question .question-text {
      margin-bottom: 0.5rem;
    }
    .none_event{
     pointer-events: none !important;
    }
    
    .question .question-num {
      font-weight: 700; 
      font-size: 0.9rem;
      margin-bottom: 1rem; 
    }
    
    .answer-item {
      padding: 0.8rem 0;
      display:block;
      box-shadow: 0 5px 5px rgba(0, 0, 0, 0.1);
      border-radius: 0.5rem;
      margin-bottom: 0.9rem;
      cursor: pointer;
    }
    
    .answer-item.checked {
      background: #aabdff;
      color: #fff;
    }
    
    .answer-item.wrong {
      background: #da4955;
      color: #fff;
    }
    
    .answer-item span {
      margin-left: 1.5rem;
    }
    
    .answer-item:hover,
    .answer-item:active {
      background: #aabdff;
      color: #fff;
    }
    
    .answer-item input[type="radio"] {
      display: none;
    } 
    
    .action {
      margin-top: 1.5rem;
      
    }
    
    .btn {
      background: inherit;
      border: 0;
      border-radius: 0.5rem; 
      box-shadow: 0 7px 7px rgba(0, 0, 0, 0.1);
      padding: 0.5rem 1rem;
      font-weight: 700;
      cursor: pointer;
    }
    
    .btn:hover,
    .btn:active { 
      background: #aabdff;
      color: #fff;
    } 
    
    .explanation-section {
      grid-area: explanation-section;
      padding: 0.5rem; 
      border-radius: 0.5rem;
      box-shadow: 0 7px 7px rgba(0, 0, 0, 0.1);
    }
    
    .explanation-section .section-title {
      font-weight: 700;
      font-size: 0.9rem;
      margin-bottom: 1rem; 
    } 
    
    .explanation-section .explanation-text {
      margin-right: 1rem;
      margin-left: 1rem;
      margin-bottom: 1.5rem;
    }
    
    .questions-nav-section {
      grid-area: questions-nav-section;
      padding: 1rem;
      box-shadow: 0 7px 7px rgba(0, 0, 0, 0.1);
      border-radius: 0.5rem;
    }
    
    .questions-nav-section .question-nums-list {
      /* max-width: 100%; */
      display: grid;
      grid-template-columns: repeat(5, 1fr);
      grid-auto-rows: minmax(0, 1fr);
      gap: 10px;
      list-style: none;
      padding: 0;
      margin: 0;  
    } 
    
    .questions-nav-section .question-nums-list a {
      text-decoration: none;
      color: inherit;
      padding: 0.5rem; 
      background: #cdcaca;
      border-radius: 50%;
      display: inline-block;
      width: 2.5rem; 
      height: 2.5rem;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: 700;
      color: #fff;
    } 
    .questions-nav-section .question-nums-list a:hover {
      filter: brightness(0.9) 
    }
    .questions-nav-section .question-nums-list a.done { 
      background: #28bd74;
    }
    
    .questions-nav-section .question-nums-list a.active { 
      background: #ffaaaf;
    }
    .question-count{
        max-height: 275px;
    }
    .question-count::-webkit-scrollbar{
        width: 8px;
    }
    .question-count::-webkit-scrollbar-track {
        box-shadow: inset 0 0 5px grey; 
        border-radius: 8px;
    }
    
    .question-count::-webkit-scrollbar-thumb {
        background: rgb(170, 176, 171); 
        border-radius: 10px;
    }
    .attempted{
        height: 15px;
        width: 15px;
        border-radius: 10px;
        background-color: #28bd74;
    }
    .notattempted{
        height: 15px;
        width: 15px;
        border-radius: 10px;
        background-color:#ffaaaf;
    }
    .to-reviewed-status{
        height: 15px;
        width: 15px;
        border-radius: 10px;
        background-color: rgb(117, 239, 35);
    }
    .not-viewed-status{
        height: 15px;
        width: 15px;
        border-radius: 10px;
        background-color:#cdcaca;
    }
    .question-no{
        border-radius: 50%;
        border: 1px solid rgb(50, 48, 48);
        padding: 4px 7px;
        font-weight: bold;
        color: rgb(255 255 255);
        background-color: #767070;
    }
    .question-context {
      margin-bottom: 1rem;
      display: flex;
      justify-content: space-between;
    }
    p.question-text {
        height: 100px;
        overflow: auto;
    }

    
    .question-context a { 
      font-weight: 700;
      font-size: 0.9rem;
      text-decoration: none;
      color: inherit;
    }
    
    .question-context a:hover {
      color: #aabdff;
    }
    
    .d-flex {
      display: flex;
      justify-content: center;
      width: 100%; 
    } 
     
    @media(max-width: 50rem) {
      .container {   
        grid-template-rows: 0.1fr 1fr 1fr;
        border-radius: 0;
        position: static;
        height: 100vh;
        width: 100%; 
        top: 0%;
        left: 0%;
        transform: translate(0%, 0%);  
       }
    } 
    
    @media (max-width: 38rem) {
      .container {
        position: static;
        width: 100%;
        padding: 0.8rem;
        border-radius: 0;
        top: 0%;
        left: 0%;
        transform: translate(0%, 0%);
    
        grid-template-columns: 1fr;
        grid-template-rows: 0.1fr 1fr 1fr auto;
        grid-template-areas:
          "quiz-title"
          "questions-nav-section"
          "question-section"
          "explanation-section";
      }
    }
        </style>
    <!-- Main Contents -->
    <div class="main_content">
        <div class="container">
          @if($testPaper->testPaperQuestions->count() > 0)
            <!--time and progress start-->
          <form action="{{route('student.test-paper-progress.update-bulk')}}">
            <input type="hidden" id="test_paper_id" name="test_paper_id" value="{{$testPaper->id}}">
            @php 
                if($student->started_at){
                  $examStartTime = strtotime($student->started_at);
                  // Get the current timestamp
                  $currentTimestamp = time();
                  // Calculate the elapsed time in seconds
                  $elapsedTimeSeconds = $currentTimestamp - $examStartTime;
                  // Convert the elapsed time to minutes
                  $totalDurationSeconds = $testPaper->duration * 60;
                  $remainingTimeSeconds = $totalDurationSeconds - $elapsedTimeSeconds;
                  $remainingTime = $remainingTimeSeconds;
                }else{
                    $remainingTime = $testPaper->duration * 60;
                }
            @endphp
            <input type="hidden" id="student_id" name="student_id" value="{{$student->id}}">
            <input type="hidden" id="remainingTime" name="remainingTime" value="{{$remainingTime}}">
            <div class="d-flex justify-content-between mb-3">
                <h1 class="quiz-title">{{$testPaper->title}}</h1>
                <p><span name="" class="side-icon icon-material-outline-access-time text-lg mr-1"></span class="ml-1 mr-1">Time Left:<span id="countdown"></span></p>
            </div> 
            <div class="w-full h-2.5 rounded-lg bg-gray-300 shadow-xs relative mb-4">
                <div class="w-1/3 h-full rounded-lg bg-blue-800"> </div>
            </div>
            <!--time and progress end-->
            <div class="row">
                <!--Qestion paper start-->
                <div class="col-md-8">
                  @php
                      $lastIndex = count($testPaper->testPaperQuestions) - 1;
                      $questionCount = $testPaper->testPaperQuestions; $i=0; $k=0;
                  @endphp
                    @foreach($testPaper->testPaperQuestions as $ques_key => $question)

                    {{-- <p> {{$ques_key}}</p> --}}
                      <section class="question-section d-none" id="question_answer{{$ques_key}}">
                          <div class="question">
                              <h2 class="question-num">Question {{$ques_key + 1}}</h2>
                              <p class="question-text">{{strip_tags($question->questions->question)}}</p>
                          </div>
                          <input type="hidden" name="question_id[]" value="{{$question->id}}" id="question_id{{$ques_key}}">
                          <input type="hidden" name="question_type[]" value="{{$question->questions->type}}" id="question_type{{$ques_key}}">
                          <div class="answer">
                            @php
                              $options = $question->questions->options; 
                            @endphp
                            @foreach($options as $key => $option)
                              @php 
                                  $progress = App\Models\TestPaperProgress::where('test_paper_id',$testPaper->id)->where('question_id',$question->id)->where('student_id',$student->id)->whereJsonContains('answers',$option)->first()
                              @endphp

                            @php // dd($question->questions->type); @endphp

                              @if($question->questions->type != 'multi')
                                @if($key == 0)
                                @php  $k++; @endphp
                                  <h3 class="text-muted mb-5">Select a single answer</h3>
                                @endif

                                <fieldset id="group{{$i}}">

                              <label class="single-answer answer-item @if($progress) checked @endif ">
                                <input onchange="toggleParentClass('{{$question->id}}','{{$option}}',this,{{$ques_key}})" type="radio" name="correct_answer[{{$k-1}}][]" id="correct_answer{{$ques_key}}{{$i++}}" value="{{$option}}" @if($progress) checked @endif>
                                    <span class="question-no">{{$key + 1}}</span><span class="text-muted">{{$option}}</span>
                              </label>
                            </fieldset>

                              @else
                                @if($key == 0)
                                  @php  $k++; @endphp
                                  <h3 class="text-muted mb-5">Select a multiple answer</h3>
                                @endif

                                <fieldset id="group{{$i}}">

                              <label class="multi-answer answer-item @if($progress) checked @endif ">
                                {{-- <input onchange="toggleParentClass('{{$question->id}}','{{$option}}',this,{{$ques_key}})" type="checkbox" name="correct_answer[]" id="correct_answer{{$ques_key}}" value="{{$option}}" @if($progress) checked @endif style="width: 0px;"> --}}
                                <input onchange="toggleParentClass('{{$question->id}}','{{$option}}',this,{{$ques_key}})" type="checkbox" name="correct_answer[{{$k-1}}][]" id="correct_answer{{$ques_key}}{{$i++}}" value="{{$option}}" @if($progress) checked @endif style="width: 0px;">
                                    <span class="question-no">{{$key + 1}}</span><span class="text-muted">{{$option}}</span>
                              </label>
                            </fieldset>

                              @endif
                            @endforeach
                          </div>
                          <div class="d-flex justify-content-between mt-10">
                              <div><a class="btn" onclick="getPreviousQuestion({{$ques_key - 1}})" @if($ques_key == 0) style="pointer-events: none;"  @endif><span name="" class="side-icon icon-material-outline-arrow-back mr-1"></span> Prev</a></div>
                              <div><button id="submit_test" type="submit" class="btn">Save</button></div>
                              <div><a class="btn" onclick="getNextQuestion({{$ques_key+1}},{{$ques_key}},{{$lastIndex}})" id="next_question{{$ques_key+1}}">Next<span name="" class="side-icon icon-material-outline-arrow-forward ml-1"></span></a></div>
                          </div>
                      </section>  
                    @endforeach

                </div>
                <!--question paper end-->
                <!--question status start-->
                <div class="col-md-4">
                    <section class="questions-nav-section">
                        <p class="question-context"> 
                            <span class="question-num">Question Status</span>  
                            <span class="question-help">Question <span id="reviewed">1</span> / {{count($questionCount)}}</span> 
                        </p>
                        <div class="d-flex mb-5 overflow-auto question-count">
                            <div class=""> 
                                <ul class="question-nums-list">
                                  @foreach($questionCount as $index => $que)
                                    @php 
                                        $que_progress = App\Models\TestPaperProgress::where('test_paper_id',$testPaper->id)->where('question_id',$que->id)->where('student_id',$student->id)->first()
                                    @endphp
                                    <li><a 
                                      @if($que_progress)
                                          @if($que_progress->answers == [])     
                                            class="active"
                                          @elseif($que_progress->answers) class="done"
                                          @endif
                                          @elseif($index == 0) class="" 
                                      @endif  
                                       id="question_status{{$index}}" onclick="getNextQuestion({{$index}})">{{$index+1}}</a></li>
                                  @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex mt-5">
                            <div class="d-flex">
                                <div class="attempted mt-1"></div>
                                <span class="ml-1">Attempted <span id="done_count"></span></span>
                            </div>
                            <div class="d-flex">
                                <div class="notattempted mt-1"></div>
                                <span class="ml-1">Not Attempted</span>
                            </div>
                        </div>
                        <div class="d-flex mt-5 mb-4">
                            <div class="d-flex mr-4">
                                <div class="not-viewed-status mt-1"></div>
                                <span class="ml-1">Not Viewed</span>
                            </div>
                        </div>
                    </section>  
                </div>
               
            </form>
                <!--time and progress end-->
            </div>
          @else
          <div class="text-center">
            <span >No questions Yet!</span> 
          </div>
          
          @endif
        </div>

    <!-- Main Contents -->
@endsection
<!-- End Content-->
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
   $(document).ready(function() {
      $("#question_answer0").removeClass('d-none');
  });
</script>
<script>
  function getNextQuestion(key,nextKey = null , lastIndex = null){
      test_paper_id = $('#test_paper_id').val();
      question_id= $('#question_id'+nextKey).val();
      if($('#question_type'+nextKey).val() != 'multi'){
        var answers = $('#correct_answer'+ nextKey + ':checked').val();
      }else{
        var checkboxes = document.querySelectorAll('#correct_answer'+nextKey);
        var answers = [];
        // Iterate through each checkbox and check if it is checked
        checkboxes.forEach(function(checkbox) {
          if (checkbox.checked) {
            // If checked, add the value to the answers array
            answers.push(checkbox.value);
          }
        });
      }
      if(answers != undefined){
        // $("#question_status"+question_id).addClass('done')
        $.ajax({
            url: "{{ route('student.test-paper-progress.update') }}",
            method: 'get',
            data: {question_id:question_id,answers:answers,test_paper_id:test_paper_id},
            success: function(result){
                console.log(result.data);
            }
        });
      }else{
        //  $("#question_status"+question_id).addClass('active');
      }
      if((lastIndex + 1) != key){
        $('#reviewed').text(key+1);
        $('[id^="question_answer"]').each(function() {
          $(this).addClass('d-none')
        });
        $("#question_answer"+key).removeClass('d-none');
      }
      else{
          $('#next_question'+key).addClass('d-none');
      }
      
  }
  function getPreviousQuestion(key){
      $('[id^="question_answer"]').each(function() {
        $(this).addClass('d-none')
      });
      $("#question_answer"+key).removeClass('d-none')
      $('#reviewed').text(key+1);
  }
</script>
<script>
    function toggleParentClass(question_id,answers,radio,key) {
      $("#question_status"+key).addClass('done')
      $('#done_count').text('('+$('a.done').length+')');
      $('#active_count').text('('+$('a.active').length+')');
      $('#done_count').text('('+$('a.done').length+')');
      var parent = radio.parentNode;
      // Remove 'checked' class from all answer-items
      var answerItems = document.querySelectorAll('.single-answer');
      for (var i = 0; i < answerItems.length; i++) {
        if (answerItems[i] !== parent) { 
        //  answerItems[i].classList.remove('checked');
        //  answerItems[i].querySelector('input[type="radio"]').checked = false; 
        }
      } 

      if(radio.checked) {
        parent.classList.add('checked');
      } else {
        parent.classList.remove('checked');
      }
    }
    
    function startCountdown(duration) {
      const countdownInterval = setInterval(updateCountdown, 1000);
      function updateCountdown() {
        const minutes = Math.floor(duration / 60);
        const seconds = duration % 60;
        $('#countdown').text(minutes + "m " + seconds + "s");
            if (duration <= 0) {
              clearInterval(countdownInterval);
              $('#submit_test').trigger('click');
              $('#countdown').text("Time's up!");
            }
            duration--;
        }
      }
      setTimeout(function() {
          startCountdown($('#remainingTime').val());
      },1000);
    </script>