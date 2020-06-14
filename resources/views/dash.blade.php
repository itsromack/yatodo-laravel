@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">MY TASKS LIST</div>

                <div class="panel-body">
                    
                    <div id="app" data-user-id="{{ $user_id }}">
                        <todo-list></todo-list>
                    </div>

                    <script src="/js/main.js"></script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
