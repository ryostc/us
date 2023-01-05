@extends('layouts.app')

@section('title', '生徒編集')

@section('content')
@include('common.errors')
<form action="/students/update" method="POST">
    @csrf
    <fieldset>
        <legend>個人情報</legend>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="firstname_label" class="col-form-label">性</label>
                <input type="text" id="firstname_label" class="form-control" name="firstname" autocomplete="off"
                    value="{{ $student->firstname }}">
            </div>

            <div class="form-group col-6">
                <label for="lastname_label" class="col-form-label">名</label>
                <input type="text" id="lastname_label" class="form-control" name="lastname" autocomplete="off"
                    value="{{ $student->lastname }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="firstname_ruby_label" class="col-form-label">性(フリガナ)</label>
                <input type="text" id="firstname_ruby_label" class="form-control" name="firstname_ruby"
                    autocomplete="off" value="{{ $student->firstname_ruby }}">
            </div>

            <div class="form-group col-6">
                <label for="lastname_ruby_label" class="col-form-label">名(フリガナ)</label>
                <input type="text" id="lastname_ruby_label" class="form-control" name="lastname_ruby" autocomplete="off"
                    value="{{ $student->lastname_ruby }}">
            </div>
        </div>

        <label for="sex_label" class="col-form-label">性別</label>
        <div class="form-row">
            <div class="form-group col-6">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="men_label" name="sex" value="男性"
                        @checked($student->sex == "男性")>
                    <label class="form-check-label" for="men_label">男性</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="women_label" name="sex" value="女性"
                        @checked($student->sex == "女性")>
                    <label class="form-check-label" for="women_label">女性</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="non-binary_label" name="sex" value="どちらでもない"
                        @checked($student->sex == "どちらでもない")>
                    <label class="form-check-label" for="non-binary_label">どちらでもない</label>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="birthdate_label" class="col-form-label">誕生日</label>
                <input type="date" id="birthdate_label" class="form-control" name="birthdate" autocomplete="off"
                    value="{{ $student->birthdate }}">
            </div>
        </div>

        @if ($student->guardian_firstname == null)
        <div class="form-row">
            <div class="form-group col-6">
                <label for="guardian_firstname_label" class="col-form-label">保護者 性</label>
                <input type="text" id="guardian_firstname_label" class="form-control" name="guardian_firstname"
                    autocomplete="off" value="{{ old('guardian_firstname') }}">
            </div>

            <div class="form-group col-6">
                <label for="guardian_lastname_label" class="col-form-label">保護者 名</label>
                <input type="text" id="guardian_lastname_label" class="form-control" name="guardian_lastname"
                    autocomplete="off" value="{{ old('guardian_lastname') }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="guardian_firstname_ruby_label" class="col-form-label">保護者 性(フリガナ)</label>
                <input type="text" id="guardian_firstname_ruby_label" class="form-control"
                    name="guardian_firstname_ruby" autocomplete="off" value="{{ old('guardian_firstname_ruby') }}">
            </div>

            <div class="form-group col-6">
                <label for="guardian_lastname_ruby_label" class="col-form-label">保護者 名(フリガナ)</label>
                <input type="text" id="guardian_lastname_ruby_label" class="form-control" name="guardian_lastname_ruby"
                    autocomplete="off" value="{{ old('guardian_lastname_ruby') }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="relationship_label" class="col-form-label">続柄</label>
                <input type="text" id="relationship_label" class="form-control" name="relationship" autocomplete="off"
                    value="{{ old('relationship') }}">
            </div>
        </div>
        @else
        <div class="form-row">
            <div class="form-group col-6">
                <label for="guardian_firstname_label" class="col-form-label">保護者 性</label>
                <input type="text" id="guardian_firstname_label" class="form-control" name="guardian_firstname"
                    autocomplete="off" value="{{ $student->guardian_firstname }}">
            </div>

            <div class="form-group col-6">
                <label for="guardian_lastname_label" class="col-form-label">保護者 名</label>
                <input type="text" id="guardian_lastname_label" class="form-control" name="guardian_lastname"
                    autocomplete="off" value="{{ $student->guardian_lastname }}">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="guardian_firstname_ruby_label" class="col-form-label">保護者 性(フリガナ)</label>
                <input type="text" id="guardian_firstname_ruby_label" class="form-control"
                    name="guardian_firstname_ruby" autocomplete="off" value="{{ $student->guardian_firstname_ruby }}">
            </div>

            <div class="form-group col-6">
                <label for="guardian_lastname_ruby_label" class="col-form-label">保護者 名(フリガナ)</label>
                <input type="text" id="guardian_lastname_ruby_label" class="form-control" name="guardian_lastname_ruby"
                    autocomplete="off" value="{{ $student->guardian_lastname_ruby }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="relationship_label" class="col-form-label">続柄</label>
                <input type="text" id="relationship_label" class="form-control" name="relationship" autocomplete="off"
                    value="{{ $student->relationship }}">
            </div>
        </div>
        @endif

        <div class="form-row">
            <div class="form-group col-6">
                <label for="comment_label" class="col-form-label">コメント</label>
                <textarea id="comment_label" class="form-control" name="comment" autocomplete="off" row="2"
                    value="{{ $student->comment }}" cols="40" rows="2">{{ $student->comment }}</textarea>
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>ステータス</legend>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="instructor_id_label" class="col-form-label">担当インストラクター</label>
                <select id="instructor_id_label" name="instructor_id" class="form-control">
                    <option value={{$personalInstructor->id }}>{{$personalInstructor->firstname }}{{
                        $personalInstructor->lastname }}</option>
                    @foreach ($instructors as $instructor)
                    @if ($instructor->id != $personalInstructor->id)
                    <option value={{ $instructor->id }}>{{$instructor->firstname }}{{ $instructor->lastname }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="terms_payment_label" class="col-form-label">支払い方法</label>
                <select id="terms_payment_label" name="terms_payment" class="form-control">
                    <option value={{ $student->terms_payment }}>{{ $student->terms_payment }}</option>
                    @if ($student->terms_payment == "口座引き落とし")
                    <option value="現金払い">現金払い</option>
                    @else
                    <option value="口座引き落とし">口座引き落とし</option>
                    @endif
                </select>
            </div>
        </div>

        {{-- value="0"が払済(false)でvalue="1"が未払い(ture) --}}
        <div class="form-row">
            <div class="form-group col-6">
                <label for="unpaid_label" class="col-form-label">未払い</label>
                <input type="hidden" name="unpaid" autocomplete="off" value="0">
                <input type="checkbox" id="unpaid_label" name="unpaid" autocomplete="off" value="1"
                    @checked($student->unpaid == "1")>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="status_label" class="col-form-label">ステータス</label>
                <select id="status_label" name="status" class="form-control">
                    <option value={{ $student->status }}>{{ $student->status }}</option>
                    @foreach ($statuses as $status)
                    @if ($student->status != $status)
                    <option value={{ $status }}>{{ $status }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="lesson_type_label" class="col-form-label">レッスンタイプ</label>
                <select id="lesson_type_label" name="lesson_type" class="form-control">
                    <option value={{ $student->lesson_type }}>{{ $student->lesson_type }}</option>
                    @foreach ($lesson_types as $lesson_type)
                    @if ($student->lesson_type != $lesson_type)
                    <option value={{ $lesson_type }}>{{ $lesson_type }}</option>
                    @endif
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="pair_id_label" class="col-form-label">ペアのid</label>
                <input type="number" id="pair_id_label" class="form-control" name="pair_id" autocomplete="off" value={{
                    $student->pair_id }}>
            </div>
            <div class="form-group col-6">
                <label for="pair_name_label" class="col-form-label">ペアの名前</label>
                @if ($student->pair_id != -1)
                <input type="text" id="pair_name_label" class="form-control" name="pair_name" value={{
                    $pair_student->firstname }}{{ $pair_student->lastname }} disabled>
                @else
                <input type="text" id="pair_name_label" class="form-control" name="pair_name" value="なし" disabled>
                @endif
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="enrollment_date_label" class="col-form-label">入校日</label>
                <input type="date" id="enrollment_date_label" class="form-control" name="enrollment_date"
                    autocomplete="off" value="{{ $student->enrollment_date }}">
            </div>

            @if ($student->expel_date == null)
            <div class="form-group col-6">
                <label for="expel_date_label" class="col-form-label">退校日</label>
                <input type="date" id="expel_date_label" class="form-control" name="expel_date" autocomplete="off"
                    value="{{ old('expel_date') }}">
            </div>
            @else
            <div class="form-group col-6">
                <label for="expel_date_label" class="col-form-label">退校日</label>
                <input type="date" id="expel_date_label" class="form-control" name="expel_date" autocomplete="off"
                    value="{{ $student->expel_date }}">
            </div>
            @endif
        </div>

        @if ($student->trial_lesson_date == null)
        <div class="form-row">
            <div class="form-group col-6">
                <label for="trial_lesson_date_label" class="col-form-label">体験レッスン実施日</label>
                <input type="date" id="trial_lesson_date_label" class="form-control" name="trial_lesson_date"
                    autocomplete="off" value="{{ old('trial_lesson_date') }}">
            </div>
        </div>
        @else
        <div class="form-row">
            <div class="form-group col-6">
                <label for="trial_lesson_date_label" class="col-form-label">体験レッスン実施日</label>
                <input type="date" id="trial_lesson_date_label" class="form-control" name="trial_lesson_date"
                    autocomplete="off" value="{{ $student->trial_lesson_date }}">
            </div>
        </div>
        @endif
    </fieldset>

    <fieldset>
        <legend>住所</legend>
        <label for="postcode_label" class="col-form-label">郵便番号</label>
        <div class="form-row">
            <div class="form-group col-6 form-inline">
                <input type="text" name="postcode" maxlength="8" class="form-control" id="postcode_label"
                    aria-describedby="postcodeHint" value="{{ $student->postcode }}">
                <button type="button" class="col-3 offset-1"
                    onclick="AjaxZip3.zip2addr('postcode','','prefectures','municipalities');">住所検索</button>
                <small id="postcodeHint">ハイフンなしで入力してください</small>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="prefectures_label" class="col-form-label">都道府県</label>
                <input type="text" id="prefectures_label" class="form-control" name="prefectures" autocomplete="off"
                    size="40" value="{{ $student->prefectures }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="municipalities_label" class="col-form-label">市区町村</label>
                <input type="text" id="municipalities_label" class="form-control" name="municipalities"
                    autocomplete="off" size="40" value="{{ $student->municipalities }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="address_building_label" class="col-form-label">番地・建物名等</label>
                @if ($student->address_building == null)
                <input type="text" id="address_building_label" class="form-control" name="address_building"
                    autocomplete="off" size="40" value="記入なし">
                @else
                <input type="text" id="address_building_label" class="form-control" name="address_building"
                    autocomplete="off" size="40" value="{{ $student->address_building }}">
                @endif
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>連絡先</legend>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="phonenumber_label" class="col-form-label">電話番号</label>
                <input type="tel" id="phonenumber_label" class="form-control" name="phonenumber" autocomplete="off"
                    size="15" maxlength="15" pattern="[\d]*" aria-describedby="phonenumberHint" value={{
                    $student->phonenumber }}>
                <small id="phonenumberHint">ハイフンなしで入力してください</small>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="email_label" class="col-form-label">メールアドレス</label>
                <input type="email" id="email_label" class="form-control" name="email" autocomplete="off"
                    title="メールアドレスは、aaa@example.com のような形式で記入してください。" value={{ $student->email }}>
            </div>
        </div>
    </fieldset>

    <div class="col-sm-offset-3 col-sm-6 mb-2">
        <button type="submit" class="btn btn-primary mr-1">
            再登録
        </button>
    </div>

    {{-- id値を送信 --}}
    <input type="hidden" name="id" value="{{ $student->id }}">
</form>

@endsection