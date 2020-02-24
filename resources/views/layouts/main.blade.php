<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    @section('include')
        @show

</head>
<body>

@include('components.header')

<div class="uk-container">

@section('content')
    @show

</div>

@yield('footer')

</body>
</html>
