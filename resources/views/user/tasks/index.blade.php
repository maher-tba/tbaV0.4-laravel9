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
                    <div class="card-header">  <strong>مهمة جديدة</strong> </div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('user.tasks.store') }}">
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

                        </form>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">  <strong>المهمات</strong></div>

                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="text-center" scope="col">الناشر</th>
                                <th class="text-center" scope="col">المهمة</th>
                                <th class="text-center" scope="col">صاحب المهمة</th>
                                <th class="text-center" scope="col"></th>
                            </tr>
                            </thead>
                            @foreach ($tasks as $task)
                                <tr>
                                    <td class="text-center" >
                                        {{ $task->author }}
                                    </td>
                                    <td class="text-center" >
                                        @if ($task->is_complete)
                                            <s>{{ $task->title }}</s>
                                        @else
                                            {{ $task->title }}
                                        @endif
                                    </td>
{{--                                    todo--}}
{{--                                    fixed performance issue extra query not needed                                  --}}
                                    <td class="text-center" >
                                        {{ $task->user->name }}
                                    </td>
                                    <td class="text-right">
                                        <div class="row float-end">
                                            <div class="col-sm-4">
                                                @if (! $task->is_complete)
                                                    <form method="POST" action="{{ route('user.tasks.update', $task->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class=" btn btn-success btn-sm text-white"><strong >انجزت</strong></button>
                                                    </form>
                                                @endif
                                            </div>
                                            @can('update',$task)
                                            <div class="col-sm-4">
                                                <form method="POST" action="{{ route('user.tasks.edit', $task->id) }}">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="submit" class=" btn btn-info btn-sm text-white"><strong >تحرير</strong></button>
                                                </form>
                                            </div>
                                            @endcan
                                            @can('delete',$task)
                                            <div class="col-sm-4">
                                                <form method="POST" action="{{ route('user.tasks.destroy', $task->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class=" btn btn-danger btn-sm text-white "><strong >حذف</strong></button>
                                                </form>
                                            </div>
                                            @endcan
                                        </div>

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


