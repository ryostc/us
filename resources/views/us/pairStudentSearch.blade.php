@extends('layouts.app')

@section('title', 'ペア生徒検索')

@section('content')
@include('common.errors')
<form>
    @csrf
    <input type="hidden" name="student_id" value={{ $student_id }}>
    <div class="text-right">
        <div class="btn-group">
            {{-- 生徒の検索ボタン --}}
            <button formaction={{ url("/pairstudent/search") }} formmethod="POST" type="submit"
                class="btn btn-primary rounded mr-2">
                検索
            </button>

            <button type="submit" formaction={{ url('students/edit/'.$student_id) }} formmethod="GET"
                class="btn btn-info rounded mr-1">
                戻る
            </button>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-6">
            <label for="firstname_label" class="col-form-label">性</label>
            <input type="text" id="firstname_label" class="form-control" name="firstname" autocomplete="off"
                value="{{ old('firstname') }}">
        </div>

        <div class="form-group col-6">
            <label for="lastname_label" class="col-form-label">名</label>
            <input type="text" id="lastname_label" class="form-control" name="lastname" autocomplete="off"
                value="{{ old('lastname') }}">
        </div>
    </div>
    <div class="form-row">
        <div class="form-group col-6">
            <label for="firstname_ruby_label" class="col-form-label">性(フリガナ)</label>
            <input type="text" id="firstname_ruby_label" class="form-control" name="firstname_ruby" autocomplete="off"
                value="{{ old('firstname_ruby') }}">
        </div>

        <div class="form-group col-6">
            <label for="lastname_ruby_label" class="col-form-label">名(フリガナ)</label>
            <input type="text" id="lastname_ruby_label" class="form-control" name="lastname_ruby" autocomplete="off"
                value="{{ old('lastname_ruby') }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-6">
            <label for="phonenumber_label" class="col-form-label">電話番号</label>
            <input type="tel" id="phonenumber_label" class="form-control" name="phonenumber" autocomplete="off"
                size="15" maxlength="15" pattern="[\d]*" aria-describedby="phonenumberHint"
                value="{{ old('phonenumber') }}">
            <small id="phonenumberHint">ハイフンなしで入力してください</small>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-6">
            <label for="email_label" class="col-form-label">メールアドレス</label>
            <input type="email" id="email_label" class="form-control" name="email" autocomplete="off"
                title="メールアドレスは、aaa@example.com のような形式で記入してください。" value="{{ old('email') }}">
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-6">
            <label for="status_label" class="col-form-label">ステータス</label>
            <select id="status_label" name="status" class="form-control">
                <option value="">選択してください</option>
                @foreach ($statuses as $status)
                <option value={{ $status }}>{{ $status }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group col-6">
            <label for="lesson_type_label" class="col-form-label">レッスンタイプ</label>
            <select id="lesson_type_label" name="lesson_type" class="form-control">
                <option value="">選択してください</option>
                @foreach ($lesson_types as $lesson_type)
                <option value={{ $lesson_type }}>{{ $lesson_type }}</option>
                @endforeach
            </select>
        </div>
    </div>

    {{-- value="0"が払済(false)でvalue="1"が未払い(ture) --}}
    <div class="form-row">
        <div class="form-group col-6">
            <label for="unpaid_label" class="col-form-label">未払い</label>
            <input type="hidden" name="unpaid" autocomplete="off" value="0">
            <input type="checkbox" id="unpaid_label" name="unpaid" autocomplete="off" value="1">
        </div>
    </div>
</form>

@endsection