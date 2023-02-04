@extends('errors::custom-layout')

@section('title', siteSetting('title_503'))
@section('code', '503')
@section('message',  siteSetting('message_503'))
