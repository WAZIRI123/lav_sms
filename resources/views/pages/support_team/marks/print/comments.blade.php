<div style="font-family: Arial, sans-serif; line-height: 1.8; max-width: 1000px;
        margin: 0 auto;
        padding: 20px;">
    <div style="margin-bottom: 15px;">
        <div><strong>Class teacher's comment:</strong></div>
        <div style="border-bottom: 1px solid #000; min-height: 20px; margin-top: 5px;">
            {{ $exr->t_comment ?: '' }}
        </div>
    </div>
    
    <div style="margin-bottom: 15px;">
        <div><strong>Head teacher's comment:</strong></div>
        <div style="border-bottom: 1px solid #000; min-height: 20px; margin-top: 5px;">
            {{ $exr->p_comment ?: '' }}
        </div>
    </div>
    
    <div style="margin-top: 20px;">
        <div><strong>Next term begins:</strong> {{ date('l\, jS F\, Y', strtotime($s['term_begins'])) }}</div>
        <div><strong>Next term fees:</strong> <del style="text-decoration-style: double">N</del>{{ number_format($s['next_term_fees_'.strtolower($ct)], 2) }}</div>
    </div>

    <div style="text-align: center; margin-top: 30px; font-style: italic; font-size: 12px;">
        "THE REPORT CARD IS INVALID WITHOUT OFFICIAL STAMP"
    </div>
</div>
