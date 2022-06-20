<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="www.rosesolution.com">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tireshop</title>

    <link href="{{ asset('public/admin/css/all.css') }}" rel="stylesheet">
</head>
<body class="p-r-0">   
    <div id="app"></div>
    <script src="{{ asset('public/admin/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('public/admin/js/app.js') }}"></script>
    <script src="{{ asset('public/admin/js/all.js') }}"></script>
    <script type="text/javascript">
        $(document).on('click','.submenu', function(){
            $(this).parent('li').toggleClass('active');
            $(this).siblings().toggleClass('collapse');
        })
    </script>
</body>
</html>