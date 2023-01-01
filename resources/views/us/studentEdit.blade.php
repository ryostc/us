@extends('layouts.app')

@section('title', '生徒詳細')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-6">
            <label for="name">性・名</label>
            <p>{{ $instructor->firstname }} {{ $instructor->lastname }}</p>
        </div>
        <div class="col-6">
            <label for="furigana">性・名(フリガナ)</label>
            <p>{{ $instructor->firstname_ruby }} {{ $instructor->lastname_ruby }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <label for="nyuukoubi">入校日</label>
        </div>
    </div>
    <div class="row">
        <div class="col-6">
            <?php 
                $s1 = substr($instructor->enrollment_date, 0, 4);
                $s2 = substr($instructor->enrollment_date, 5, 2);
                $s3 = substr($instructor->enrollment_date, 8, 2);
                echo "<p> $s1 年 $s2 月 $s3 日 </p>";
            ?>
        </div>
    </div>
    <div class="btn-group">

        <!-- インストラクター: 更新ボタン -->
        <form action="{{ url('instructors/edit/'.$instructor->id) }}" method="GET">
            @csrf
            <button type="submit" class="btn btn-primary">
                編集
            </button>
        </form>

        <!-- インストラクター: 削除ボタン -->
        <form action="{{ url('instructor/'.$instructor->id) }}" method="POST">
            @csrf
            @method('DELETE')

            <button type="submit" class="btn btn-danger">
                削除
            </button>
        </form>

        <!-- インストラクターの一覧表示へ戻る -->
        <a class="btn btn-link pull-rigth" href="{{ url('/instructors/show') }}">
            一覧へ
        </a>
    </div>
</div>
@endsection