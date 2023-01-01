@extends('layouts.app')

@section('title', '生徒一覧')

@section('content')
@if (count($students) > 0)
<table>
    <!-- テーブルヘッダ -->
    <thead>
        <th>名前</th>
        <th>入校日</th>
        <th>&nbsp;</th>
    </thead>
    <!-- テーブル本体 -->
    <tbody>
        @foreach ($students as $student)
        <tr>
            <!-- インストラクターの名前 -->
            <td>
                <a class="btn btn-link" href="{{ url('/students/detail/' .$student->id) }}">
                    {{$student->firstname }}{{ $student->lastname }}
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection