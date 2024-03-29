@extends('layouts.app')

@section('title', 'スケジュール新規登録')

@section('content')
<div class="text-right">
    <!-- 生徒検索へ戻る -->
    <form action={{ url("/schedules/register/search") }} method="POST">
        @csrf
        <input type="hidden" name="date" value={{ $date }}>
        <input type="hidden" name="time" value={{ $time }}>
        <button type="submit" class="btn btn-info mb-2">
            生徒検索へ戻る
        </button>
    </form>
</div>
<table class="table">
    <!-- テーブルヘッダ -->
    <thead>
        <th>名前</th>
        <th>ステータス</th>
        <th>レッスンタイプ</th>
        <th>担当インストラクター</th>
    </thead>
    <!-- テーブル本体 -->
    <tbody>
        @forelse ($students as $student)
        <tr>
            <!-- 生徒の名前 -->
            <td>
                @php
                $url = "/schedules/register/createScreen/";
                $url .= $student->id;
                $url .= "/";
                $url .= $date;
                $url .= "/";
                $url .= $time;
                @endphp
                <a href={{ url($url) }}>
                    {{$student->firstname }}{{ $student->lastname }}
                </a>
            </td>

            <td>
                {{ $student->status }}
            </td>

            <td>
                {{ $student->lesson_type }}
            </td>

            @php
            $count = 0;
            @endphp
            @foreach ($instructors as $instructor)
            @if ($student->instructor_id == $instructor->id)
            @php
            $count++;
            @endphp
            <td>
                {{ $instructor->firstname }}{{ $instructor->lastname }}
            </td>
            @endif
            @endforeach
            @if ($count == 0)
            <td>
                インストラクターを再登録して下さい
            </td>
            @endif
        </tr>
        @empty
        <td>検索の対象がありませんでした</td>
        @endforelse
    </tbody>
</table>
@endsection