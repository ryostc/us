@extends('layouts.app')

@section('title', '生徒のスケジュール詳細')

@section('content')
<div class="text-right">
    <a class="btn btn-info rounded" href={{ url("/schedules/edit/screen/" .$nowScheduleId) }}>
        更新画面へ戻る
    </a>
</div>
<div class="row">
    <div class="col-2"></div>
    <div class="col-8">
        <h3>{{ $student->firstname }}{{ $student->lastname }}(ID:{{ $student->id }})</h3>
        <table class="table table-bordered">
            <tr>
                <th>担当インストラクター</th>
                @if ($personalInstructor != null)
                <td>{{ $personalInstructor->firstname }}{{ $personalInstructor->lastname }}</td>
                @else
                <td>インストラクターを再登録して下さい</td>
                @endif

                <th>ステータス</th>
                <td>{{ $student->status }}</td>
            </tr>
            <tr>
                <th>レッスンタイプ</th>
                <td>{{ $student->lesson_type }}</td>
                <th>入校日</th>
                <td>
                    @if ($student->enrollment_date != null)
                    @php
                    $date = date('Y年n月j日', strtotime($student->enrollment_date));
                    @endphp
                    {{ $date }}
                    @else
                    なし
                    @endif
                </td>
            </tr>
            <tr>
                <th>住所</th>
                <td colspan="3">{{ $student->prefectures }}{{ $student->municipalities }}{{ $student->address_building
                    }}</td>
            </tr>
            <tr>
                <th>電話番号</th>
                <td colspan="3">{{ $student->phonenumber }}</td>
            </tr>
            <tr>
                <th>メールアドレス</th>
                <td colspan="3">{{ $student->email }}</td>
            </tr>
            <tr>
                <th>コメント</th>
                @if ($student->comment != null)
                <td colspan="3">{{ $student->comment }}</td>
                @else
                <td colspan="3"></td>
                @endif
            </tr>
        </table>
        <table class="table border">
            <tr>
                <th>予約日</th>
                <th>予約時間</th>
                <th>レッスンタイプ</th>
                <th>レッスン実施インストラクター</th>
            </tr>
            @forelse ($schedules as $schedule)
            <tr>
                <td>
                    @if ($schedule->date != null)
                    @php
                    $date = date('Y年n月j日', strtotime($schedule->date));
                    @endphp
                    {{ $date }}
                    @endif
                </td>

                <td>
                    {{ $schedule->time }}
                </td>

                <td>
                    {{ $schedule->lesson_type }}
                </td>

                @php
                $count = 0;
                @endphp
                @foreach ($instructors as $instructor)
                @if ($schedule->instructor_id == $instructor->id)
                @php
                $count++;
                @endphp
                <td>
                    {{ $instructor->firstname }}{{ $instructor->lastname }}
                </td>
                @endif
                @endforeach
                @if ($count == 0)
                <td>
                    インストラクターが見つかりません
                </td>
                @endif
            </tr>
            @empty
            <td>検索の対象がありませんでした</td>
            @endforelse
        </table>
    </div>
</div>
@endsection