@extends('layouts.app')

@section('title', '生徒の検索結果')

@section('content')
<div class="text-right">
    <!-- 生徒検索へ戻る -->
    <form action={{ url("/pairstudent/searchScreen") }} method="POST">
        @csrf
        <input type="hidden" name="id" value={{ $student_id }}>
        <button type="submit" class="btn btn-info rounded mb-2">
            ペア生徒の検索へ戻る
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
        @if ($student_id != $student->id)
        <form action={{ url('/pairstudent/edit') }} method="POST">
            @csrf
            <tr>
                <!-- 生徒の名前 -->
                <td>
                    <input type="hidden" name="id" value={{ $student_id }}>
                    <input type="hidden" name="pairStudent_id" value={{ $student->id }}>
                    <button class="btn btn-link" formaction={{ url('/pairstudent/edit') }}>
                        {{$student->firstname }}{{ $student->lastname }}
                    </button>
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
        </form>
        @endif
        @empty
        <td>検索の対象がありませんでした</td>
        @endforelse
    </tbody>
</table>
@endsection