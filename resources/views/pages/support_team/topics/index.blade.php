@extends('layouts.master')

@php
use Illuminate\Support\Str;
@endphp

@section('page-title')
    @lang('Topic Management')
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">@lang('Topics')</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="text-right mb-3">
                                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#add-topic-modal">
                                    <i class="icon-plus-circle2 mr-2"></i> @lang('Add New Topic')
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>@lang('Name')</th>
                                    <th>@lang('Subject')</th>
                                    <th>@lang('Class')</th>
                                    <th>@lang('Competency')</th>
                                    <th>@lang('Action')</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topics as $key => $topic)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $topic->name }}</td>
                                        <td>{{ $topic->subject->name }}</td>
                                        <td>{{ $topic->subject->my_class->name }}</td>
                                        <td>{{ Str::limit($topic->competency, 50) }}</td>
                                        <td class="text-center">
                                            <div class="list-icons">
                                                <div class="dropdown">
                                                    <a href="#" class="list-icons-item" data-toggle="dropdown">
                                                        <i class="icon-menu9"></i>
                                                    </a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a href="#" class="dropdown-item edit-topic" data-id="{{ $topic->id }}">
                                                            <i class="icon-pencil7 mr-2"></i> @lang('Edit')
                                                        </a>
                                                        <a href="#" class="dropdown-item delete-topic" data-id="{{ $topic->id }}">
                                                            <i class="icon-trash mr-2"></i> @lang('Delete')
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Topic Modal -->
    <div id="add-topic-modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Add New Topic')</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form id="add-topic-form" action="{{ route('topics.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="class_id">@lang('Class') <span class="text-danger">*</span></label>
                            <select class="form-control select" id="class_id" name="class_id" required>
                                <option value="">@lang('Select Class')</option>
                                @foreach($my_classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="subject_id">@lang('Subject') <span class="text-danger">*</span></label>
                            <select class="form-control select" id="subject_id" name="subject_id" required>
                                <option value="">@lang('Select Subject')</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="name">@lang('Topic Name') <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="competency">@lang('Competency') <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="competency" name="competency" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn bg-primary">@lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /add topic modal -->

    <!-- Edit Topic Modal -->
    <div id="edit-topic-modal" class="modal fade" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">@lang('Edit Topic')</h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form id="edit-topic-form" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="edit_class_id">@lang('Class') <span class="text-danger">*</span></label>
                            <select class="form-control select" id="edit_class_id" name="class_id" required>
                                <option value="">@lang('Select Class')</option>
                                @foreach($my_classes as $class)
                                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit_subject_id">@lang('Subject') <span class="text-danger">*</span></label>
                            <select class="form-control select" id="edit_subject_id" name="subject_id" required>
                                <option value="">@lang('Select Subject')</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="edit_name">@lang('Topic Name') <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="edit_competency">@lang('Competency') <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_competency" name="competency" rows="3" required></textarea>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-link" data-dismiss="modal">@lang('Close')</button>
                        <button type="submit" class="btn bg-primary">@lang('Update')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- /edit topic modal -->
@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            // Load subjects based on selected class
            $('#class_id').change(function() {
                var class_id = $(this).val();
                var url = '{{ route("topics.subjects.by.class", "") }}' + '/' + class_id;
                
                if (class_id) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#subject_id').empty();
                            $('#subject_id').append('<option value="">@lang('Select Subject')</option>');
                            
                            $.each(data, function(key, value) {
                                $('#subject_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                            
                            $('#subject_id').trigger('change');
                        }
                    });
                } else {
                    $('#subject_id').empty();
                    $('#subject_id').append('<option value="">@lang('Select Subject')</option>');
                }
            });

            // Load subjects for edit modal
            $('#edit_class_id').change(function() {
                var class_id = $(this).val();
                var url = '{{ route("topics.subjects.by.class", "") }}' + '/' + class_id;
                
                if (class_id) {
                    $.ajax({
                        url: url,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#edit_subject_id').empty();
                            $('#edit_subject_id').append('<option value="">@lang('Select Subject')</option>');
                            
                            $.each(data, function(key, value) {
                                $('#edit_subject_id').append('<option value="' + value.id + '">' + value.name + '</option>');
                            });
                            
                            $('#edit_subject_id').trigger('change');
                        }
                    });
                } else {
                    $('#edit_subject_id').empty();
                    $('#edit_subject_id').append('<option value="">@lang('Select Subject')</option>');
                }
            });

            // Edit topic
            $(document).on('click', '.edit-topic', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                // Build the URL manually to avoid double slashes
                var baseUrl = '{{ route("topics.index") }}';
                if (baseUrl.endsWith('/')) {
                    baseUrl = baseUrl.slice(0, -1); // Remove trailing slash if present
                }
                var url = baseUrl + '/' + id + '/edit';
                
                console.log('Fetching topic data from:', url);
                
                $.ajax({
                    url: url,
                    type: 'GET',
                    dataType: 'json',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    },
                    success: function(data) {
                        console.log('Received topic data:', data);
                        if (data.success && data.t) {
                            var topic = data.t;
                            // Build the update URL manually to avoid double slashes
                            var updateBaseUrl = '{{ route("topics.index") }}';
                            if (updateBaseUrl.endsWith('/')) {
                                updateBaseUrl = updateBaseUrl.slice(0, -1); // Remove trailing slash if present
                            }
                            var formAction = updateBaseUrl + '/' + id;
                            
                            $('#edit-topic-form').attr('action', formAction);
                            $('#edit_class_id').val(topic.subject.my_class_id).trigger('change');
                            $('#edit_name').val(topic.name);
                            $('#edit_competency').val(topic.competency);
                            
                            // Set subject after subjects are loaded
                            setTimeout(function() {
                                $('#edit_subject_id').val(topic.subject_id).trigger('change');
                            }, 500);
                            
                            $('#edit-topic-modal').modal('show');
                        } else {
                            console.error('Invalid topic data format:', data);
                            alert('Error: Invalid topic data received from server');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error loading topic:', {
                            status: xhr.status,
                            statusText: xhr.statusText,
                            responseText: xhr.responseText,
                            error: error
                        });
                        var errorMsg = 'Error loading topic data. Please try again.\n\n' +
                                    'Status: ' + xhr.status + ' ' + xhr.statusText + '\n';
                        
                        try {
                            var response = JSON.parse(xhr.responseText);
                            if (response.message) {
                                errorMsg += 'Message: ' + response.message;
                            }
                        } catch (e) {
                            errorMsg += 'Response: ' + (xhr.responseText || 'No response');
                        }
                        
                        alert(errorMsg);
                    }
                });
            });

            // Delete topic
            $(document).on('click', '.delete-topic', function(e) {
                e.preventDefault();
                var id = $(this).data('id');
                // Build the delete URL manually to avoid double slashes
                var baseUrl = '{{ route("topics.index") }}';
                if (baseUrl.endsWith('/')) {
                    baseUrl = baseUrl.slice(0, -1); // Remove trailing slash if present
                }
                var url = baseUrl + '/' + id;
                
                if (confirm('@lang('Are you sure you want to delete this topic?')')) {
                    $.ajax({
                        url: url,
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}',
                            _method: 'DELETE'
                        },
                        success: function() {
                            window.location.reload();
                        },
                        error: function(xhr, status, error) {
                            console.error('Error deleting topic:', error);
                            alert('Error deleting topic. Please try again.');
                        }
                    });
                }
            });
        });
    </script>
@stop
