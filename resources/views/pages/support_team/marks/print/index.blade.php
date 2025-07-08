<html>
<head>
    <title>Student Marksheet - {{ $sr->user->name }}</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/css/my_print.css') }}" />
    <style>
        @media print {
            @page {
                size: A4;
                margin: 0;
            }
            body {
                margin: 1.5cm;
                background-color: #fff0f5 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            #print {
                background-color: #fff0f5;
                min-height: 100vh;
                padding: 20px;
            }
        }
        body {
            background-color: #fff0f5;
            margin: 0;
            padding: 0;
        }
        #print {
            background-color: #fff0f5;
            min-height: 100vh;
            padding: 20px;
        }
    </style>
</head>
<body style="background-color: #fff0f5;">
<div class="container">
    <div id="print" xmlns:margin-top="http://www.w3.org/1999/xhtml">

        {{--<!-- SHEET BEGINS HERE-->--}}
@include('pages.support_team.marks.print.sheet')

        {{--Key to Grading--}}
        {{--@include('pages.support_team.marks.print.grading')--}}

        {{-- TRAITS - PSCHOMOTOR & AFFECTIVE --}}
        @include('pages.support_team.marks.print.skills')

        <div style="margin-top: 25px; clear: both;"></div>

        {{--    COMMENTS & SIGNATURE    --}}
        @include('pages.support_team.marks.print.comments')

    </div>
</div>

<script>
    window.print();
</script>
</body>

</html>
