<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <title>LaravelSPA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="{{ mix('/css/app.css') }}" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
      .bg-b{
        background: rgb(250, 250, 250)
      }
    </style>
</head>
<body>
<div id="app">
    <v-app>
      <header-component></header-component>
      <v-main class="bg-b">
        <v-container>
          <router-view></router-view>
        </v-container>
      </v-main>
    </v-app>
</div>
<script src="{{ mix('/js/app.js') }}"></script>
</body>
</html>