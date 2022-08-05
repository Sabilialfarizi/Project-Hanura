@extends('layouts.master', ['title' => 'Basic Setting'])

@section('content')

<x-alert></x-alert>

<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <form method="POST" action="{{ route('admin.setting.store') }}" enctype="multipart/form-data">
            @csrf
            <h4 class="page-title">Basic Settings</h4>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Website Name</label>
                <div class="col-lg-9">
                    <input name="web_name" class="form-control" value="{{ $setting->web_name ?? '' }}" type="text">
                </div>
            </div>
            <div class="form-group row">
                <label class="col-lg-3 col-form-label">Logo</label>
                <div class="col-lg-7">
                    <input class="form-control" type="file" name="logo">
                    <span class="form-text text-muted">Recommended image size is 40px x 40px</span>
                </div>
                <div class="col-lg-2">
                    <div class="img-thumbnail float-right"><img src="{{ asset('/storage/' . $setting->logo) }}" alt="" width="40" height="40"></div>
                </div>
            </div>
            <div class="m-t-20 text-center">
                <button class="btn btn-primary submit-btn" type="submit">Save</button>
            </div>
        </form>
    </div>
</div>
@stop