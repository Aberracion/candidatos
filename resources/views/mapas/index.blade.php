@extends('layouts.app')
@section('title', 'Mapa')
@section('content')
@include('mapas.mapa')
@include('mapas.filtros')
@include('mapas.gridview')
@endsection