<html>
    <head>
        <title>
            @yield('title', 'weibo')-新手入门教程
        </title>
    </head>
    <body>
        @include('layouts._header')

        <div class="container">
          <div class="offset-md-1 col-md-10">
            @include('shared._messages')
            @yield('content')
            @include('layouts._footer')
          </div>
        </div>
    </body>
</html>
