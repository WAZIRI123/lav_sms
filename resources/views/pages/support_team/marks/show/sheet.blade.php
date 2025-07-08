@php
    // Get school information from settings
    $schoolName = Qs::getSetting('school_name') ?? 'HOPE INTEGRATED SECONDARY SCHOOL';
    $schoolMotto = Qs::getSetting('school_motto') ?? 'Building Hope, Inspiring Lives & Academic Excellence';
    $schoolAddress = Qs::getSetting('school_address') ?? 'P.O BOX 1226, LWENGO DISTRICT';
    $schoolPhone = Qs::getSetting('school_phone') ?? 'TEL: 0703-145230/0755-759106';
    $currentYear = Qs::getSetting('current_session') ?? date('Y');
    $currentTerm = Qs::getSetting('current_term') ?? 1;
    
    // Get exam information
    $exam = $exams->first();
    $examName = $exam->name ?? '';
    $examYear = $exam->year ?? $currentYear;
    $examTerm = $exam->term ?? $currentTerm;
    
    // Get student information
    $studentName = $sr->user->name ?? '';
    $studentId = $sr->id ?? '';
    $studentGender = $sr->user->gender ?? '';
    $className = $my_class->name ?? '';
    $sectionName = $my_class->section->first()->name ?? '';
    $classFullName = trim("$className $sectionName");
    
    // Get school logo path
    $schoolLogo = Qs::getSetting('school_logo') ? asset('storage/' . Qs::getSetting('school_logo')) : asset('global_assets/images/placeholders/placeholder.jpg');
    
    // Get student photo
    $studentPhoto = $sr->user->photo ? asset('storage/' . $sr->user->photo) : asset('global_assets/images/placeholders/placeholder.jpg');
@endphp

<div class="marksheet-container" style="font-family: Arial, sans-serif; max-width: 1000px; margin: 0 auto; padding: 20px; border: 1px solid #ddd;">
    <!-- School Header -->
    <div class="school-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; border-bottom: 2px solid #000; padding-bottom: 15px;">
        <div class="school-logo" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; overflow: hidden;">
            <img src="{{ $s['logo'] }}" alt="School Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
        </div>
        <div class="school-info" style="text-align: center; flex-grow: 1;">
            <h2 style="margin: 0; font-size: 20px; font-weight: bold;">{{ strtoupper($schoolName) }}</h2>
            <p style="margin: 5px 0; font-style: italic;">{{ $schoolMotto }}</p>
            <p style="margin: 5px 0; font-size: 12px;">{{ $schoolAddress }}, {{ $schoolPhone }}</p>
        </div>
        <div class="student-photo" style="width: 80px; height: 100px; display: flex; align-items: center; justify-content: center; overflow: hidden; border: 1px solid #ddd;">
            <img src="{{ $studentPhoto }}" alt="Student Photo" style="max-width: 100%; max-height: 100%; object-fit: cover;">
        </div>
    </div>

    <!-- Document Title -->
    <div class="document-title" style="text-align: center; margin: 15px 0 20px;">
        <h3 style="margin: 0; font-size: 18px; text-decoration: underline;">LEARNER'S {{ strtoupper($examName) }} ASSESSMENT SCORES, {{ $examYear }}</h3>
    </div>

    <!-- Student Information -->
    <div class="student-info" style="margin-bottom: 20px; border: 1px solid #ddd; padding: 10px; background-color: #f9f9f9;">
        <div style="display: flex; margin-bottom: 5px;">
            <div style="width: 50%;"><strong>NAME:</strong> {{ strtoupper($studentName) }}</div>
            <div><strong>STUDENT ID:</strong> {{ $studentId }}</div>
        </div>
        <div style="display: flex; margin-bottom: 5px;">
            <div style="width: 50%;"><strong>YEAR:</strong> {{ $examYear }}</div>
            <div><strong>SEX:</strong> {{ strtoupper($studentGender) }}</div>
        </div>
        <div style="display: flex; margin-bottom: 5px;">
            <div style="width: 50%;"><strong>CLASS:</strong> {{ $classFullName }}</div>
            <div><strong>TERM:</strong> {{ $examTerm }}</div>
        </div>
        <div style="display: flex;">
            <div style="width: 50%;"><strong>EXAM:</strong> {{ $examName }}</div>
            <div><strong>DATE:</strong> {{ date('d/m/Y') }}</div>
        </div>
    </div>

    <!-- Marks Table -->
    <table class="marks-table" style="width: 100%; border-collapse: collapse; margin-bottom: 20px;">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th style="border: 1px solid #000; padding: 8px; text-align: left;">SUBJECTS</th>
                <th style="border: 1px solid #000; padding: 8px; text-align: left;">CHAPTER</th>
                <th style="border: 1px solid #000; padding: 8px; text-align: left;">COMPETENCY</th>
                <th style="border: 1px solid #000; padding: 8px; text-align: center;">A.O.I SCORE</th>
                <th style="border: 1px solid #000; padding: 8px; text-align: center;">RAW MARKS X/20</th>
                <th style="border: 1px solid #000; padding: 8px; text-align: center;">EXAM X/80</th>
                <th style="border: 1px solid #000; padding: 8px; text-align: center;">TOTAL 100%</th>
                <th style="border: 1px solid #000; padding: 8px; text-align: center;">GRADE</th>
            </tr>
        </thead>
        <tbody>
            @foreach($marks as $mk)
                @php
                    $total = ($mk->tca ?? 0) + ($mk->exm ?? 0);
                    // Calculate grade
                    $grade = 'F';
                    if ($total >= 80) $grade = 'A';
                    elseif ($total >= 70) $grade = 'B';
                    elseif ($total >= 60) $grade = 'C';
                    elseif ($total >= 50) $grade = 'D';
                @endphp
                <tr>
                    <td style="border: 1px solid #000; padding: 8px; text-align: left;">{{ $mk->subject->name ?? 'N/A' }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: left;">{{ $mk->topic->name ?? 'N/A' }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: left;">{{ $mk->topic->competency ?? 'N/A' }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ ($mk->t1) ? number_format($mk->t1, 1) : '-' }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ ($mk->tca) ? number_format($mk->tca, 1) : '-' }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ ($mk->exm) ? number_format($mk->exm, 1) : '-' }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center;">{{ number_format($total, 1) }}</td>
                    <td style="border: 1px solid #000; padding: 8px; text-align: center; font-weight: bold;">{{ $grade }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary Section -->
    @if(isset($exr))
    <div class="summary" style="margin-top: 20px; text-align: right; font-weight: bold;">
        <div style="margin-bottom: 5px;">TOTAL SCORES OBTAINED: {{ $exr->total ?? 'N/A' }}</div>
        <div style="margin-bottom: 5px;">FINAL AVERAGE: {{ $exr->ave ?? 'N/A' }}</div>
        <div>CLASS AVERAGE: {{ $exr->class_ave ?? 'N/A' }}</div>
    </div>
    @endif
</div>
