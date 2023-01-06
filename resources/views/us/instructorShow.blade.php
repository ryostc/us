@extends('layouts.app')

@section('title', 'インストラクター一覧')

@section('content')
<div class="text-right">
    <!-- インストラクターの新規登録画面へ遷移 -->
    <a href="http://localhost/instructors/register" class="col-2 btn btn-success rounded m-1 mb-2">新規登録</a>
</div>
@if (count($instructors) > 0)
<table class="table">
    <!-- テーブルヘッダ -->
    <thead>
        <th>名前</th>
        <th>入校日</th>
    </thead>
    <!-- テーブル本体 -->
    <tbody>
        @foreach ($instructors as $instructor)
        <tr>
            <!-- インストラクターの名前 -->
            <td>
                <a class="btn btn-link" href="{{ url('/instructors/detail/' .$instructor->id) }}">
                    {{$instructor->firstname }}{{ $instructor->lastname }}
                </a>
            </td>

            <!-- インストラクターの入校日 -->
            <td>
                @php
                $date = date('Y年n月d日', strtotime($instructor->enrollment_date));
                @endphp
                <p class="ml-2">{{ $date }}</p>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection