@extends('errors::minimal')

@section('title', 'Forbidden')
@section('code', '403')
@section('message', $exception->getMessage() ?: 'Forbidden')
@section('description', 'You don\'t have permission to access this page.')
