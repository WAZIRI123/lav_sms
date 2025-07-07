<form method="post" action="{{ route('marks.selector') }}">
        @csrf
        <div class="row">
            <div class="col-md-10">
                <fieldset>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="exam_id" class="col-form-label font-weight-bold">Exam:</label>
                                <select required id="exam_id" name="exam_id" data-placeholder="Select Exam" class="form-control select">
                                    @foreach($exams as $ex)
                                        <option {{ $selected && $exam_id == $ex->id ? 'selected' : '' }} value="{{ $ex->id }}">{{ $ex->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="my_class_id" class="col-form-label font-weight-bold">Class:</label>
                                <select required onchange="getClassSubjects(this.value)" id="my_class_id" name="my_class_id" class="form-control select">
                                    <option value="">Select Class</option>
                                    @foreach($my_classes as $c)
                                        <option {{ ($selected && $my_class_id == $c->id) ? 'selected' : '' }} value="{{ $c->id }}">{{ $c->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="section_id" class="col-form-label font-weight-bold">Section:</label>
                                <select required id="section_id" name="section_id" data-placeholder="Select Class First" class="form-control select">
                                   @if($selected)
                                        @foreach($sections->where('my_class_id', $my_class_id) as $s)
                                            <option {{ $section_id == $s->id ? 'selected' : '' }} value="{{ $s->id }}">{{ $s->name }}</option>
                                        @endforeach
                                       @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="subject_id" class="col-form-label font-weight-bold">Subject: </label>
                                <select required id="subject_id" name="subject_id" onchange="getSubjectTopics(this.value)" data-placeholder="Select Class First" class="form-control select-search">
                                  @if($selected)
                                        @foreach($subjects->where('my_class_id', $my_class_id) as $s)
                                            <option {{ $subject_id == $s->id ? 'selected' : '' }} value="{{ $s->id }}">{{ $s->name }}</option>
                                        @endforeach
                                      @endif
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2 mt-1 mx-auto" >
                            <div class="text-right mt-1">
                                <button type="submit" class="btn btn-primary">Manage Marks <i class="icon-paperplane ml-2"></i></button>
                            </div>
                        </div>
                       
                    </div>

                </fieldset>
            </div>

            <div class="col-md-2">
                <div class="form-group">
                    <label for="topic_id" class="col-form-label font-weight-bold">Topic: </label>
                    <select required id="topic_id" name="topic_id" data-placeholder="Select Topic" class="form-control select">
                        @if($selected && isset($topics) && $topics->isNotEmpty())
                            @foreach($topics as $topic)
                                <option value="{{ $topic->id }}" {{ ($topic_id == $topic->id) ? 'selected' : '' }}>{{ $topic->name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>

        </div>

    </form>

    <script>
        // Store the selected topic ID from PHP
        var selectedTopicId = '{{ $topic_id ?? '' }}';

        // Function to get topics for the selected subject and class
        function getSubjectTopics(subjectId) {
            var topicSelect = $('#topic_id');
            
            if (!subjectId) {
                topicSelect.html('<option value="">Select Subject First</option>');
                return;
            }
            
            var classId = $('#my_class_id').val();
            if (!classId) {
                topicSelect.html('<option value="">Select Class First</option>');
                return;
            }
            
            var url = '{{ route('ajax.get_subject_topics', ['subject_id' => '__SUBJECT_ID__', 'class_id' => '__CLASS_ID__']) }}';
            url = url.replace('__SUBJECT_ID__', subjectId).replace('__CLASS_ID__', classId);

            // Show loading state
            topicSelect.html('<option value="">Loading topics...</option>').prop('disabled', true);

            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    var options = '<option value="">Select Topic (Optional)</option>';
                    if (data && data.length > 0) {
                        $.each(data, function(key, topic) {
                            var selected = (topic.id == selectedTopicId) ? 'selected' : '';
                            options += '<option value="' + topic.id + '" ' + selected + '>' + topic.name + '</option>';
                        });
                    } else {
                        options = '<option value="">No topics found for this subject</option>';
                    }
                    topicSelect.html(options).prop('disabled', false);
                },
                error: function(xhr) {
                    console.error('Error loading topics:', xhr);
                    topicSelect.html('<option value="">Error loading topics</option>').prop('disabled', false);
                }
            });
        }

        // Initialize on page load
        $(document).ready(function() {
            // Set up subject change handler
            $('#subject_id').on('change', function() {
                getSubjectTopics($(this).val());
            });
            
            // Set up class change handler
            $('#my_class_id').on('change', function() {
                // The getClassSubjects function will handle clearing and repopulating subjects
                // and triggering the subject change event if needed
                selectedTopicId = ''; // Clear selected topic when class changes
            });
            
            // If subject is pre-selected (e.g., form validation failed), load its topics
            var initialSubject = $('#subject_id').val();
            if (initialSubject) {
                getSubjectTopics(initialSubject);
            }
        });
    </script>
