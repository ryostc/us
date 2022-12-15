@extends('layouts.app')

@section('title', 'インストラクター編集')

@section('content')
@include('common.errors')
<form action="/instructors/update" method="POST">
    @csrf
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="firstname_label" class="col-sm-3">性</label>
            <input type="text" id="firstname_label" name="firstname" autocomplete="off"
                value="{{ $instructor->firstname }}">
        </div>

        <div class="form-group col-md-6">
            <label for="lastname_label" class="col-sm-3">名</label>
            <input type="text" id="lastname_label" name="lastname" autocomplete="off"
                value="{{ $instructor->lastname }}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-md-6">
            <label for="firstname_ruby_label" class="col-sm-3">性(フリガナ)</label>
            <input type="text" id="firstname_ruby_label" name="firstname_ruby" autocomplete="off"
                value="{{ $instructor->firstname_ruby }}">
        </div>

        <div class="form-group col-md-6">
            <label for="lastname_ruby_label" class="col-sm-3">名(フリガナ)</label>
            <input type="text" id="lastname_ruby_label" name="lastname_ruby" autocomplete="off"
                value="{{ $instructor->lastname_ruby }}">
        </div>
    </div>
    <div class="col-sm-6">
        <label for="enrollment_date_label" class="col-sm-3">入校日</label>
        <input type="date" id="enrollment_date_label" name="enrollment_date" autocomplete="off"
            value="{{ $instructor->enrollment_date }}">
    </div>
    <div class="col-sm-offset-3 col-sm-6">
        <button type="submit" class="btn btn-primary">
            再登録
        </button>
        <a class="btn btn-link pull-rigth" href="{{ url('/instructors/show') }}">
            一覧へ
        </a>
    </div>

    {{-- id値を送信 --}}
    <input type="hidden" name="id" value="{{ $instructor->id }}">

</form>
@endsection