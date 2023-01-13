@extends('layouts.app')

@section('title', 'インストラクター登録')

@section('content')
@include('common.errors')
<form action="/instructors/register" method="POST">
    @csrf
    <div class="form-row">
        <div class="form-group col-6">
            <label for="firstname_label" class="col-form-label">性</label>
            <input type="text" id="firstname_label" class="form-control" name="firstname" autocomplete="off"
                maxlength="50" value="{{ old('firstname') }}">
        </div>

        <div class="form-group col-6">
            <label for="lastname_label" class="col-form-label">名</label>
            <input type="text" id="lastname_label" class="form-control" name="lastname" autocomplete="off"
                maxlength="50" value="{{ old('lastname') }}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-6">
            <label for="firstname_ruby_label" class="col-form-label">性(フリガナ)</label>
            <input type="text" id="firstname_ruby_label" class="form-control" name="firstname_ruby" autocomplete="off"
                maxlength="50" value="{{ old('firstname_ruby') }}">
        </div>

        <div class="form-group col-6">
            <label for="lastname_ruby_label" class="col-form-label">名(フリガナ)</label>
            <input type="text" id="lastname_ruby_label" class="form-control" name="lastname_ruby" autocomplete="off"
                maxlength="50" value="{{ old('lastname_ruby') }}">
        </div>
    </div>
    <div class="form-group">
        <label for="enrollment_date_label" class="col-form-label">入校日</label>
        <input type="date" id="enrollment_date_label" class="form-control col-5" name="enrollment_date"
            autocomplete="off" value="{{ old('enrollment_date') }}">
    </div>
    <div class="col-sm-offset-3 col-6">
        <button type="submit" class="btn btn-primary">
            登録
        </button>
    </div>
</form>
@endsection