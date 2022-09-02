@extends('layouts.admin')
@section('title', 'ニュースの編集')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>プロフィール編集</h2>
                <form action="{{ action('Admin\NewsController@update') }}" method="post" enctype="multipart/form-data">
                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2" for="name">氏名</label>
                        <div class="col-md-10">
                            <input type="name" class="form-control" name="name" value="{{ $profile_form->name }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="gender">性別</label>
                        <div class="col-md-10">
                            <input type="radio" class="form-control" name="gender" value="{{ $profile_form->name }}">
                            <textarea class="form-control" name="gender" rows="20">{{ $profile_form->body }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="hobby">趣味</label>
                        <div class="col-md-10">
                             <textarea class="form-control" name="hobby" rows="20">{{ $profile_form->body }}</textarea>
                        <div class="form-text text-info">
                                設定中: {{ $profile_form->image_path }}
                        </div>
                        <div class="form-check">
                    　 <label class="form-check-label">
                          <textarea class="form-control" name="introdacution" rows="20">{{ $profile_form->body }}</textarea>
                         </label>
                        </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection