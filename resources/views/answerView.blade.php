@extends('layouts.main')

@section('title', '閲覧画面')

@section('include')

    @include('components.includeCommon')

@section('content')

    @include('components.answerView')

    @include('components.snsTransmission')

    @include('components.answerUserList')

    @include('components.commentList')

    @include('components.sendComment')

@endsection

@section('footer')
    copyrite 2019 MasaKu
@endsection