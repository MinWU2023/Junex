@php
    $certificateCards = $certificateCards ?? [
        [
            'name' => 'OEKO-TEX STANDARD 100',
            'image' => 'https://placehold.co/420x560/f8f8f8/555555?text=OEKO-TEX+100',
        ],
        [
            'name' => 'amfori BSCI',
            'image' => 'https://placehold.co/420x560/f8f8f8/555555?text=amfori+BSCI',
        ],
        [
            'name' => 'ISO 9001',
            'image' => 'https://placehold.co/420x560/f8f8f8/555555?text=ISO+9001',
        ],
        [
            'name' => 'Global Recycled Standard (GRS)',
            'image' => 'https://placehold.co/420x560/f8f8f8/555555?text=GRS',
        ],
    ];
@endphp
<section class="cs-cert sec-bg-white" aria-label="Multiple Certificate Verification">
    <div class="cs-cert-inner sec-pad">
        <div class="cs-cert-header">
            <h2 class="cs-cert-title">MULTIPLE CERTIFICATE VERIFICATION</h2>
            <div class="cs-cert-bar" aria-hidden="true"></div>
            <p class="cs-cert-desc">
                Our Company Holds Internationally Recognized Certifications, Including BSCI (Grade B), GRS, ISO 9001, And OEKO TEX 100. These Help Your Brand Meet Retailer And Customer Requirements For Quality.
            </p>
        </div>
    </div>
    <div class="cs-cert-carousel">
        <button type="button" class="cs-cert-nav cs-cert-prev" aria-label="Previous certificates">
            <svg class="cs-cert-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M15 18l-6-6 6-6"/></svg>
        </button>
        <div class="cs-cert-viewport">
            <div class="swiper cs-cert-swiper">
                <div class="swiper-wrapper">
                    @foreach($certificateCards as $card)
                        <div class="swiper-slide">
                            <article class="cs-cert-card">
                                <img
                                    class="cs-cert-img"
                                    src="{{ $card['image'] ?? '' }}"
                                    alt="{{ $card['name'] ?? 'Certificate' }}"
                                    loading="lazy"
                                />
                            </article>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        <button type="button" class="cs-cert-nav cs-cert-next" aria-label="Next certificates">
            <svg class="cs-cert-nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 18l6-6-6-6"/></svg>
        </button>
        <div class="cs-cert-pagination" aria-label="Certificate slides"></div>
    </div>
</section>
