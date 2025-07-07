{{--<!--NAME , CLASS AND OTHER INFO -->--}}
<table style="width:100%; border-collapse:collapse; ">
    <tbody>
    <tr>
        <td><strong>NAME:</strong> {{ strtoupper($sr->user->name) }}</td>
        <td><strong>ADM NO:</strong> {{ $sr->adm_no }}</td>
        <td><strong>HOUSE:</strong> {{ strtoupper($sr->house) }}</td>
        <td><strong>CLASS:</strong> {{ strtoupper($my_class->name) }}</td>
    </tr>
    <tr>
        <td><strong>REPORT SHEET FOR</strong> {!! strtoupper(Mk::getSuffix($ex->term)) !!} TERM </td>
        <td><strong>ACADEMIC YEAR:</strong> {{ $ex->year }}</td>
        <td><strong>AGE:</strong> {{ $sr->age ?: ($sr->user->dob ? date_diff(date_create($sr->user->dob), date_create('now'))->y : '-') }}</td>
    </tr>

    </tbody>
</table>


{{--Exam Table--}}
<table style="width:100%; border-collapse:collapse; border: 1px solid #000; margin: 10px auto;" border="1">
    <thead>
    <tr>
        <th>SUBJECTS</th>
        <th>CHAPTER</th>
        <th>COMPETENCY</th>
        <th>A.O.I SCORE</th>
        <th>RAW MARKS X/20</th>
        <th>EXAM X/80</th>
        <th>TOTAL 100%</th>
        <th>GRADE</th>
        <th>SUBJECT POSITION</th>
        <th>REMARKS</th>
    </tr>
    </thead>
    <tbody>

    @foreach($marks as $mk)
        @php
            $total = ($mk->t1 ?? 0) + ($mk->tca ?? 0) + ($mk->exm ?? 0);
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
            <td>{{ ($mk->t1) ? number_format($mk->t1, 2) : '-' }}</td>
            <td>{{ ($mk->tca) ? number_format($mk->tca, 2) : '-' }}</td>
            <td>{{ ($mk->exm) ? number_format($mk->exm, 2) : '-' }}</td>
            <td>{{ number_format($total, 2) }}</td>
            <td>{{ $grade }}</td>
            <td>{!! isset($subject_positions[$mk->subject_id]) ? Mk::getSuffix($subject_positions[$mk->subject_id]) : '-' !!}</td>
            <td>{{ $grade == 'F' ? 'FAIL' : 'PASS' }}</td>
        </tr>
    @endforeach
    <tr>
        <td colspan="4"><strong>TOTAL SCORES OBTAINED: </strong> {{ $exr->total ?? 'N/A' }}</td>
        <td colspan="3"><strong>FINAL AVERAGE: </strong> {{ $exr->ave ?? 'N/A' }}</td>
        <td colspan="3"><strong>CLASS AVERAGE: </strong> {{ $exr->class_ave ?? 'N/A' }}</td>
    </tr>
    </tbody>
</table>
