@extends('layouts.app')

@section('title', 'インストラクター一覧')

@section('content')
<a href="http://localhost/instructors/register">新規登録</a>
@if (count($instructors) > 0)
<table>
    <!-- テーブルヘッダ -->
    <thead>
        <th>名前</th>
        <th>入校日</th>
        <th>&nbsp;</th>
    </thead>
    <!-- テーブル本体 -->
    <tbody>
        @foreach ($instructors as $instructor)
        <tr>
            <!-- インストラクターの名前 -->
            <td>
                <div>{{ $instructor->firstname }}{{ $instructor->lastname }}</div>
            </td>

            <!-- インストラクターの入校日 -->
            <td>
                <?php 
                    $s1 = substr($instructor->enrollment_date, 0, 4);
                    $s2 = substr($instructor->enrollment_date, 5, 2);
                    $s3 = substr($instructor->enrollment_date, 8, 2);
                    echo "<div> $s1 年 $s2 月 $s3 日 </div>";
                ?>
            </td>

            <!-- インストラクター: 更新ボタン -->
            <td>
                <form action="{{ url('instructors/edit/'.$instructor->id) }}" method="GET">
                    @csrf
                    <button type="submit" class="btn btn-primary">
                        更新
                    </button>
                </form>
            </td>

            <!-- インストラクター: 削除ボタン -->
            <td>
                <form action="{{ url('instructor/'.$instructor->id) }}" method="POST">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        削除
                    </button>
                </form>
            </td>

        </tr>
        @endforeach
    </tbody>
</table>
@endif
@endsection