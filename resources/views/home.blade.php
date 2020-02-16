@extends('layouts.main')

@section('title', 'ホーム画面')

@section('include')

    @include('components.includeCommon')

@section('content')

    @include('components.questionCard')

    @include('components.questionList')

@endsection

@section('footer')

    @include('components.footer')

@endsection