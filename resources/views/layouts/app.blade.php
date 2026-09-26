<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Azzurro Hotels Review Insights')</title>

    {{-- Favicon --}}
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    {{-- Open Graph --}}
    <meta property="og:type" content="website">
    <meta property="og:title" content="@yield('og_title', 'Azzurro Hotels Review Insights')">
    <meta property="og:description" content="@yield('og_description', 'Hotel review insights and analytics dashboard.')">
    <meta property="og:image" content="{{ asset('images/social-preview.png') }}">

    {{-- Twitter --}}
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('twitter_title', 'Azzurro Hotels Review Insights')">
    <meta name="twitter:description" content="@yield('twitter_description', 'Hotel review insights and analytics dashboard.')">
    <meta name="twitter:image" content="{{ asset('images/social-preview.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
@yield('content')
</body>
</html>
