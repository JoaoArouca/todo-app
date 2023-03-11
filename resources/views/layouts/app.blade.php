<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title')</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <style>
            body {
                background-color: #766ad1;
            }
            .container {
                display: flex;
                justify-content: center;
            }
            .card {
                margin-top: 100px;
                border: none;
                box-shadow: 0px 4px 25px 4px rgba(255, 255, 255, 0.2);
                height: 80%;
                width: 40%
            }

            .card-header {
                background-color: #fff;
                color: #6c5ce7;
                font-weight: bold;
                font-size: 2rem;
                border: none;
                text-align: center;
            }

            .card-body {
                background-color: #fff;
                color: #6c5ce7;
                border: none;
                border-radius: 10px;
                padding: 20px;
            }

            .btn-primary {
                background-color: #6c5ce7;
                border-color: #6c5ce7;
                font-weight: bold;
                font-size: 1.1rem;
            }

            .btn-primary:hover {
                background-color: #4834d4;
                border-color: #4834d4;
            }

            .form-control {
                border-color: #6c5ce7;
                font-size: 1.1rem;
                border-radius: 10px;
            }

            .form-control:focus {
                border-color: #6c5ce7;
                box-shadow: none;
            }

            .submit-button {
                text-align: center;
            }

            .custom-link {
                text-decoration: none;
                color: #6c5ce7;
            }
        </style>
        @livewireStyles
    </head>
    <body>
        @yield('content')
        @livewireScripts

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    </body>
</html>
