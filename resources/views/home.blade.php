@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">

                    @if(Session::has('success'))
                        <div class="alert alert-success">
                            {{ Session::get('success') }}
                        </div>
                    @endif

                    @if (Auth::user()->bookmarks)

                        <ul class="list-group">
                            @foreach (Auth::user()->bookmarks as $bookmark)
                                <li class="list-group-item d-flex justify-content-between"><div class="bookmark-data">{{ $bookmark->name }} : {{ $bookmark->description }}</div><button class="btn btn-danger" id="delete-bookmark" data-id={{ $bookmark->id }}><i class="fas fa-times"></i> Button</button></li>
                            @endforeach
                        </ul>
                        
                    @endif
                    
                    <div class="btn bnt-primary btn-lg" data-target=".modal" data-toggle="modal">

                        Add Bookmark

                    </div>

                </div>

                <div class="modal" tabindex="-1" role="dialog">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Modal title</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                {{ Form::open() }}
                                    {{ Form::bsText('name', '', ['label' => 'Name']) }}
                                    <div class="error-name"></div>
                                    {{ Form::bsUrl('url', '', ['label' => 'Url']) }}
                                    <div class="error-url"></div>
                                    {{ Form::bsTextarea('description', '', ['label' => 'Description']) }}
                                {{ Form::close() }}
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                <button type="button" class="btn btn-primary" id="button">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('jQuery')

    <script>
        $(function(){
            $('.modal').on('click', '#button', function(){
                let name = $('.modal #name').val();
                let urldata = $('.modal #url').val();
                let description = $('.modal #description').val();
                let token = "{{ Session::token() }}";
                $.ajax({
                    method: 'POST',
                    url: "{{ route('bookmark.store') }}",
                    data: {_token: token, name: name, urldata: urldata, description: description}
                }).done(function(msg){
                    if(msg['errors'])
                    {
                        $(".success-message").html('').removeClass('alert alert-success');
                        $.each(msg['errors'], function(key, data){
                            if(data['name'])
                            {
                                $(".error-name").html(data['name']).addClass('alert alert-danger');
                            }
                            else
                            {
                                $(".error-name").html('').removeClass('alert alert-danger');
                            }
                            if(data['urldata'])
                            {
                                $(".error-url").html(data['urldata']).addClass('alert alert-danger');
                            }
                            else
                            {
                                $(".error-url").html('').addClass('alert alert-danger');
                            }
                        });
                    }
                    else
                    {
                        $(".error-name").html('').removeClass('alert alert-danger');
                        $(".error-url").html('').removeClass('alert alert-danger');
                    }
                    if(msg['success'])
                    {
                        // $(".success-message").html(msg['success']).addClass('alert alert-success');
                        // $(".modal").modal('hide');
                        window.location.reload();
                        $(".error-name").html('').removeClass('alert alert-danger');
                        $(".error-url").html('').removeClass('alert alert-danger');
                    }
                    else
                    {
                        $(".success-message").html('').removeClass('alert alert-success');
                    }
                });

                
            });
        });
    </script>

@endsection
