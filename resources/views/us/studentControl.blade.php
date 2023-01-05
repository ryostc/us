@extends('layouts.app')

@section('title', '生徒管理')

@section('content')
<div class="btn-group-lg text-center">
    <a href="{{ url('/students/register') }}" class="col-4 btn btn-success rounded">新規登録</a>
    <a href="{{ url('/students/search') }}" class="col-4 btn btn-info rounded">生徒検索へ</a>
</div>
@endsection