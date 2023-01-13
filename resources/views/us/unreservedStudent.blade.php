@extends('layouts.app')

@section('title', '生徒のスケジュール詳細')

@section('content')
<div class="text-right">
    <a class="btn btn-info rounded" href={{ $beforeUrl }}>
        戻る
    </a>
</div>
<div class="row">
    <div class="col-2"></div>
    <div class="col-8">
        <h3>
            @if ($yearMonth != null)
            @php
            $date = date('Y年n月', strtotime($yearMonth));
            @endphp
            {{ $date }}
            @else
            年と月が選択されていません
            @endif
        </h3>
        <table class="table border">
            <tr>
                <th>名前</th>
                <th>レッスンタイプ</th>
                <th>インストラクター</th>
            </tr>
            @forelse ($students as $student)
            <tr>
                <td>
                    {{ $student->firstname }}{{ $student->lastname }}
                </td>

                <td>
                    {{ $student->lesson_type }}
                </td>

                <td>
                    @foreach ($instructors as $instructor)
                    @if ($student->instructor_id == $instructor->id)
                    {{ $instructor->firstname }}{{ $instructor->lastname }}
                    @endif
                    @endforeach
                </td>
            </tr>
            @empty
            <td colspan="3">未予約生徒は見つかりませんでした</td>
            @endforelse
        </table>
    </div>
</div>
@endsection