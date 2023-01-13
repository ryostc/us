@extends('layouts.schedule')

@section('title', 'スケジュール新規登録')

@section('content')
<form action={{ url("/schedules/register/search") }} method="POST">
    @csrf
    <table class="table-sm border">
        <tr>
            <td>生徒ID</td>
            <td></td>
        </tr>
        <tr>
            <td>名前</td>
            <td></td>
        </tr>
        <tr>
            <td>フリガナ</td>
            <td></td>
            <td>
                <button type="submit" class="btn btn-primary">
                    生徒検索へ
                </button>
            </td>
        </tr>
        <tr>
            <td>性別</td>
            <td></td>
        </tr>
        <tr>
            <td>電話番号</td>
            <td></td>
        </tr>
        <tr>
            <td>メールアドレス</td>
            <td></td>
        </tr>
        <tr>
            <td>コメント</td>
            <td></td>
        </tr>
        <tr>
            <td>レッスンタイプ</td>
            <td></td>
        </tr>
        <tr>
            <td>レッスン実施インストラクター</td>
            <td></td>
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
            <td>memo</td>
            <td></td>
        </tr>
    </table>
    <div class="mt-2 col-4 offset-4">
        <!-- スケジュール新規登録画面(生徒情報なし)へ戻る -->
        @php
        $url = "/schedules/basic/";
        $url .= $ym;
        $url .= "/";
        $url .= $j;
        @endphp
        <a href={{ url($url) }} class="btn btn-info rounded">
            戻る
        </a>
    </div>
</form>
@endsection