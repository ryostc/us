@extends('layouts.app')

@section('title', '生徒の検索結果')

@section('content')
<div class="text-right">
    <!-- 生徒検索へ戻る -->
    <a class="btn btn-info rounded mb-2" href={{ url('/students/search') }}>
        生徒検索へ
    </a>
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
                <a class="btn btn-link" href={{ url('/students/detail/' .$student->id) }}>
                    {{$student->firstname }}{{ $student->lastname }}
                </a>
            </td>

            <td>
                {{ $student->status }}
            </td>

            <td>
                {{ $student->lesson_type }}
            </td>

            @foreach ($instructors as $instructor)
            @if ($student->instructor_id == $instructor->id)
            <td>
                {{ $instructor->firstname }}{{ $instructor->lastname }}
            </td>
            @endif
            @endforeach
        </tr>
        @empty
        <td>検索の対象がありませんでした</td>
        @endforelse
    </tbody>
</table>
@endsection