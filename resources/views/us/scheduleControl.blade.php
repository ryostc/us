@extends('layouts.app')

@section('title', 'スケジュール管理')

@section('content')
<div class="calender">
    <div class="row mb-3">
        <h4 class="mr-2">
            <a href="?ym={{ $prev }}">&lt;&lt;</a>
            {{ $html_title }}
            <a href="?ym={{ $next }}">&gt;&gt;</a>
        </h4>
        <a class="btn-sm btn-warning" href="?ym={{ $thismonth }}">今月</a>
    </div>
    <table class="table-sm table-bordered">
        <tr>
            <th>日</th>
            <th>月</th>
            <th>火</th>
            <th>水</th>
            <th>木</th>
            <th>金</th>
            <th>土</th>
        </tr>
        @foreach ($weeks as $week)
        {!! $week !!}
        @endforeach
    </table>
</div>
@endsection