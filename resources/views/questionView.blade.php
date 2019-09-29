@extends('layouts.main')

@section('title', '詳細画面')

@section('include')

    @include('components.includeCommon')

@section('content')

    @include('components.questionView')

    @include('components.snsTransmission')

@endsection

@section('footer')
    copyrite 2019 MasaKu
@endsection