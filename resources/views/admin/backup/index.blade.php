@extends('admin.layouts.master-soyuz')
@section('title',__('All Backup Manager'))
@section('body')
@component('admin.component.breadcumb',['secondaryactive' => 'active'])
@slot('heading')
{{ __('All Backup Manager') }}
@endslot

@slot('menu1')
{{ __('Backup Manager') }}
@endslot


@endcomponent
<div class="contentbar">
    <div class="row">
       
        <div class="col-lg-12">
            @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                @foreach($errors->all() as $error)
                <p>{{ $error}}<button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button></p>
                @endforeach
            </div>
            @endif
            <div class="card m-b-30">
                <div class="card-header">
                    <h5 class="box-title">{{ __('Backup Manager') }}</h5>
                </div>
                <div class="card-body ml-2">
                    <form action="{{ route('dump.path.update') }}" method="POST">
                        @csrf

                        <div class="col-md-12">
                            <label for="">{{ __('MySQL Dump Path') }}:</label>
                            <div class="input-group">
                                <input name="SQL_DUMP_PATH" required type="text" class="form-control"
                                    placeholder="{{ __("MY SQL DUMP PATH") }}" value="{{ env('SQL_DUMP_PATH') }}"
                                    aria-describedby="basic-addon2">
                                <span class="input-group-addon" id="basic-addon2">
                                    <button type="submit" class="btn btn-lg btn-primary-rgba">{{ __("Save") }}!</button>
                                </span>

                            </div>
                            
                            <div class="mt-3 alert alert-info">
                                <small class="text-info"><i class="fa fa-info-circle"></i> {{__("Important Note")}}:

                                    <br>
    
                                    • {{__("Usually in all hosting dump path for MYSQL is")}} <b>/usr/bin/</b>
                                    <br>
                                    • {{__("If that path not work than contact your hosting provider with subject")}} <b>"{{ __("What is my MYSQL DUMP Binary path ?") }}"</b>
                                    <br>
                                    • {{__('Enter the path without')}} <b>mysqldump</b> {{ __("in path") }}"</b>
    
    
    
                                </small>
                            </div>

                            <hr>
                        </div>

                    </form>
                    <div class="card-body ml-1 mr-1">
                        <div class="row">
                            <div class="col-md-8 p-2 mb-2 bg-success text-white rounded">
                                <i class="fa fa-info-circle"></i> {{__("Note") }}:
                                <ul>
                                    <li>
                                        {{ __('It will generate only database backup of your site.') }}
                                    </li>

                                    <li>
                                        <b>{{ __('Download URL is valid only for 1 (minute).') }}</b>
                                    </li>

                                    <li>
                                        {{__("Make sure")}} <b>{{__("mysql dump is enabled on your server</b> for database backup and before run this or run only database backup command make sure you save the")}} {{ __('MySQL Dump Path') }} {{__("in")}} <b>{{ __('config/database.php') }}</b>.
                                    </li>
                                </ul>
                            </div>

                            <div class="col-md-4">
                                <br>
                                <a @if(env('SQL_DUMP_PATH') !='' ) href="{{ url('admin/backups/process?type=onlydb') }}"
                                    @else href="#" disabled @endif class="btn btn-md btn-primary-rgba">
                                    <i class="fa fa-refresh"></i> {{ __('Generate database backup') }}
                                </a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="text-center col-md-8">
                                {!! $html !!}
                            </div>
    
                            <div class="col-md-4">
                                <div class="card border">
                                    
                                    <div class="card-body">
                                        <p class="text-muted"> <b>{{ __("Download the latest backup") }}</b> </p>
    
                                            @php
                                                $dir17 = storage_path() . '/app/'.config('app.name');
                                            @endphp
            
                                            <ul>
            
                                                @foreach (array_reverse(glob("$dir17/*")) as $key => $file)
            
                                                    @if(pathinfo($file, PATHINFO_EXTENSION) == 'zip')
                                                        @if($loop->first)
                                                            <li>
                                                                <a href="{{ URL::temporarySignedRoute('admin.backup.download', now()->addMinutes(1), ['filename' => basename($file)]) }}"><b>{{ basename($file)  }}({{__("Latest")}})</b>
                                                                </a>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <a href="{{ URL::temporarySignedRoute('admin.backup.download', now()->addMinutes(1), ['filename' => basename($file)]) }}">{{ basename($file)  }}</a>
                                                            </li>
                                                        @endif
                                                    @endif
            
                                                @endforeach
            
                                            </ul>
                                    </div>
    
                                </div>
                            </div>
    
                        </div>
                        

                    </div>
                    

                </div>
            </div>
        </div>
    </div>

    @endsection