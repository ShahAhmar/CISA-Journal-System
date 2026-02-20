@extends('layouts.app')

@section('title', $page->page_title . ' - ' . $journal->name)

@section('content')
    <style>
        {!! $page->content_css !!}
    </style>

    <div class="visual-content-container">
        {!! $page->content_html !!}
    </div>
@endsection