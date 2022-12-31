@extends('layouts.app')

@section('title', '生徒登録')

@section('content')
@include('common.errors')
<form action="/students/register" method="POST">
    @csrf
    <fieldset>
        <legend>個人情報</legend>
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
                <input type="text" id="firstname_ruby_label" class="form-control" name="firstname_ruby"
                    autocomplete="off" value="{{ old('firstname_ruby') }}">
            </div>

            <div class="form-group col-6">
                <label for="lastname_ruby_label" class="col-form-label">名(フリガナ)</label>
                <input type="text" id="lastname_ruby_label" class="form-control" name="lastname_ruby" autocomplete="off"
                    value="{{ old('lastname_ruby') }}">
            </div>
        </div>

        <label for="sex_label" class="col-form-label">性別</label>
        <div class="form-row">
            <div class="form-group col-6">
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="men_label" name="sex" value="男性">
                    <label class="form-check-label" for="men_label">男性</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="women_label" name="sex" value="女性">
                    <label class="form-check-label" for="women_label">女性</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" id="non-binary_label" name="sex" value="どちらでもない">
                    <label class="form-check-label" for="non-binary_label">どちらでもない</label>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="birthdate_label" class="col-form-label">誕生日</label>
                <input type="date" id="birthdate_label" class="form-control" name="birthdate" autocomplete="off"
                    value="{{ old('birthdate') }}">
            </div>
        </div>

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

        <div class="form-row">
            <div class="form-group col-6">
                <label for="comment_label" class="col-form-label">コメント</label>
                <textarea id="comment_label" class="form-control" name="comment" autocomplete="off" row="2"
                    value="{{ old('comment') }}" cols="40" rows="2">コメントエリア</textarea>
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>ステータス</legend>
        <div class="form-row">
            <div class="form-group col-6">
                <label for="instructor_id_label" class="col-form-label">担当インストラクター</label>
                <select id="instructor_id_label" name="instructor_id" class="form-control">
                    <option value="">選択してください</option>
                    @foreach ($instructors as $instructor)
                    <option value={{ $instructor->id }}>{{$instructor->firstname }}{{ $instructor->lastname }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="terms_payment_label" class="col-form-label">支払い方法</label>
                <select id="terms_payment_label" name="terms_payment" class="form-control">
                    <option value="">選択してください</option>
                    <option value="口座引き落とし">口座引き落とし</option>
                    <option value="現金払い">現金払い</option>
                </select>
            </div>
        </div>

        {{-- value="0"が払済(false)でvalue="1"が未払い(ture) --}}
        <div class="form-row">
            <div class="form-group col-6">
                <label for="unpaid_label" class="col-form-label">未払い</label>
                <input type="hidden" id="unpaid_label" name="unpaid" autocomplete="off" value="0">
                <input type="checkbox" id="unpaid_label" name="unpaid" autocomplete="off" value="1">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="status_label" class="col-form-label">ステータス</label>
                <select id="status_label" name="status" class="form-control">
                    <option value="">選択してください</option>
                    <option value="入校">入校</option>
                    <option value="体験">体験</option>
                    <option value="体験追っかけ">体験追っかけ</option>
                    <option value="体験非入校">体験非入校</option>
                    <option value="退校">退校</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="lesson_type_label" class="col-form-label">レッスンタイプ</label>
                <select id="lesson_type_label" name="lesson_type" class="form-control">
                    <option value="">選択してください</option>
                    <option value="個人レッスン月2回">個人レッスン月2回</option>
                    <option value="個人レッスン月3回">個人レッスン月3回</option>
                    <option value="個人レッスン月4回">個人レッスン月4回</option>
                    <option value="ペアレッスン月2回">ペアレッスン月2回</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="pair_id_label" class="col-form-label">ペアのid</label>
                <input type="number" id="pair_id_label" class="form-control" name="pair_id" autocomplete="off" value=-1>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="enrollment_date_label" class="col-form-label">入校日</label>
                <input type="date" id="enrollment_date_label" class="form-control" name="enrollment_date"
                    autocomplete="off" value="{{ old('enrollment_date') }}">
            </div>

            <div class="form-group col-6">
                <label for="expel_date_label" class="col-form-label">退校日</label>
                <input type="date" id="expel_date_label" class="form-control" name="expel_date" autocomplete="off"
                    value="{{ old('expel_date') }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="trial_lesson_date_label" class="col-form-label">体験レッスン実施日</label>
                <input type="date" id="trial_lesson_date_label" class="form-control" name="trial_lesson_date"
                    autocomplete="off" value="{{ old('trial_lesson_date') }}">
            </div>
        </div>

    </fieldset>

    <fieldset>
        <legend>住所</legend>
        <label for="postcode_label" class="col-form-label">郵便番号</label>
        <div class="form-row">
            <div class="form-group col-6 form-inline">
                <input type="text" name="postcode" maxlength="8" class="form-control" id="postcode_label"
                    placeholder="1030013" aria-describedby="postcodeHint" value="{{ old('postcode') }}">
                <button type="button" class="col-3 offset-1"
                    onclick="AjaxZip3.zip2addr('postcode','','prefectures','municipalities');">住所検索</button>
                <small id="postcodeHint">ハイフンなしで入力してください</small>
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="prefectures_label" class="col-form-label">都道府県</label>
                <input type="text" id="prefectures_label" class="form-control" name="prefectures" autocomplete="off"
                    size="40" value="{{ old('prefectures') }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="municipalities_label" class="col-form-label">市区町村</label>
                <input type="text" id="municipalities_label" class="form-control" name="municipalities"
                    autocomplete="off" size="40" value="{{ old('municipalities') }}">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-6">
                <label for="address_building_label" class="col-form-label">番地・建物名等</label>
                <input type="text" id="address_building_label" class="form-control" name="address_building"
                    autocomplete="off" size="40" value="{{ old('address_building') }}">
            </div>
        </div>
    </fieldset>

    <fieldset>
        <legend>連絡先</legend>
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
    </fieldset>

    <div class="col-sm-offset-3 col-6">
        <button type="submit" class="btn btn-primary">
            登録
        </button>
    </div>
</form>

@endsection