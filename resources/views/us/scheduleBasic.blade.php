@extends('layouts.schedule')

@section('title', 'スケジュール管理')

@section('content')
<h3>{{ $y }}年{{ $m }}月{{ $j }}日</h3>
<div class="schedules">
    <table class="table table-bordered">
        <tr>
            <th>時間</th>
            <th>名前</th>
            <th>実施インストラクター</th>
            <th>月謝未払い</th>
            <th>memo</th>
        </tr>
        @foreach ($lesson_times as $lesson_time)
        <tr>
            <td>{{ $lesson_time }}</td>
            @foreach ($schedules as $schedule)
            @if ($schedule->time == $lesson_time)
            @php
            $student = DB::table('students')->where('id', $schedule->student_id)->first();
            $instructor = DB::table('instructors')->where('id', $schedule->instructor_id)->first();
            @endphp
            <td>{{ $student->firstname }}{{ $student->lastname }}</td>
            <td>{{ $instructor->firstname }}{{ $instructor->lastname }}</td>
            @if ($student->unpaid == "0")
            <td><span class="checkmark"></span></td>
            @elseif($student->unpaid == "1")
            <td><span class="checkedmark"></span></td>
            @endif
            <td>{{ $schedule->memo }}</td>
            @endif
            @endforeach
        </tr>
        @endforeach
    </table>
</div>
@endsection