<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Codeline Hotel Manager</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
			<div id="admin-app"></div>
			<script src="{{ url(mix('/js/admin/app.js')) }}" type="text/javascript"></script>
    </body>
</html>
