@extends('layouts.schedule')

@section('title', 'スケジュール新規登録')

@section('content')
<form method="POST">
    @csrf
    <input type="hidden" name="student_id" value={{ $student->id }}>
    <table class="table-sm border">
        <tr>
            <td>生徒ID</td>
            <td>{{ $student->id }}</td>
        </tr>
        <tr>
            <td>名前</td>
            <td>{{ $student->firstname }}{{ $student->lastname }}</td>
        </tr>
        <tr>
            <td>フリガナ</td>
            <td>{{ $student->firstname_ruby }}{{ $student->lastname_ruby }}</td>
            <td>
                <button formaction={{ url("/schedules/studentDetail1") }} type="submit" class="btn btn-info">
                    詳細へ
                </button>
            </td>
        </tr>
        <tr>
            <td>性別</td>
            <td>{{ $student->sex }}</td>
        </tr>
        <tr>
            <td>電話番号</td>
            <td>{{ $student->phonenumber }}</td>
        </tr>
        <tr>
            <td>メールアドレス</td>
            <td>{{ $student->email }}</td>
        </tr>
        <tr>
            <td>コメント</td>
            <td>{{ $student->comment }}</td>
        </tr>
        <tr>
            <td>レッスンタイプ</td>
            <td>{{$student->lesson_type }}</td>
        </tr>
        <tr>
            <td>
                <label for="instructor_id_label" class="col-form-label">レッスン実施インストラクター</label>
            </td>
            <td>
                <select id="instructor_id_label" name="instructor_id" class="form-control">
                    @foreach ($instructors as $instructor)
                    @if ($instructor->id == $student->instructor_id)
                    <option value={{$instructor->id }} selected>{{$instructor->firstname }}{{
                        $instructor->lastname }}</option>
                    @else
                    <option value={{$instructor->id }}>{{$instructor->firstname }}{{
                        $instructor->lastname }}</option>
                    @endif
                    @endforeach
                </select>
            </td>
        </tr>
        <tr>
            <td>予約日時</td>
            <td>
                <div>
                    <input type="date" class="form-control" name="date" value={{ $date }}>
                </div>
            </td>
            <td>
                <div>
                    <select name="time" class="form-control">
                        @foreach ($lesson_times as $lesson_time)
                        @if ($time == $lesson_time)
                        <option value={{ $lesson_time }} selected>{{ $lesson_time }}</option>
                        @else
                        <option value={{ $lesson_time }}>{{ $lesson_time }}</option>
                        @endif
                        @endforeach
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td><label for="memo_label" class="col-form-label">memo</label></td>
            <td>
                <textarea id="memo_label" class="form-control" name="memo" autocomplete="off" value="{{ old('memo') }}"
                    cols="30" rows="2" maxlength="200"></textarea>
            </td>
        </tr>
    </table>

    <div class="btn-group mt-2 col-3 offset-5">
        <!-- スケジュール: 新規登録ボタン -->
        <button formaction={{ url("/schedules/register/create") }} type="submit" class="btn btn-primary rounded mr-1">
            登録
        </button>

        <!-- スケジュール新規登録画面(生徒情報なし)へ戻る -->
        @php
        $url = "/schedules/register/";
        $url .= $date;
        $url .= "/";
        $url .= $time;
        @endphp
        <a href={{ url($url) }} class="btn btn-danger rounded" onClick="delete_alert(event);return false;">
            リセット
        </a>
    </div>
</form>
@endsection