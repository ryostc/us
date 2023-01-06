@extends('layouts.app')

@section('title', 'インストラクター詳細')

@section('content')
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
    </div>
</div>
<div class="row ml-1">
    <div class="col-6">
        <label class="lead" for="id">インストラクターID</label>
        <p class='ml-2'>{{ $instructor->id }}</p>
    </div>
</div>
<div class="row ml-1">
    <div class="col-6">
        <label for="name" class="lead">性・名</label>
        <p class='ml-2'>{{ $instructor->firstname }} {{ $instructor->lastname }}</p>
    </div>
    <div class="col-6">
        <label for="furigana" class="lead">性・名(フリガナ)</label>
        <p class='ml-2'>{{ $instructor->firstname_ruby }} {{ $instructor->lastname_ruby }}</p>
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
        $date = date('Y年n月j日', strtotime($instructor->enrollment_date));
        @endphp
        <p class='ml-2'>{{ $date }}</p>
    </div>
</div>
@endsection