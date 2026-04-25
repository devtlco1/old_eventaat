<!DOCTYPE html>
<html class="no-js" lang="en">
<head>
    <meta charset="utf-8">
    <title>API - Documentation</title>
    <meta name="description" content="">
    <meta name="author" content="ticlekiwi">

    <meta http-equiv="cleartype" content="on">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{asset("css/hightlightjs-dark.css")}}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/9.8.0/highlight.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;1,300&family=Source+Code+Pro:wght@300&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{asset("css/docstyle.css")}}" media="all">
    <script>hljs.initHighlightingOnLoad();</script>
</head>

<body>
<div class="left-menu">
    <div class="content-logo">
        <div class="logo">
{{--            <img title="platform by Emily van den Heever from the Noun Project" src="{{asset("images/logo.png")}}" height="32" />--}}
            <span>API Documentation</span>
        </div>
        <button class="burger-menu-icon" id="button-menu-mobile">
            <svg width="34" height="34" viewBox="0 0 100 100"><path class="line line1" d="M 20,29.000046 H 80.000231 C 80.000231,29.000046 94.498839,28.817352 94.532987,66.711331 94.543142,77.980673 90.966081,81.670246 85.259173,81.668997 79.552261,81.667751 75.000211,74.999942 75.000211,74.999942 L 25.000021,25.000058"></path><path class="line line2" d="M 20,50 H 80"></path><path class="line line3" d="M 20,70.999954 H 80.000231 C 80.000231,70.999954 94.498839,71.182648 94.532987,33.288669 94.543142,22.019327 90.966081,18.329754 85.259173,18.331003 79.552261,18.332249 75.000211,25.000058 75.000211,25.000058 L 25.000021,74.999942"></path></svg>
        </button>
    </div>
    <div class="mobile-menu-closer"></div>
    <div class="content-menu">
        <div class="content-infos">
            <div class="info"><b>Version:</b> 1.0.0</div>
            <div class="info"><b>Last Updated:</b> 1st Nov, 2024</div>
        </div>
        <ul>
            <li class="scroll-to-link active" data-target="content-get-started">
                <a>GET STARTED</a>
            </li>
            <li class="scroll-to-link" data-target="prepareLogin">
                <a><span style="color: blue;font-size: 14px">post</span> prepare client login </a>
            </li>

            <li class="scroll-to-link" data-target="login">
                <a><span style="color: blue;font-size: 14px">post</span> login</a>
            </li>

            <hr class="rounded" style="margin-left: 30px;margin-right: 30px">

            <li class="scroll-to-link" data-target="my_profile">
                <a><span style="color: blue;font-size: 14px">get</span> my profile</a>
            </li>

            <li class="scroll-to-link" data-target="change_my_photo">
                <a><span style="color: blue;font-size: 14px">post</span> change photo</a>
            </li>

            <li class="scroll-to-link" data-target="change_my_name">
                <a><span style="color: blue;font-size: 14px">post</span> change name</a>
            </li>

            <hr class="rounded" style="margin-left: 30px;margin-right: 30px">
            <li class="scroll-to-link">
                <a href="#">
                    Public Functions
                </a>
            </li>

            <li class="scroll-to-link" data-target="city_list">
                <a><span style="color: blue;font-size: 14px">get</span> city list</a>
            </li>

            <li class="scroll-to-link" data-target="city_rest_list">
                <a><span style="color: blue;font-size: 14px">get</span> city restaurant list</a>
            </li>

            <li class="scroll-to-link" data-target="privacy_list">
                <a><span style="color: blue;font-size: 14px">get</span> Privacy Option list</a>
            </li>

            <li class="scroll-to-link" data-target="rest_list">
                <a><span style="color: blue;font-size: 14px">get</span> Restaurant list</a>
            </li>

            <li class="scroll-to-link" data-target="event_list">
                <a><span style="color: blue;font-size: 14px">get</span> Event list</a>
            </li>

            <li class="scroll-to-link" data-target="offer_list">
                <a><span style="color: blue;font-size: 14px">get</span> Offer list</a>
            </li>

            <li class="scroll-to-link" data-target="rest_offer_list">
                <a><span style="color: blue;font-size: 14px">get</span> Restaurant Offers</a>
            </li>

            <li class="scroll-to-link" data-target="chain_offer_list">
                <a><span style="color: blue;font-size: 14px">get</span> Chain Offers</a>
            </li>

            <hr class="rounded" style="margin-left: 30px;margin-right: 30px">

            <li class="scroll-to-link">
                <a href="#">
                    Restaurant Admin Functions
                </a>
            </li>
            <li class="scroll-to-link" data-target="my_rest_list">
                <a><span style="color: blue;font-size: 14px">get</span> My Restaurants</a>
            </li>


            <li class="scroll-to-link" data-target="my_chain_rest_list">
                <a><span style="color: blue;font-size: 14px">get</span> My Chain Restaurants</a>
            </li>

            <li class="scroll-to-link" data-target="my_rest_event_list">
                <a><span style="color: blue;font-size: 14px">get</span> My Restaurants events</a>
            </li>

            <li class="scroll-to-link" data-target="my_chain_event_list">
                <a><span style="color: blue;font-size: 14px">get</span> My Chain events</a>
            </li>

            <li class="scroll-to-link" data-target="create_event">
                <a><span style="color: blue;font-size: 14px">post</span> Create An Event</a>
            </li>

            <li class="scroll-to-link" data-target="update_event">
                <a><span style="color: blue;font-size: 14px">post</span> Update An Event</a>
            </li>

            <li class="scroll-to-link" data-target="delete_event">
                <a><span style="color: blue;font-size: 14px">post</span> Delete An Event</a>
            </li>

            <li class="scroll-to-link" data-target="get_event_bookings">
                <a><span style="color: blue;font-size: 14px">post</span> Event Bookings</a>
            </li>

            <li class="scroll-to-link" data-target="get_event_pending_bookings">
                <a><span style="color: blue;font-size: 14px">post</span> Event bending Bookings</a>
            </li>


            <li class="scroll-to-link" data-target="accept_booking">
                <a><span style="color: blue;font-size: 14px">post</span> Accept Booking</a>
            </li>

            <li class="scroll-to-link" data-target="reject_booking">
                <a><span style="color: blue;font-size: 14px">post</span> Reject Booking</a>
            </li>

            <hr class="rounded" style="margin-left: 30px;margin-right: 30px">

            <li class="scroll-to-link">
                <a href="#">
                    Client Functions
                </a>
            </li>

            <li class="scroll-to-link" data-target="getAttendEvents">
                <a><span style="color: blue;font-size: 14px">get</span> Attendance Events</a>
            </li>

            <li class="scroll-to-link" data-target="create_booking">
                <a><span style="color: blue;font-size: 14px">Post</span> create booking</a>
            </li>

            <li class="scroll-to-link" data-target="update_booking">
                <a><span style="color: blue;font-size: 14px">Post</span> update booking</a>
            </li>

            <li class="scroll-to-link" data-target="delete_booking">
                <a><span style="color: blue;font-size: 14px">Post</span> delete booking</a>
            </li>

           <li class="scroll-to-link" data-target="getMyBookings">
                <a><span style="color: blue;font-size: 14px">get</span> my bookings</a>
            </li>


            {{--            <li class="scroll-to-link" data-target="set-webhook-url">--}}
{{--                <a>Set WebHook URL</a>--}}
{{--            </li>--}}
        </ul>
    </div>
</div>
<div class="content-page">
    <div class="content-code"></div>
    <div class="content">
        @include('api.content-get-started')
        @include('api.prepare_login')
        @include('api.login')
        @include('api.my_profile')
        @include('api.change_photo')
        @include('api.change_name')
        @include('api.city_list')
        @include('api.city_rest_list')
        @include('api.privacy_list')
        @include('api.rest_list')
        @include('api.event_list')
        @include('api.offer_list')
        @include('api.rest_offer_list')
        @include('api.chain_offer_list')
        @include('api.my_rest_list')
        @include('api.my_chain_rest_list')
        @include('api.my_rest_event_list')
        @include('api.my_chain_event_list')
        @include('api.create_event')
        @include('api.update_event')
        @include('api.delete_event')
        @include('api.get_event_bookings')
        @include('api.get_event_pending_bookings')
        @include('api.accept_booking')
        @include('api.reject_booking')
        @include('api.get_attend_events')
        @include('api.create_booking')
        @include('api.update_booking')
        @include('api.delete_booking')
        @include('api.my_bookings')


    </div>
    <div class="content-code"></div>
</div>
<!-- Github Corner Ribbon - to remove (Ribbon created with : http://tholman.com/github-corners/ )-->
<a href="{{ url()->previous() }}" class="github-corner" aria-label="" title="Back">
    <svg width="80" height="80" viewBox="0 0 250 250" style="z-index:99999; fill:#70B7FD; color:#fff; position: fixed; top: 0; border: 0; right: 0;" aria-hidden="true">
        <path d="M0,0 L115,115 L142,142 L250,250 L250,0 Z"></path>
        <svg class="rot" xmlns="http://www.w3.org/2000/svg" x="125" y="40" width="70" height="70" viewBox="0 0 24 24"><path d="M21 13v10h-6v-6h-6v6h-6v-10h-3l12-12 12 12h-3zm-1-5.907v-5.093h-3v2.093l3 3z" fill="currentColor" class="octo-body"/></svg>
    </svg>
</a>

<style>
    .github-corner:hover .octo-arm{
        animation:octocat-wave 560ms ease-in-out
    }
    @keyframes octocat-wave{
        0%,100%{transform:rotate(0)}20%,60%{transform:rotate(-25deg)}40%,80%{transform:rotate(10deg)}}
    @media (max-width:500px){
        .github-corner:hover
        .octo-arm{animation:none}
        .github-corner .octo-arm{animation:octocat-wave 560ms ease-in-out}
    }
    @media only screen and (max-width:680px){
        .github-corner > svg { right: auto!important; left: 0!important;}
        .github-corner > svg {transform: rotate(270deg)!important;}
        /*.rot { transform: rotate(270deg)!important;}*/
    }
</style>
<!-- END Github Corner Ribbon - to remove -->
<script src="{{asset("js/docscript.js")}}"></script>
</body>
</html>
