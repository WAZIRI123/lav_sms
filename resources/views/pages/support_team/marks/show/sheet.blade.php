<table class="table table-bordered table-responsive text-center">
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
            <td>{{ ($mk->t1) ? number_format($mk->t1, 2) : '-' }}</td>
            <td>{{ ($mk->tca) ? number_format($mk->tca, 2) : '-' }}</td>
            <td>{{ ($mk->exm) ? number_format($mk->exm, 2) : '-' }}</td>
            <td>{{ number_format($total, 2) }}</td>
            <td>{{ $grade }}</td>
            <td>{!! isset($subject_positions[$mk->subject_id]) ? Mk::getSuffix($subject_positions[$mk->subject_id]) : '-' !!}</td>
            <td>{{ $grade == 'F' ? 'FAIL' : 'PASS' }}</td>
        </tr>
    @endforeach
    @if(isset($exr))
    
    <tr>
        <td colspan="4"><strong>TOTAL SCORES OBTAINED: </strong> {{ $exr->total ?? 'N/A' }}</td>
        <td colspan="3"><strong>FINAL AVERAGE: </strong> {{ $exr->ave ?? 'N/A' }}</td>
        <td colspan="3"><strong>CLASS AVERAGE: </strong> {{ $exr->class_ave ?? 'N/A' }}</td>
    </tr>
    @endif
    </tbody>
</table>
