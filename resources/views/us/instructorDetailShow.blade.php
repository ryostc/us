@extends('layouts.app')

@section('title', 'インストラクター詳細')

@section('content')
<div class="container">
    <div class="text-right">
        <div class="btn-group">
            <!-- インストラクター: 更新ボタン -->
            <form action="{{ url('instructors/edit/'.$instructor->id) }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-primary mr-1">
                    編集
                </button>
            </form>

            <!-- インストラクター: 削除ボタン -->
            <form action="{{ url('instructor/remove') }}" method="POST">
                @csrf
                {{-- id値を送信 --}}
                <input type="hidden" name="id" value={{ $instructor->id }}>

                <button type="submit" class="btn btn-danger mr-1" onClick="delete_alert(event);return false;">
                    削除
                </button>
            </form>

            <!-- インストラクターの一覧表示へ戻る -->
            <a class="btn btn-info rounded" href="{{ url('/instructors/show') }}">
                一覧へ
            </a>
        </div>
    </div>
    <div class="row ml-1">
        <div class="col-6">
            <label class="lead" for="id">インストラクターID</label>
            <p class='ml-1'>{{ $instructor->id }}</p>
        </div>
    </div>
    <div class="row ml-1">
        <div class="col-6">
            <label for="name" class="lead">性・名</label>
            <p class='ml-1'>{{ $instructor->firstname }} {{ $instructor->lastname }}</p>
        </div>
        <div class="col-6">
            <label for="furigana" class="lead">性・名(フリガナ)</label>
            <p class='ml-1'>{{ $instructor->firstname_ruby }} {{ $instructor->lastname_ruby }}</p>
        </div>
    </div>
    <div class="row ml-1">
        <div class="col-6">
            <label for="nyuukoubi" class="lead">入校日</label>
        </div>
    </div>
    <div class="row ml-1">
        <div class="col-6">
            @php
            $s1 = substr($instructor->enrollment_date, 0, 4);
            $s2 = substr($instructor->enrollment_date, 5, 2);
            $s3 = substr($instructor->enrollment_date, 8, 2);
            echo "<p class='ml-1'> $s1 年 $s2 月 $s3 日 </p>";
            @endphp
        </div>
    </div>
</div>
@endsection