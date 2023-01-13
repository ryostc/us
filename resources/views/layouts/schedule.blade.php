<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- CSSの適用 --}}
    <link href="{{ asset('/css/style.css')  }}" rel="stylesheet">
    {{-- jsの適用 --}}
    <script src="{{ asset('/js/app.js') }}"></script>
    {{-- bootstrap用 --}}
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    {{-- 住所自動入力用 --}}
    <script src="https://ajaxzip3.github.io/ajaxzip3.js" charset="UTF-8"></script>
    <title>@yield('title')</title>
</head>

<body>
    <div class="container my-3">
        <header>
            <h1>@yield('title')</h1>
            <div class="btn-group-lg text-center m-3">
                <a href={{ url('/students/control') }} class="col-3 btn btn-outline-secondary">生徒管理</a>
                <a href={{ url('/schedules/control') }} class="col-3  btn btn-outline-secondary">スケジュール管理</a>
                <a href={{ url('/instructors/show') }} class="col-3 btn btn-outline-secondary">インストラクター一覧</a>
            </div>
        </header>
    </div>
    <div class="container-fluid">
        <div class="content">
            <div class="row">
                <div class="col-3 offset-1">
                    <div class="enrolledStudent mb-3">
                        <table class="table-sm table-bordered">
                            <tr>
                                <th>在籍生徒数</th>
                            </tr>
                            <tr>
                                <td class="text-center">{{ $enrolledStudentCount }}人</td>
                            </tr>
                        </table>
                    </div>

                    <div class="calender mb-3">
                        <div class="row mb-3">
                            <h4 class="mr-2">
                                <a href="?ym={{ $prev }}">&lt;&lt;</a>
                                {{ $html_title }}
                                <a href="?ym={{ $next }}">&gt;&gt;</a>
                            </h4>
                            <a class="btn-sm btn-warning" href="?ym={{ $thismonth }}">今月</a>
                        </div>
                        <table class="table-sm table-bordered">
                            <tr>
                                <th>日</th>
                                <th>月</th>
                                <th>火</th>
                                <th>水</th>
                                <th>木</th>
                                <th>金</th>
                                <th>土</th>
                            </tr>
                            @foreach ($weeks as $week)
                            {!! $week !!}
                            @endforeach
                        </table>
                    </div>

                    <div class="unreservedStudent">
                        <form action="/schedules/unreservedStudent" method="GET">
                            @csrf
                            <table class="table-sm border">
                                <tr>
                                    <th class="text-center">未予約生徒検索</th>
                                </tr>
                                <tr>
                                    <td>
                                        @php
                                        // 現在のページのURLを取得する
                                        $protocol = empty($_SERVER["HTTPS"]) ? "http://" : "https://";
                                        $url = $protocol . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"];
                                        @endphp
                                        <input type="month" name="yearMonth">
                                        <input type="hidden" name="url" value={{ $url }}>
                                        <button type="submit" class="btn btn-info">
                                            検索
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>
                    </div>
                </div>
                <div class="schedules col-8">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    {{-- bootstrap用 --}}
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
        integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"
        integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"
        integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous">
    </script>
    </div>
</body>

</html>