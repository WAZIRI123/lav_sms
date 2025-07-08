@extends('layouts.master')

@section('page-title')
    {{__('page.select_term')}}
@stop

@section('content')
    <div class="row">
        <div class="col-md-4 offset-md-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{__('page.select_term')}}</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('marks.term_selected', [$student_id, $year]) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label class="control-label">{{__('page.academic_year')}}</label>
                            <input type="text" class="form-control" value="{{ $year }}" disabled>
                        </div>
                        <div class="form-group">
                            <label class="control-label">{{__('page.term')}}</label>
                            <select name="term" id="term" class="form-control" required>
                                <option value="">{{__('page.select_term')}}</option>
                                @foreach($terms as $key => $term)
                                    <option value="{{ $key }}">{{ $term }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block">{{__('page.view_marks')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
