@extends('layouts.main')

@section('title', 'Index')

@section('include')

    @include('components.includeCommon')

@section('content')

    @include('components.answerView')

    @include('components.snsTransmission')

    @include('components.answerUserList')

@endsection

@section('footer')
    copyrite 2019 MasaKu
@endsection