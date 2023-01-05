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
                <?php 
                    $s1 = substr($instructor->enrollment_date, 0, 4);
                    $s2 = substr($instructor->enrollment_date, 5, 2);
                    $s3 = substr($instructor->enrollment_date, 8, 2);
                    echo "<div> $s1 年 $s2 月 $s3 日 </div>";
                ?>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection