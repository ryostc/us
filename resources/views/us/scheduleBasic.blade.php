@extends('layouts.schedule')

@section('title', 'スケジュール管理')

@section('content')
<h3>{{ $y}}年{{ $n }}月{{ $j }}日</h3>
<table class="table table-bordered">
    <tr>
        <th>時間</th>
        <th>名前</th>
        <th>インストラクター</th>
        <th>月謝未払い</th>
        <th>memo</th>
    </tr>

    @foreach ($lesson_times as $lesson_time)
    @php
    $count = 0;
    $url = "/schedules/register/";
    $url .= $date;
    $url .= "/";
    $url .= $lesson_time;
    @endphp
    @foreach ($schedules as $schedule)
    @php
    $student = DB::table('students')->where('id', $schedule->student_id)->first();
    $instructor = DB::table('instructors')->where('id', $schedule->instructor_id)->first();
    $editUrl = "/schedules/edit/screen/";
    $editUrl .= $schedule->id;
    @endphp
    @if ($schedule->time == $lesson_time && $count == 0)
    <tr>
        @php
        $count++;
        @endphp

        <td><a href={{ url($url) }}>{{ $lesson_time }}</a></td>

        <td>
            <a href={{ url($editUrl) }}>
                {{$student->firstname }}{{ $student->lastname }}
            </a>
        </td>

        @if ($instructor != null)
        <td>{{ $instructor->firstname }}{{ $instructor->lastname }}</td>
        @else
        <td>インストラクターを再登録して下さい</td>
        @endif

        @if ($student->unpaid == "0")
        <td><span class="checkmark"></span></td>
        @elseif($student->unpaid == "1")
        <td><span class="checkedmark"></span></td>
        @endif

        @if ($schedule->memo != null)
        <td>{{ $schedule->memo }}</td>
        @else
        <td></td>
        @endif

    </tr>
    @elseif($schedule->time == $lesson_time && $count != 0)
    <tr>
        <td></td>

        <td>
            <a href={{ url($editUrl) }}>
                {{$student->firstname }}{{ $student->lastname }}
            </a>
        </td>

        @if ($instructor != null)
        <td>{{ $instructor->firstname }}{{ $instructor->lastname }}</td>
        @else
        <td>インストラクターを再登録して下さい</td>
        @endif

        @if ($student->unpaid == "0")
        <td><span class="checkmark"></span></td>
        @elseif($student->unpaid == "1")
        <td><span class="checkedmark"></span></td>
        @endif

        @if ($schedule->memo != null)
        <td>{{ $schedule->memo }}</td>
        @else
        <td></td>
        @endif

    </tr>
    @endif
    @endforeach
    @if ($count == 0)
    <tr>
        <td><a href={{ url($url)}}>{{ $lesson_time }}</a></td>
    </tr>
    @endif
    @endforeach
</table>
@endsection