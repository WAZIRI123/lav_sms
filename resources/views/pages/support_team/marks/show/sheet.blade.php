@php
    // Get school information from settings
    $schoolName = Qs::getSetting('school_name') ?? 'HOPE INTEGRATED SECONDARY SCHOOL';
    $schoolMotto = Qs::getSetting('school_motto') ?? 'Building Hope, Inspiring Lives & Academic Excellence';
    $schoolAddress = Qs::getSetting('school_address') ?? 'P.O BOX 1226, LWENGO DISTRICT';
    $schoolPhone = Qs::getSetting('school_phone') ?? 'TEL: 0703-145230/0755-759106';
    $currentYear = Qs::getSetting('current_session') ?? date('Y');
    $currentTerm = Qs::getSetting('current_term') ?? 1;
    
    // Get exam information
    $examName = $ex->name ?? '';
    $examYear = $ex->year ?? $currentYear;
    $examTerm = $ex->term ?? $currentTerm;
    
    // Get student information
    $studentName = $sr->user->name ?? '';
    $studentId = $sr->id ?? '';
    $studentGender = $sr->user->gender ?? '';
    $className = $my_class->name ?? '';
    $sectionName = $my_class->section->first()->name ?? '';
    $classFullName = trim("$className $sectionName");
    
    // Get school logo path
    $schoolLogo = Qs::getSetting('logo') ?? asset('global_assets/images/placeholders/placeholder.jpg');
    
    // Get student photo
    $studentPhoto = $sr->user->photo ?? asset('global_assets/images/placeholders/placeholder.jpg');
    
    // Set print-specific styles
    $printStyles = "
        @page { 
            size: A4; 
            margin: 10mm; 
        }
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12pt;
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }
        .marksheet-container { 
            max-width: 1000px; 
            margin: 0 auto; 
            padding: 20px; 
        }
        .school-header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 20px; 
            border-bottom: 2px solid #000; 
            padding-bottom: 15px; 
        }
        .school-logo { 
            width: 80px; 
            height: 80px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            overflow: hidden; 
        }
        .school-logo img { 
            max-width: 100%; 
            max-height: 100%; 
            object-fit: contain; 
        }
        .school-info { 
            text-align: center; 
            flex-grow: 1; 
        }
        .school-info h2 { 
            margin: 0; 
            font-size: 20px; 
            font-weight: bold; 
        }
        .school-info p { 
            margin: 5px 0; 
            font-size: 12px; 
        }
        .student-photo { 
            width: 80px; 
            height: 100px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            overflow: hidden; 
            border: 1px solid #ddd; 
        }
        .student-photo img { 
            max-width: 100%; 
            max-height: 100%; 
            object-fit: cover; 
        }
        .document-title { 
            text-align: center; 
            margin: 15px 0 10px; 
        }
        .document-title h3 { 
            margin: 0; 
            font-size: 18px; 
            text-decoration: underline; 
        }
        .student-info { 
            width: 100%;
            margin-bottom: 20px;
            margin-left: auto;
            margin-right: auto;
            border-collapse: collapse;
            font-size: 12px;
        }
        .student-info td {
            padding: 8px;
            vertical-align: top;
        }
    
        table { 
            width: 100%; 
            border-collapse: collapse; 
            margin-bottom: 20px; 
            font-size: 11pt;
        }
        th, td { 
            border: 1px solid #000; 
            padding: 8px; 
            text-align: left; 
        }
        th { 
            background-color: #f0f0f0; 
            text-align: center; 
            font-weight: bold; 
        }
        .summary { 
            text-align: right; 
            margin-top: 10px; 
            font-weight: bold; 
            font-size: 12pt; 
        }
        @media print {
            body { 
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print { 
                display: none !important; 
            }
            .page-break { 
                page-break-before: always; 
            }
            table { 
                page-break-inside: auto;
            }
            tr { 
                page-break-inside: avoid;
                page-break-after: auto;
            }
        }
    ";
@endphp

<style>
    {{ $printStyles }}
</style>

<div class="marksheet-container" style="font-family: Arial, sans-serif; max-width: 1000px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; background-color: #fff0f5;">
      <!-- School Header -->
      <div class="school-header">
        <div class="school-logo">
            <img src="{{ $schoolLogo ? asset('storage/public/uploads/' . basename($schoolLogo)) : asset('global_assets/images/placeholders/placeholder.jpg') }}" alt="School Logo">
        </div>
        <div class="school-info">
            <h2>{{ $schoolName }}</h2>
            <p style="font-style: italic;">{{ $schoolMotto }}</p>
            <p style="font-size: 12px;">{{ $schoolAddress }}, {{ $schoolPhone }}</p>
            @if(isset($class_type) && $class_type)
            <p style="font-size: 12px;">REPORT SHEET ({{ strtoupper($class_type->name) }})</p>
            @endif
        </div>
        <div class="student-photo">
            <img src="{{ $studentPhoto }}" alt="Student Photo">
        </div>
    </div>
    <!-- Document Title -->
    <div class="document-title">
        <h3>LEARNER'S {{ strtoupper($examName) }} ASSESSMENT SCORES, {{ $examYear }}</h3>
    </div>

    <!-- Student Information -->
    <div style="display: flex;  gap: 20px; margin-bottom: 1px;">
        <!-- Left Box -->
        <div style=" padding-top:0.5rem; padding-bottom:0.5rem; flex: 1;">
            <div style=" width: 80%; margin-left: auto; margin-right: auto; padding: 10px; font-size:14px; text-align: center;"><strong>NAME:</strong> {{ strtoupper($studentName) }}</div>
            <div style=" width: 80%; margin-left: auto; margin-right: auto; padding: 10px; font-size:14px; text-align: center;"><strong>STUDENT ID:</strong> {{ strtoupper($studentId) }}</div>
           
        </div>
        
        <!-- Right Box -->
        <div style=" padding-top:0.5rem; padding-bottom:0.5rem; flex: 1;">
            <div style=" width: 80%; margin-left: auto; margin-right: auto; padding: 10px; font-size:14px; text-align: center;"><strong>SEX:</strong> {{ strtoupper($studentGender) }}</div>
         
            <div style=" width: 80%; margin-left: auto; margin-right: auto; padding: 10px; font-size:14px; text-align: center;"><strong>CLASS:</strong> {{ $classFullName }}</div>
           
        </div>

          <!-- Right Box -->
          <div style=" padding-top:0.5rem; padding-bottom:0.5rem; flex: 1;">
            <div style=" width: 80%; margin-left: auto; margin-right: auto; padding: 10px; font-size:14px; text-align: center;"><strong>TERM:</strong> {{ $examTerm }}</div>
         
            <div style=" width: 80%; margin-left: auto; margin-right: auto; padding: 10px; font-size:14px; text-align: center;"><strong>YEAR:</strong> {{ $examYear }}</div>
           
        </div>

    </div>

    <!-- Marks Table -->
    <table class="marks-table">
        <thead>
            <tr>
                <th style="text-align: left;">SUBJECTS</th>
                <th style="text-align: left;">CHAPTER</th>
                <th style="text-align: left;">COMPETENCY</th>
                <th style="text-align: center;">A.O.I SCORE</th>
                <th style="text-align: center;">RAW MARKS X/20</th>
                <th style="text-align: center;">EXAM X/80</th>
                <th style="text-align: center;">TOTAL 100%</th>
                <th style="text-align: center;">GRADE</th>
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
                    <td>{{ $mk->subject->name ?? 'N/A' }}</td>
                    <td>{{ $mk->topic->name ?? 'N/A' }}</td>
                    <td>{{ $mk->topic->competency ?? 'N/A' }}</td>
                    <td style="text-align: center;">{{ ($mk->t1) ? number_format($mk->t1, 1) : '-' }}</td>
                    <td style="text-align: center;">{{ ($mk->tca) ? number_format($mk->tca, 1) : '-' }}</td>
                    <td style="text-align: center;">{{ ($mk->exm) ? number_format($mk->exm, 1) : '-' }}</td>
                    <td style="text-align: center;">{{ number_format($total, 1) }}</td>
                    <td style="text-align: center; font-weight: bold;">{{ $grade }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Summary Section -->
    @if(isset($exr))
    <div class="summary" style="display: flex; justify-content: space-between; width: 100%;">
        <div style="margin-right: 20px;">TOTAL SCORES OBTAINED: {{ $exr->total ?? 'N/A' }}</div>
        <div style="margin-right: 20px;">FINAL AVERAGE: {{ $exr->ave ?? 'N/A' }}</div>
        <div>CLASS AVERAGE: {{ $exr->class_ave ?? 'N/A' }}</div>
    </div>
    @endif

</div>
