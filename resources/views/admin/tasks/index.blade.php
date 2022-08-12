@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card card-new-task">
                    <div class="card-header"> <strong>مهمة جديدة</strong> </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('admin.tasks.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="title"> المهمة</label>
                                <input id="title" name="title" type="text" maxlength="255" class="form-control{{ $errors->has('title') ? ' is-invalid' : '' }}" autocomplete="off" />
                                @if ($errors->has('title'))
                                    <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('title') }}</strong>
                                </span>
                                @endif

                            </div>
                            <button type="submit" class="btn btn-primary mt-3">انشاء</button>
                            {{--                            @if (Auth::user()->hasRole('admin') )--}}
                            @can('admin-access')
                                <a class="btn bg-success text-white mt-3" href="{{route('admin.tasks.sendTask')}}" >ارسال مهمة</a>

                            @endcan
                            {{--                            @endif--}}
                        </form>
                    </div>
                </div>
                <div class="card mt-4">
                    <div class="card-header "><strong>المهمات</strong></div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center" scope="col">الناشر</th>
                                <th class="text-center" scope="col">المهمة</th>
                                <th class="text-center" scope="col">تم</th>
                            </tr>
                            </thead>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td>
                                        {{ $task->author }}
                                    </td>
                                    <td>
                                        @if ($task->is_complete)
                                            <s>{{ $task->title }}</s>
                                        @else
                                            {{ $task->title }}
                                        @endif
                                    </td>
                                    <td class="text-right">
                                        @if (! $task->is_complete)
                                            <form method="POST" action="{{ route('tasks.update', $task->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="fabutton"><strong class="bg-success text-white">انجزت المهمة</strong></button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </table>
{{--                        {{ $tasks->links() }}--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


