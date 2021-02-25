@extends('layouts.front')

@section('content')
    <div class="container">
        <hr color="#c0c0c0">
        <div class="row">
            <div class="profiles col-md-8 mx-auto mt-3">
                @foreach($profiles as $profile)
                    <div class="profile">
                        <div class="row">
                            <div class="text col-md-6">
                                <div class="name">
                                    {{ str_limit($profile->name, 30) }}
                                </div>
                                <div class="gender">
                                    @if ($profile->gender == "man")
                                        <span class="man">男性</span>
                                    @else
                                        <span class="woman">女性</span>
                                    @endif
                                </div>
                                <div class="hobby">
                                    {{ str_limit($profile->hobby, 150) }}
                                </div>
                            </div>
                            <div class="introduction col-md-6">
                                {{ str_limit($profile->introduction, 1500) }}
                            </div>
                        </div>
                    </div>
                    <hr color="#c0c0c0">
                @endforeach
            </div>
        </div>
    </div>
@endsection