@extends('layouts.app')

@section('title', '生徒詳細')

@section('content')
<div class="container">
    <div class="text-right">
        <div class="btn-group">
            <!-- 生徒: 更新ボタン -->
            <form action="{{ url('students/edit/'.$student->id) }}" method="GET">
                @csrf
                <button type="submit" class="btn btn-primary mr-1">
                    編集
                </button>
            </form>

            <!-- 生徒: 削除ボタン -->
            <form action="{{ url('student/'.$student->id) }}" method="POST">
                @csrf
                @method('DELETE')

                <button type="submit" class="btn btn-danger mr-1" onClick="delete_alert(event);return false;">
                    削除
                </button>
            </form>

            <!-- 生徒の一覧表示へ戻る -->
            <a class="btn btn-info rounded" href="{{ url('/students/show') }}">
                一覧へ
            </a>
        </div>
    </div>
    <fieldset>
        <legend>個人情報</legend>
        <div class="row ml-1">
            <div class="col-6">
                <label class="lead" for="student_id">生徒ID</label>
                <p class='ml-2'>{{ $student->id }}</p>
            </div>
        </div>
        <div class="row ml-1">
            <div class="col-6">
                <label for="name" class="lead">性・名</label>
                <p class='ml-2'>{{ $student->firstname }} {{ $student->lastname }}</p>
            </div>
            <div class="col-6">
                <label for="furigana" class="lead">性・名(フリガナ)</label>
                <p class='ml-2'>{{ $student->firstname_ruby }} {{ $student->lastname_ruby }}</p>
            </div>
        </div>
        <div class="row ml-1">
            <div class="col-6">
                <label for="sex" class="lead">性別</label>
                <p class='ml-2'>{{ $student->sex }}</p>
            </div>
        </div>
        <div class="row ml-1">
            <div class="col-6">
                <label for="birthdate">誕生日</label>
                @php
                $year = substr($student->birthdate, 0, 4);
                $month = substr($student->birthdate, 5, 2);
                $date = substr($student->birthdate, 8, 2);
                echo "<p class='ml-2'> $year 年 $month 月 $date 日 </p>";
                @endphp
            </div>
        </div>
        @if ($student->guardian_firstname != null)
        <div class="row ml-1">
            <div class="col-6">
                <label for="guardian_name" class="lead">保護者 性・名</label>
                <p class='ml-2'>{{ $student->guardian_firstname }} {{ $student->guardian_lastname }}</p>
            </div>
            <div class="col-6">
                <label for="guardian_furigana" class="lead">保護者 性・名(フリガナ)</label>
                <p class='ml-2'>{{ $student->guardian_firstname_ruby }} {{ $student->guardian_lastname_ruby }}</p>
            </div>
        </div>
        <div class="row ml-1">
            <div class="col-6">
                <label for="relationship" class="lead">続柄</label>
                <p class='ml-2'>{{ $student->relationship }}</p>
            </div>
        </div>
        @endif
        <div class="row ml-1">
            <div class="col-6">
                <label for="comment" class="lead">コメント</label>
                @if ($student->comment == "コメントエリア")
                <p class='ml-2'>なし</p>
                @else
                <p class='ml-2'>{{ $student->comment }}</p>
                @endif
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>ステータス</legend>
        <div class="row ml-1">
            <div class="col-6">
                <label for="instructor" class="lead">担当インストラクター</label>
                <p class='ml-2'>{{$personalInstructor->firstname }}{{ $personalInstructor->lastname }}</p>
            </div>
        </div>

        <div class="row ml-1">
            <div class="col-6">
                <label for="terms_payment" class="lead">支払い方法</label>
                <p class='ml-2'>{{$student->terms_payment }}</p>
            </div>
        </div>

        <div class="row ml-1">
            <div class="col-6">
                <label for="unpaid" class="lead">未払い</label>
                @if ($student->unpaid == "0")
                <span class="checkmark"></span>
                @elseif($student->unpaid == "1")
                <span class="checkedmark"></span>
                @endif
            </div>
        </div>

        <div class="row ml-1">
            <div class="col-6">
                <label for="status" class="lead">ステータス</label>
                <p class='ml-2'>{{$student->status }}</p>
            </div>
        </div>

        <div class="row ml-1">
            <div class="col-6">
                <label for="lesson_type" class="lead">レッスンタイプ</label>
                <p class='ml-2'>{{$student->lesson_type }}</p>
            </div>
        </div>

        <div class="row ml-1">
            <div class="col-6">
                <label for="pair_id" class="lead">ペアのid</label>
                <p class="ml-2">{{ $student->pair_id }}</p>
            </div>
            <div class="col-6">
                <label for="pair_name" class="lead">ペアの名前</label>
                @if ($student->pair_id != -1)
                <p class='ml-2'>{{ $pair_student->firstname }}{{ $pair_student->lastname }}</p>
                @else
                <p class='ml-2'>なし</p>
                @endif
            </div>
        </div>

        <div class="row ml-1">
            <div class="col-6">
                <label for="enrollment_date" class="lead">入校日</label>
                @php
                $year = substr($student->enrollment_date, 0, 4);
                $month = substr($student->enrollment_date, 5, 2);
                $date = substr($student->enrollment_date, 8, 2);
                echo "<p class='ml-2'> $year 年 $month 月 $date 日 </p>";
                @endphp
            </div>
            @if ($student->expel_date != null)
            <div class="col-6">
                <label for="expel_date" class="lead">退校日</label>
                @php
                $year = substr($student->expel_date, 0, 4);
                $month = substr($student->expel_date, 5, 2);
                $date = substr($student->expel_date, 8, 2);
                echo "<p class='ml-2'> $year 年 $month 月 $date 日 </p>";
                @endphp
            </div>
            @endif
        </div>

        <div class="row ml-1">
            <div class="col-6">
                <label for="trial_lesson_date" class="lead">体験レッスン実施日</label>
                @if ($student->expel_date == null)
                <p class='ml-2'>体験レッスンを実施していません</p>
                @else
                @php
                $year = substr($student->trial_lesson_date, 0, 4);
                $month = substr($student->trial_lesson_date, 5, 2);
                $date = substr($student->trial_lesson_date, 8, 2);
                echo "<p class='ml-2'> $year 年 $month 月 $date 日 </p>";
                @endphp
                @endif
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>住所</legend>
        <div class="row ml-1">
            <div class="col-6">
                <label for="postcode" class="lead">郵便番号</label>
                <p class='ml-2'>{{ $student->postcode }}</p>
            </div>
        </div>
        <div class="row ml-1">
            <div class="col-6">
                <label for="prefectures" class="lead">都道府県</label>
                <p class='ml-2'>{{ $student->prefectures }}</p>
            </div>
        </div>
        <div class="row ml-1">
            <div class="col-6">
                <label for="municipalities" class="lead">市区町村</label>
                <p class='ml-2'>{{ $student->municipalities }}</p>
            </div>
        </div>
        <div class="row ml-1">
            <div class="col-6">
                <label for="address_building" class="lead">番地・建物名等</label>
                @if ($student->address_building == null)
                <p class='ml-2'>記入なし</p>
                @else
                <p class='ml-2'>{{ $student->address_building }}</p>
                @endif
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>連絡先</legend>
        <div class="row ml-1">
            <div class="col-6">
                <label for="phonenumber" class="lead">電話番号</label>
                <p class='ml-2'>{{ $student->phonenumber }}</p>
            </div>
        </div>
        <div class="row ml-1">
            <div class="col-6">
                <label for="email" class="lead">メールアドレス</label>
                <p class='ml-2'>{{ $student->email }}</p>
            </div>
        </div>
    </fieldset>
</div>
@endsection