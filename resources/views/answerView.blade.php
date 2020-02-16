@extends('layouts.main')

@section('title', '閲覧画面')

@section('include')

    @include('components.includeCommon')

@section('content')

    @include('components.answerView')

    @include('components.answerUserList')

    @include('components.commentList')

    @include('components.sendComment')

@endsection

@section('footer')

    @include('components.footer')

@endsection