<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Taxinfinance') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
        <!-- Scripts -->
   
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>

        .login-left {
            background: url('https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=900&q=80');
            background-size: cover;
            background-position: center;
        }
        .login-right {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .card {
            width: 100%; 
        }
        .blink {
        animation: blinker 1.6s linear infinite;
        color: #1c87c9;
        font-size: 30px;
        font-weight: bold;
        font-family: sans-serif;
      }
      @keyframes blinker {
        50% {
          opacity: 0;
        }
      }
      .blink-one {
        animation: blinker-one 1.6s linear infinite;
      }
      @keyframes blinker-one {
        0% {
          opacity: 0;
        }
      }
      .blink-two {
        animation: blinker-two 1.6s linear infinite;
      }
      @keyframes blinker-two {
        100% {
          opacity: 0;
        }
      }
      
    .mb_show {
        display: none !important;
    }
    
    @media screen and (max-width: 768px) {
        .mb_show {
            display: block !important;
        }
    }
    
    .dsk_show {
     display: block !important;
    }
    
    @media screen and (max-width: 768px) {
        .dsk_show {
         display: none !important;
        }
    }
    li {
        color: red;
    }

    </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
         

            <div class="w-full sm:max-w-md mt-6 px-6  bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
