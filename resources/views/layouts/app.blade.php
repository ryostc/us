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
    <div class="container mt-2">
        <header>
            <h1>@yield('title')</h1>
            <div class="btn-group-lg text-center m-3">
                <a href={{ url('/students/control') }} class="col-3 btn btn-outline-secondary">生徒管理</a>
                <a href={{ url('/schedules/control') }} class="col-3  btn btn-outline-secondary">スケジュール管理</a>
                <a href="http://localhost/instructors/show" class="col-3 btn btn-outline-secondary">インストラクター一覧</a>
            </div>
        </header>
        <div class="content">
            @yield('content')
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