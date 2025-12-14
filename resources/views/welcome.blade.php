@extends('layouts.app')

@section('title', 'Taji Yako Properties - Find Your Dream Property in Kenya')

@push('meta')
    <!-- Primary Meta Tags -->
    <meta name="title" content="Taji Yako Properties - Find Your Dream Property in Kenya">
    <meta name="description" content="Discover prime lands, residential and commercial properties across Kenya with Taji Yako Properties. Your trusted real estate partner for secure and profitable investments.">
    <meta name="keywords" content="real estate Kenya, land for sale in Kenya, houses for sale, apartments for rent, commercial property Kenya, prime land Kenya, real estate investment Kenya">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="Taji Yako Properties - Find Your Dream Property in Kenya">
    <meta property="og:description" content="Discover prime lands, residential and commercial properties across Kenya with Taji Yako Properties. Your trusted real estate partner for secure and profitable investments.">
    <meta property="og:image" content="{{ asset('assets/img/favicon.png') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="Taji Yako Properties - Find Your Dream Property in Kenya">
    <meta property="twitter:description" content="Discover prime lands, residential and commercial properties across Kenya with Taji Yako Properties. Your trusted real estate partner for secure and profitable investments.">
    <meta property="twitter:image" content="{{ asset('assets/img/favicon.png') }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}" />
@endpush

@section('content')
    @include('homepartials.herosection')
    @include('homepartials.aboutsection')
    @include('homepartials.featuredpropertiessection')
    @include('homepartials.features')
    @include('homepartials.testimonials')
    @include('homepartials.whyus')
@endsection