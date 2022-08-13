@extends('layouts.app')
<?php
use Illuminate\Support\Facades\Auth;
?>
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif


                <div class="card">
                    <div class="card-header">ارسال مهمة للمستخدم</div>
                    <div class="card-body">
                        @foreach ($user_task_completed as $user_task)
                        <form method="POST" action="{{ route('tasks.send', ['user' => $user_task['user_id'],'author' => Auth::user()->name ]) }}">
                            @csrf
                            <div class="form-group">
                                    <input id="title" name="title" type="text" maxlength="255" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" autocomplete="off" />
                                    @if ($errors->has('title'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('title') }}</strong>
                                    </span>
                                    @endif
                            </div>
                            <div class="form-group">
                                <div class="row col-sm-12">

                                    <div class="input-group mb-3">
                                        <div class="input-group-prepend">
                                            <button type="submit" class="btn btn-primary">ارسال</button>
                                        </div>
                                        <input id="user_name" name="user_name" value="{{$user_task['user_name']}}" type="text" readonly maxlength="255" class="form-control{{ $errors->has('user_name') ? ' is-invalid' : '' }}" placeholder="ارسال مهمة  " />
                                        @if ($errors->has('user_name'))
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('user_name') }}</strong>
                                            </span>
                                        @endif
                                        <div class="input-group-append">
                                            <span class="input-group-text bg-danger">{{$user_task['not_completed_count']}}</span>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <br>
                            </div>

                        </form>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
