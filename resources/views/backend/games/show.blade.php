@extends('backend.layouts.app')

@section('title', __('Games Show'))

@section('content')
    <div class="row">
        <div class="col col-md-12">
            <x-backend.card>
                <x-slot name="header">
                    <div class="clearfix">
                        <div class="float-left">
                            <div class="mt-0"><strong>@lang('Games Show')</strong></div>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="body">
                    <div class="table-responsive-md">
                        <table class="table table-striped table-hover table-sm">
                            <tr>
                                <th>@lang('ID')</th>
                                <td>{{$game->id}}</td>
                            </tr>
                            <tr>
                                <th>@lang('Title')</th>
                                <td>{{$game->title}}</td>
                            </tr>
                            <tr>
                                <th>@lang('All Scores')</th>
                                <td>{{$game->sumScores}}</td>
                            </tr>
                            <tr>
                                <th>@lang('All Duration Played')(@lang('Second'))</th>
                                <td>{{$game->durationPlayed}}</td>
                            </tr>
                            <tr>
                                <th>@lang('Description')</th>
                                <td>{{$game->description}}</td>
                            </tr>
                        </table>
                    </div>
                </x-slot>
                <x-slot name="footer">
                    <div class="row">
                        <div class="col-md-6">
                            <strong>@lang('Created At')</strong>:
                            {{verta($game->created_at)->timezone(config('app.timezone'))->format('H:i y/m/d')}}
                        </div>
                        <div class="col-md-6">
                            <strong>@lang('Updated At')</strong>:
                            {{verta($game->updated_at)->timezone(config('app.timezone'))->format('H:i y/m/d')}}
                        </div>
                    </div>
                </x-slot>
            </x-backend.card>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-6">
            <x-backend.card>
                <x-slot name="header">
                    <div class="clearfix">
                        <div class="float-left">
                            <div class="mt-0"><strong>@lang('Played Time By Day Sum')</strong></div>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="body">
                    <div id="canvas-holder">
                        <canvas id="canvas-1"></canvas>
                    </div>
                </x-slot>
            </x-backend.card>
        </div>
        <div class="col col-md-6">
            <x-backend.card>
                <x-slot name="header">
                    <div class="clearfix">
                        <div class="float-left">
                            <div class="mt-0"><strong>@lang('Played Time By Day Count')</strong></div>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="body">
                    <div id="canvas-holder">
                        <canvas id="canvas-2"></canvas>
                    </div>
                </x-slot>
            </x-backend.card>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-6">
            <x-backend.card>
                <x-slot name="header">
                    <div class="clearfix">
                        <div class="float-left">
                            <div class="mt-0"><strong>@lang('Played Duration By Day Sum')</strong></div>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="body">
                    <canvas id="canvas-3"></canvas>
                </x-slot>
            </x-backend.card>
        </div>
        <div class="col col-md-6">
            <x-backend.card>
                <x-slot name="header">
                    <div class="clearfix">
                        <div class="float-left">
                            <div class="mt-0"><strong>@lang('Played Duration By Day')</strong></div>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="body">
                    <canvas id="canvas-4"></canvas>
                </x-slot>
            </x-backend.card>
        </div>
    </div>
    <div class="row">
        <div class="col col-md-12">
            <x-backend.card>
                <x-slot name="header">
                    <div class="clearfix">
                        <div class="float-left">
                            <div class="mt-0"><strong>@lang('Leaderboard')</strong></div>
                        </div>
                    </div>
                </x-slot>

                <x-slot name="body">
                    <div class="table-responsive-md">
                        <table class="table table-striped table-hover nowrap" id="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>@lang('ID')</th>
                                <th>@lang('Nickname')</th>
                                <th>@lang('Score')</th>
                                <th>@lang('Duration')</th>
                                <th>@lang('Created At')</th>
                                <th>@lang('Details')</th>
                            </tr>
                            </thead>
                        </table>
                    </div>
                </x-slot>
            </x-backend.card>
        </div>
    </div>
@endsection

@section('add-field')
    <script>
        $(function () {
            $('#table').DataTable({
                processing: true,
                serverSide: true,
                responsive: {
                    details: {
                        type: 'column',
                        target: 0
                    }
                },
                order: [3, 'desc'],
                ajax: '{{ url('/admin/games/') }}/{{$game->id}}/leaderboard',
                columns: [
                    {
                        data: null,
                        defaultContent: '',
                        className: 'control',
                        orderable: false,
                        targets: 0,
                        searchable: false
                    },
                    {data: 'id', name: 'id'},
                    {data: 'nickname', name: 'nickname'},
                    {data: 'score', name: 'score'},
                    {data: 'duration', name: 'duration'},
                    {data: 'created_at', name: 'created_at', searchable: false},
                    {data: 'details', name: 'details', searchable: false, orderable: false},
                ],
                @include('backend.includes.dtTranslate')
            });

            Chart.defaults.font.family = 'IRANSans';
            var config1 = {
                type: 'line',
                data: {
                    labels: [
                        @foreach($playedTimeByDaySum as $v)
                            "{{key($v)}}",
                        @endforeach
                    ],
                    datasets: [
                        {
                            label: "@lang('Played Time By Day Sum')",
                            // backgroundColor : 'rgba(220, 220, 220, 0.2)',
                            backgroundColor: 'rgba(151, 187, 205, 0.2)',
                            borderColor: 'rgba(151, 187, 205, 1)',
                            pointBackgroundColor: 'rgba(151, 187, 205, 1)',
                            pointBorderColor: '#fff',
                            data:
                                [
                                    @foreach($playedTimeByDaySum as $v)
                                        {{$v[key($v)]}},
                                    @endforeach
                                ],
                            fill: true,
                            tension: 0.2
                        },
                    ],
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: "@lang('Day')"
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: "@lang('Count')"
                            },
                            suggestedMin: 0,
                        }
                    }
                },
            };
            var config3 = {
                type: 'line',
                data: {
                    labels: [
                        @foreach($playedDurationByDaySum as $v)
                            "{{key($v)}}",
                        @endforeach
                    ],
                    datasets: [
                        {
                            label: "@lang('Played Duration By Day Sum')",
                            // backgroundColor : 'rgba(220, 220, 220, 0.2)',
                            backgroundColor: 'rgba(151, 187, 205, 0.2)',
                            borderColor: 'rgba(151, 187, 205, 1)',
                            pointBackgroundColor: 'rgba(151, 187, 205, 1)',
                            pointBorderColor: '#fff',
                            data:
                                [
                                    @foreach($playedDurationByDaySum as $v)
                                        {{$v[key($v)]}},
                                    @endforeach
                                ],
                            fill: true,
                            tension: 0.2
                        },
                    ],
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: "@lang('Day')"
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: "@lang('Second')"
                            },
                            suggestedMin: 0,
                        }
                    }
                },
            };
            var config2 = {
                type: 'line',
                data: {
                    labels: [
                        @foreach($playedTimeByDayCount as $v)
                            "{{key($v)}}",
                        @endforeach
                    ],
                    datasets: [
                        {
                            label: "@lang('Played Time By Day Count')",
                            // backgroundColor : 'rgba(220, 220, 220, 0.2)',
                            backgroundColor: 'rgba(151, 187, 205, 0.2)',
                            borderColor: 'rgba(151, 187, 205, 1)',
                            pointBackgroundColor: 'rgba(151, 187, 205, 1)',
                            pointBorderColor: '#fff',
                            data:
                                [
                                    @foreach($playedTimeByDayCount as $v)
                                        {{$v[key($v)]}},
                                    @endforeach
                                ],
                        },
                    ],
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: "@lang('Days')"
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: "@lang('Count')"
                            },
                            suggestedMin: 0,
                        }
                    }
                },
            };
            var config4 = {
                type: 'line',
                data: {
                    labels: [
                        @foreach($playedDurationByDay as $v)
                            "{{key($v)}}",
                        @endforeach
                    ],
                    datasets: [
                        {
                            label: "@lang('Played Duration By Day')",
                            // backgroundColor : 'rgba(220, 220, 220, 0.2)',
                            backgroundColor: 'rgba(151, 187, 205, 0.2)',
                            borderColor: 'rgba(151, 187, 205, 1)',
                            pointBackgroundColor: 'rgba(151, 187, 205, 1)',
                            pointBorderColor: '#fff',
                            data:
                                [
                                    @foreach($playedDurationByDay as $v)
                                        {{$v[key($v)]}},
                                    @endforeach
                                ],
                        },
                    ],
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: "@lang('Day')"
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: "@lang('Second')"
                            },
                            suggestedMin: 0,
                        }
                    }
                },
            };
            var c1 = document.getElementById('canvas-1').getContext('2d');
            window.myLine = new Chart(c1, config1);
            var c2 = document.getElementById('canvas-2').getContext('2d');
            window.myLine = new Chart(c2, config2);
            var c3 = document.getElementById('canvas-3').getContext('2d');
            window.myLine = new Chart(c3, config3);
            var c4 = document.getElementById('canvas-4').getContext('2d');
            window.myLine = new Chart(c4, config4);

        });
    </script>
@endsection
