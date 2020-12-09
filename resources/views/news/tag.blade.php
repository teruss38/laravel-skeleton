@extends('layouts.app')

@section('title', $news->title.'_'.__('News'))
@section('keywords', $news->keywords)
@section('description', $news->description)

@section('content')

@endsection
