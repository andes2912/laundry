@extends('layouts.frontend')
@section('title','Lacak Status')
@section('header')
  @include('frontend.header')
@endsection
@section('banner')
{{-- banner --}}
    @include('frontend.search_hasil')
{{-- End banner --}}
@endsection

@section('content')
    @include('frontend.content')
@endsection

@section('footer')
  @include('frontend.footer')

{{-- Whatsapp Button Start--}}
  <a href="https://wa.me/{{$setpage->whatsapp ?? ''}}" target="blank_">
    <img src="{{asset('frontend/img/wa.png')}}" class="wabutton" alt="WhatsApp-Button">
  </a>
{{-- End: Whatsapp Button --}}
@endsection

