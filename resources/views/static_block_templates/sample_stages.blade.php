@php
    $sampleStages = $sampleStages ?? [
        [
            'tag' => 'STAGE A · PROTO',
            'title' => 'Actual Bulk Fabric, Single Size Point On Body.',
            'features' => [
                ['label' => 'Built In:', 'text' => 'The PP Sample Becomes The Contractual Reference. Everything That Ships Must Match The PP.'],
                ['label' => 'Built In:', 'text' => 'Construction Matches Tech-Pack Diagrams. Seam-Pull Test Passes. No Silent Substitutions.'],
                ['label' => 'Built In:', 'text' => 'The PP Sample Becomes The Contractual Reference. Everything That Ships Must Match The PP.'],
            ],
            'lead_time' => '4–6 Working Days · Revision Round 3–5 Days Each',
        ],
        [
            'tag' => 'STAGE B · FIT',
            'title' => 'Actual Bulk Fabric, Single Size Point On Body.',
            'features' => [
                ['label' => 'Built In:', 'text' => 'The PP Sample Becomes The Contractual Reference. Everything That Ships Must Match The PP.'],
                ['label' => 'Built In:', 'text' => 'Construction Matches Tech-Pack Diagrams. Seam-Pull Test Passes. No Silent Substitutions.'],
                ['label' => 'Built In:', 'text' => 'The PP Sample Becomes The Contractual Reference. Everything That Ships Must Match The PP.'],
            ],
            'lead_time' => '4–6 Working Days · Revision Round 3–5 Days Each',
        ],
        [
            'tag' => 'STAGE C · PP',
            'title' => 'Actual Bulk Fabric, Single Size Point On Body.',
            'features' => [
                ['label' => 'Built In:', 'text' => 'The PP Sample Becomes The Contractual Reference. Everything That Ships Must Match The PP.'],
                ['label' => 'Built In:', 'text' => 'Construction Matches Tech-Pack Diagrams. Seam-Pull Test Passes. No Silent Substitutions.'],
                ['label' => 'Built In:', 'text' => 'The PP Sample Becomes The Contractual Reference. Everything That Ships Must Match The PP.'],
            ],
            'lead_time' => '4–6 Working Days · Revision Round 3–5 Days Each',
        ],
        [
            'tag' => 'STAGE D · SIZE SET',
            'title' => 'Actual Bulk Fabric, Single Size Point On Body.',
            'features' => [
                ['label' => 'Built In:', 'text' => 'The PP Sample Becomes The Contractual Reference. Everything That Ships Must Match The PP.'],
                ['label' => 'Built In:', 'text' => 'Construction Matches Tech-Pack Diagrams. Seam-Pull Test Passes. No Silent Substitutions.'],
                ['label' => 'Built In:', 'text' => 'The PP Sample Becomes The Contractual Reference. Everything That Ships Must Match The PP.'],
            ],
            'lead_time' => '4–6 Working Days · Revision Round 3–5 Days Each',
        ],
    ];
@endphp
<section class="cs-stages sec-bg-color" aria-label="Four Sample Stages">
    <div class="cs-stages-inner sec-pad">
        <div class="cs-stages-header">
            <h2 class="cs-stages-title">FOUR SAMPLE STAGES. EACH ONE APPROVED IN WRITING BEFORE THE NEXT IS CUT.</h2>
            <div class="cs-stages-bar" aria-hidden="true"></div>
            <p class="cs-stages-desc">
                Our Company Holds Internationally Recognized Certifications, Including BSCI (Grade B), GRS, ISO 9001, And OEKO TEX 100. These Help Your Brand Meet Retailer And Customer Requirements For Quality.
            </p>
        </div>
        <div class="cs-stages-grid">
            @foreach($sampleStages as $stage)
                <article class="sample-stage-card sample-card">
                    <span class="sample-stage-tag sample-badge">{{ $stage['tag'] }}</span>
                    <h3 class="sample-stage-title">{{ $stage['title'] }}</h3>
                    <ul class="sample-stage-list">
                        @foreach(($stage['features'] ?? []) as $feature)
                            <li class="sample-stage-item sample-feature-item">
                                <img
                                    class="sample-stage-check"
                                    src="/front/imgs/cs-fs-duigou.png"
                                    alt=""
                                    width="14"
                                    height="14"
                                    loading="lazy"
                                    aria-hidden="true"
                                />
                                <div class="sample-stage-item-body">
                                    <span class="sample-stage-label">{{ $feature['label'] }}</span>
                                    <span class="sample-stage-text"> {{ $feature['text'] }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                    <div class="sample-stage-footer">
                        <div class="sample-stage-divider" aria-hidden="true"></div>
                        <div class="sample-stage-lead">
                            <div class="sample-stage-lead-label">Lead Time</div>
                            <div class="sample-stage-lead-value">{{ $stage['lead_time'] }}</div>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
    </div>
</section>
