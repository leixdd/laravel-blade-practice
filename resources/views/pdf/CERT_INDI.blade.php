<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Print Order {{ __('EF_') . base64_encode($br->id . '_' . $br->created_at) }}</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Reatta Eats Agent</title>

    <!-- Scripts -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@5.x/css/materialdesignicons.min.css" rel="stylesheet">
    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <link rel="icon" href="https://reatta-eats-bucket.s3-ap-northeast-1.amazonaws.com/reatta_orange_logo.png">

    <style>
        @media print {
            body, html{
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">

    <div class="position-absolute right-0 left-10">
        <img src="/logo.png" style="width: 150px" />
    </div>
    <div class="row align-center justify-content-center mt-5">
        <div class="col-12 text-center">
            <h1>REPUBLIC OF THE PHILIPPINES</h1>
            <h2>MUNICIPAL OF BALIWAG</h2>
            <h2>PROVICE OF BULACAN</h2>
        </div>

        <div class="col-12 text-center mt-5">
            <h1>OFFICE OF THE BARANGAY ({{ strtoupper($br->user->details->barangay->barangay_name ?? '') }}) </h1>
        </div>

        <div class="col-12 text-center mt-5">
            <h1>CERTIFICATE OF INDIGENCY</h1>
        </div>

        <div class="col-12 text-justify mt-5">
            <h2 class="pl-5">SA KINAUUKULAN,</h2>
            <h2 class="pl-5">SA KINAUUKULAN,</h2>

            <p class="p-5">
                Aking PINATUTUNAYAN, na si <b>{{ strtoupper($br->user->details->lastname . ',' . $br->user->details->firstname . ' ' . $br->user->details->middlename) }}</b>
                na naninirahan sa nayong ito <b> {{ strtoupper($br->user->details->barangay->barangay_name ?? '') }}, Baliwag, Bulacan</b> ay nabibilang sa mahirap na mamamayan ng Barangay at
                lumalapit sa inyong butihing tanggapan para sa tulong <b>{{ strtoupper(empty(trim($answers[1])) ? __(trim($answers[0])) : __(trim($answers[1]))) }}</b>.
            </p>

            <p class="p-5">
                IPINAGKALOOB NGAYONG <b>{{ strtoupper(Carbon\Carbon::parse($br->updated_at, 'Asia/Manila')->toFormattedDateString()) }}</b> dito sa Barangay <b> {{ strtoupper($br->user->details->barangay->barangay_name ?? '') }}, Baliwag, Bulacan.
            </p>

            <p class="p-5">
                <b>{{ strtoupper($br->user->details->lastname . ',' . $br->user->details->firstname . ' ' . $br->user->details->middlename) }}</b>
                <br/>
                May Kahilingan
            </p>

            <p class="p-5 text-right">
                _____________________
                <br/>
                Punong Barangay
            </p>

            <p class="p-5 text-center">
                {!! QrCode::size(300)->encoding('UTF-8')->generate(route('requests.qr', ['qr' => ('EF_' . base64_encode($br->id . '_' . $br->created_at)) ])); !!}
            </p>
        </div>

    </div>

</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script>
    window.onload = function() {
        window.print();
    }
</script>
</body>
</html>
