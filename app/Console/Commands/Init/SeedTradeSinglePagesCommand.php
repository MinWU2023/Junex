<?php

namespace App\Console\Commands\Init;

use App\Modules\Page\Models\Page;
use Illuminate\Console\Command;

class SeedTradeSinglePagesCommand extends Command
{
    protected $signature = 'init:seed-trade-pages {--locale= : Locale for page translations (default: app.locale)} {--force : Recreate pages even if url_key exists}';

    protected $description = 'Create 10 common foreign-trade single pages (excluding About/Contact/Privacy) with rich image+text content.';

    public function handle(): int
    {
        $locale = (string)($this->option('locale') ?: config('app.locale'));
        $force = (bool)$this->option('force');

        $definitions = $this->pageDefinitions();
        $count = 0;

        foreach ($definitions as $def) {
            $urlKey = $this->uniqueUrlKey($def['url_key'], $force);
            if ($urlKey === null) {
                $this->warn('Skip existing page: ' . $def['url_key']);
                continue;
            }

            $title = $this->buildTitle($def['title_seed']);
            $content = $this->buildHtmlContent($def['topic'], $def['sections']);

            $page = new Page();
            $page->parent_id = 0;
            $page->sort = 0;
            $page->img_alt = $def['img_alt'];
            $page->url_key = $urlKey;
            $page->img_path = null;
            $page->active = 1;
            $page->is_temp = 0;
            $page->is_translate = 0;

            $page->translateOrNew($locale)->name = $def['name'];
            $page->translateOrNew($locale)->content = $content;
            $page->translateOrNew($locale)->title = $title;
            $page->translateOrNew($locale)->keywords = $def['keywords'];
            $page->translateOrNew($locale)->description = $def['description'];
            $page->translateOrNew($locale)->brief_content = $def['brief'];

            $page->save();

            $count++;
            $this->info('Created page: ' . $page->id . ' / ' . $urlKey);
        }

        $this->info('Done. Created ' . $count . ' pages.');
        return self::SUCCESS;
    }

    private function uniqueUrlKey(string $base, bool $force): ?string
    {
        $base = trim($base, '/');
        if ($base === '') {
            return null;
        }

        if ($force) {
            Page::query()->where('url_key', $base)->delete();
        } else {
            if (Page::query()->where('url_key', $base)->exists()) {
                return null;
            }
        }

        $candidate = $base;
        $i = 2;
        while (Page::query()->where('url_key', $candidate)->exists()) {
            $candidate = $base . '-' . $i;
            $i++;
        }

        return $candidate;
    }

    private function buildTitle(string $seed): string
    {
        $seed = trim(preg_replace('/\s+/', ' ', $seed));
        $words = array_values(array_filter(explode(' ', $seed), static fn($w) => $w !== ''));

        if (count($words) < 4) {
            $words = array_merge($words, ['for', 'Global', 'Buyers']);
        }

        $target = min(8, max(4, count($words)));
        $words = array_slice($words, 0, $target);

        return implode(' ', array_map(static fn($w) => ucfirst(strtolower($w)), $words));
    }

    private function buildHtmlContent(string $topic, array $sections): string
    {
        $img1 = 'https://placehold.co/1200x680?text=No+Image';
        $img2 = 'https://placehold.co/1200x680?text=No+Image';

        $html = '';
        $html .= '<div class="page">';
        $html .= '<div class="prose">';
        $html .= '<p>' . $this->escapeText("When you source internationally, the details around {$topic} are not a nice-to-have—they directly affect lead time, landed cost, and buyer confidence. This page is written for overseas buyers who need a clear, practical overview and a few proven checklists they can reuse in RFQs and purchase orders.") . '</p>';
        $html .= '<p>' . $this->escapeText("Our goal is simple: help you evaluate suppliers faster, reduce ambiguity in specifications, and keep the communication loop tight from the first inquiry to final shipment. The best outcomes happen when both sides use the same language for quality standards, packaging, documentation, and after-sales support.") . '</p>';

        $html .= '<figure>';
        $html .= '<img src="' . $this->escapeText($img1) . '" alt="No Image" loading="lazy" />';
        $html .= '<figcaption>' . $this->escapeText('Reference visual for international sourcing workflow') . '</figcaption>';
        $html .= '</figure>';

        foreach ($sections as $section) {
            $html .= '<h2>' . $this->escapeText($section['title']) . '</h2>';
            foreach ($section['paras'] as $para) {
                $html .= '<p>' . $this->escapeText($para) . '</p>';
            }
            if (!empty($section['bullets'])) {
                $html .= '<ul>';
                foreach ($section['bullets'] as $li) {
                    $html .= '<li>' . $this->escapeText($li) . '</li>';
                }
                $html .= '</ul>';
            }
        }

        $html .= '<figure>';
        $html .= '<img src="' . $this->escapeText($img2) . '" alt="No Image" loading="lazy" />';
        $html .= '<figcaption>' . $this->escapeText('Reference visual for packaging and export compliance') . '</figcaption>';
        $html .= '</figure>';

        $html .= '<h2>' . $this->escapeText('A Ready-To-Use Buyer Checklist') . '</h2>';
        $html .= '<ul>';
        foreach ($this->buyerChecklist($topic) as $li) {
            $html .= '<li>' . $this->escapeText($li) . '</li>';
        }
        $html .= '</ul>';

        $html .= '<p>' . $this->escapeText($this->closingParagraph($topic)) . '</p>';
        $html .= '</div>';
        $html .= '</div>';

        $html = $this->padToWordRange($html, 800, 1000, $topic);
        return $html;
    }

    private function buyerChecklist(string $topic): array
    {
        return [
            'Confirm product scope, variants, and any custom requirements in one structured list.',
            'Ask for standard lead time, peak-season lead time, and the capacity plan.',
            'Lock quality criteria: sampling plan, tolerances, and acceptable defect level.',
            'Define packaging: unit pack, master carton, pallet pattern, and labeling language.',
            'Request photos and inspection records before shipment (or appoint a third-party inspection).',
            'Align on Incoterms, destination port, shipping schedule, and required documents.',
            'Clarify after-sales handling: warranty window, spare parts policy, and response time.',
            'Document everything for repeat orders: spec sheet, artwork files, and revision history.',
        ];
    }

    private function closingParagraph(string $topic): string
    {
        return "If you want a smoother buying experience for {$topic}, start with clarity and repeatability. A supplier can only perform against what is written, so the more structured your inputs are, the more predictable your output becomes—on time, on spec, and with fewer surprises at customs or at your warehouse.";
    }

    private function padToWordRange(string $html, int $min, int $max, string $topic): string
    {
        $plain = trim(preg_replace('/\s+/', ' ', strip_tags($html)));
        $words = $plain === '' ? [] : preg_split('/\s+/', $plain);
        $wordCount = is_array($words) ? count($words) : 0;

        if ($wordCount > $max) {
            return $html;
        }

        $fillers = $this->fillerParagraphs($topic);
        $i = 0;
        while ($wordCount < $min && $i < count($fillers)) {
            $html .= '<p>' . $this->escapeText($fillers[$i]) . '</p>';
            $plain = trim(preg_replace('/\s+/', ' ', strip_tags($html)));
            $words = $plain === '' ? [] : preg_split('/\s+/', $plain);
            $wordCount = is_array($words) ? count($words) : 0;
            $i++;
        }

        return $html;
    }

    private function fillerParagraphs(string $topic): array
    {
        return [
            "A practical way to reduce misunderstandings is to standardize how you describe {$topic}. Use measurable statements such as sizes, material grades, testing methods, and photo references. If your buyer team and supplier team use the same template, iterations become faster and approvals become clearer.",
            "For international trade, documentation is part of the product. Commercial invoices, packing lists, certificates, and labeling requirements can delay shipments if they are discussed late. Treat documents as deliverables with owners, deadlines, and review steps.",
            "When evaluating a supplier, ask for evidence rather than promises: past shipment references, typical inspection reports, and a transparent corrective-action process. A mature supplier will show how they handle issues, not just how they avoid talking about them.",
            "Finally, keep your communication loop simple: one thread for technical specs, one for schedule, and one for payment and logistics. That structure prevents details from getting lost and improves the quality of every future reorder.",
        ];
    }

    private function escapeText(string $text): string
    {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }

    private function pageDefinitions(): array
    {
        return [
            [
                'url_key' => 'shipping-delivery',
                'name' => 'Shipping & Delivery',
                'title_seed' => 'Shipping and Delivery Guide',
                'topic' => 'shipping and delivery',
                'img_alt' => 'Shipping and Delivery',
                'keywords' => 'shipping, delivery, incoterms, freight, logistics',
                'description' => 'Learn how shipping, lead time, and delivery terms work for international orders.',
                'brief' => 'A practical overview of shipping options, Incoterms, documents, and delivery timelines.',
                'sections' => [
                    [
                        'title' => 'Choosing the Right Shipping Method',
                        'paras' => [
                            'Air freight is fast and flexible for urgent replenishment, while sea freight is usually more cost-effective for bulk orders. The best choice depends on your timeline, product density, and how predictable your demand is.',
                            'For many B2B buyers, a hybrid approach works well: use air for samples and first orders, then switch to sea once specifications are stable and the reorder cycle is predictable.',
                        ],
                        'bullets' => [
                            'Air: shorter transit time, higher cost, simpler scheduling.',
                            'Sea: lower cost, longer transit time, needs tighter planning.',
                            'Express: great for spare parts and documents, limited by size/weight.',
                        ],
                    ],
                    [
                        'title' => 'Lead Time, ETD, and ETA',
                        'paras' => [
                            'Lead time includes production, internal QC, packaging, and export handling. ETD is the estimated departure date, and ETA is the estimated arrival date. Aligning definitions upfront prevents surprises.',
                            'Ask for a timeline that shows every step: raw material readiness, production start, inspection, booking, and document preparation.',
                        ],
                        'bullets' => [
                            'Confirm whether lead time starts after deposit, artwork approval, or sample approval.',
                            'Request buffer planning for peak season and holidays.',
                        ],
                    ],
                ],
            ],
            [
                'url_key' => 'payment-terms',
                'name' => 'Payment Terms',
                'title_seed' => 'Payment Terms for International Orders',
                'topic' => 'payment terms',
                'img_alt' => 'Payment Terms',
                'keywords' => 'payment terms, T/T, L/C, trade assurance, risk control',
                'description' => 'Understand common international payment terms and how to manage transaction risks.',
                'brief' => 'An easy guide to payment options, risk control, and best practices for buyers.',
                'sections' => [
                    [
                        'title' => 'Common Payment Options',
                        'paras' => [
                            'For many factory-direct transactions, T/T is common: a deposit to start production and a balance before shipment. L/C can add protection for larger orders but often comes with extra bank fees and stricter document requirements.',
                            'The safest option depends on trust, order size, and how standardized the products are.',
                        ],
                        'bullets' => [
                            'T/T: fast, common, depends on supplier relationship.',
                            'L/C: more formal protection, more paperwork and fees.',
                            'Online escrow/trade assurance: helpful for first orders where available.',
                        ],
                    ],
                    [
                        'title' => 'Reducing Risk Without Adding Friction',
                        'paras' => [
                            'Risk control does not have to slow you down. Use phased approvals: confirm samples, then confirm packaging, then confirm pre-shipment inspection, then release balance.',
                            'Always align on who owns bank charges, exchange-rate exposure, and proof-of-payment requirements.',
                        ],
                        'bullets' => [
                            'Ask for proforma invoice details to match your bank’s compliance rules.',
                            'Use third-party inspection for high-value or first-time orders.',
                        ],
                    ],
                ],
            ],
            [
                'url_key' => 'oem-odm-services',
                'name' => 'OEM & ODM Services',
                'title_seed' => 'OEM ODM Custom Manufacturing Services',
                'topic' => 'OEM and ODM services',
                'img_alt' => 'OEM ODM Services',
                'keywords' => 'OEM, ODM, customization, private label, manufacturing',
                'description' => 'Explore OEM/ODM options, customization workflow, and what information we need from buyers.',
                'brief' => 'A clear OEM/ODM workflow: from concept and sampling to mass production and shipment.',
                'sections' => [
                    [
                        'title' => 'What OEM and ODM Mean in Practice',
                        'paras' => [
                            'OEM typically focuses on producing to your specifications under your brand, while ODM often includes product design input and development support. In reality, many projects include both elements.',
                            'A successful customization project starts with clear constraints: target market, compliance needs, cost targets, and packaging requirements.',
                        ],
                        'bullets' => [
                            'OEM: you provide specs, supplier manufactures.',
                            'ODM: supplier supports design and development, then manufactures.',
                        ],
                    ],
                    [
                        'title' => 'Sampling and Approval Workflow',
                        'paras' => [
                            'Sampling reduces risk when moving to mass production. Provide reference photos, dimension drawings, material requirements, and labeling language to speed up iteration.',
                            'Treat the sample as a contract: once approved, lock a golden sample and document any future changes with version control.',
                        ],
                        'bullets' => [
                            'Share artwork files in editable formats where possible.',
                            'Confirm packaging mockups before bulk production.',
                        ],
                    ],
                ],
            ],
            [
                'url_key' => 'quality-control',
                'name' => 'Quality Control',
                'title_seed' => 'Quality Control Standards and Process',
                'topic' => 'quality control',
                'img_alt' => 'Quality Control',
                'keywords' => 'quality control, inspection, AQL, testing, compliance',
                'description' => 'See how QC works: from raw material checks to final inspection and shipment release.',
                'brief' => 'QC overview including inspection points, reporting, and corrective actions.',
                'sections' => [
                    [
                        'title' => 'From Incoming to Final Inspection',
                        'paras' => [
                            'A good QC system starts with incoming material checks, continues through in-process inspection, and ends with final random inspection before shipment. Each stage prevents issues from propagating.',
                            'Define measurable criteria early: dimensions, appearance, function, packaging integrity, and labeling accuracy.',
                        ],
                        'bullets' => [
                            'Incoming: verify material grade and key components.',
                            'In-process: catch defects before they scale.',
                            'Final: confirm readiness for shipment and documentation.',
                        ],
                    ],
                    [
                        'title' => 'Inspection Reports and Corrective Actions',
                        'paras' => [
                            'Inspection photos, measurements, and defect summaries help both sides act quickly. When issues occur, a structured corrective-action plan protects future orders.',
                            'Ask for clear timelines: containment, root cause, correction, and prevention steps.',
                        ],
                        'bullets' => [
                            'Agree on acceptable defect levels for critical/major/minor items.',
                            'Use a consistent report format for repeat orders.',
                        ],
                    ],
                ],
            ],
            [
                'url_key' => 'warranty-after-sales',
                'name' => 'Warranty & After-Sales',
                'title_seed' => 'Warranty and After Sales Support',
                'topic' => 'warranty and after-sales support',
                'img_alt' => 'Warranty After Sales',
                'keywords' => 'warranty, after-sales, spare parts, support, service',
                'description' => 'Understand warranty scope, claim process, and after-sales support expectations.',
                'brief' => 'Warranty policy overview and how to handle claims efficiently across borders.',
                'sections' => [
                    [
                        'title' => 'Defining Warranty Scope',
                        'paras' => [
                            'Warranty should be specific: what failures are covered, what evidence is required, and what remedies apply. For B2B orders, clear scope prevents long disputes.',
                            'Agree on whether the warranty includes replacements, spare parts, credit notes, or other remedies.',
                        ],
                        'bullets' => [
                            'Define warranty window starting point (shipment date or arrival date).',
                            'Define claim evidence: photos, video, batch code, and inspection notes.',
                        ],
                    ],
                    [
                        'title' => 'Spare Parts and Response Time',
                        'paras' => [
                            'Many buyers prefer to stock critical spare parts to reduce downtime. A good supplier can recommend a spare parts list based on failure modes.',
                            'Response time matters. Confirm who your point of contact is and what the escalation path looks like.',
                        ],
                        'bullets' => [
                            'Keep a spare parts quote for fast reorder.',
                            'Set a target response time for urgent technical issues.',
                        ],
                    ],
                ],
            ],
            [
                'url_key' => 'packaging-labeling',
                'name' => 'Packaging & Labeling',
                'title_seed' => 'Packaging and Labeling Requirements',
                'topic' => 'packaging and labeling',
                'img_alt' => 'Packaging Labeling',
                'keywords' => 'packaging, labeling, cartons, pallets, barcodes, compliance',
                'description' => 'Packaging, labeling, and export packaging best practices for overseas shipments.',
                'brief' => 'A buyer-friendly checklist for packaging specs and labeling compliance.',
                'sections' => [
                    [
                        'title' => 'Packaging Specs That Prevent Damage',
                        'paras' => [
                            'Packaging is a system: inner pack, master carton, and palletization should work together. The goal is to protect goods and reduce handling damage across long transit routes.',
                            'Provide clear requirements for carton strength, internal protection, and moisture control where relevant.',
                        ],
                        'bullets' => [
                            'Confirm carton dimensions and gross/net weights.',
                            'Confirm pallet type and max stacking height.',
                        ],
                    ],
                    [
                        'title' => 'Labeling and Market Compliance',
                        'paras' => [
                            'Different markets require different labeling elements. Define language, barcode format, country-of-origin marking, and warning labels early.',
                            'Treat labeling as artwork with version control and approval steps.',
                        ],
                        'bullets' => [
                            'Provide label artwork and required languages.',
                            'Confirm carton marks for shipping and warehouse handling.',
                        ],
                    ],
                ],
            ],
            [
                'url_key' => 'request-quote',
                'name' => 'Request a Quote',
                'title_seed' => 'Request a Quote Fast',
                'topic' => 'requesting a quote',
                'img_alt' => 'Request a Quote',
                'keywords' => 'RFQ, quote, pricing, MOQ, lead time, specification',
                'description' => 'How to request a quote effectively and receive accurate pricing faster.',
                'brief' => 'RFQ essentials: what to send, how to define specs, and how to compare quotes.',
                'sections' => [
                    [
                        'title' => 'What to Include in an RFQ',
                        'paras' => [
                            'A good RFQ reduces back-and-forth. Include specifications, target quantity, destination, required certifications, and packaging requirements in a single message.',
                            'If you are comparing multiple suppliers, keep your RFQ format consistent so you can compare responses fairly.',
                        ],
                        'bullets' => [
                            'Product spec sheet or clear reference photos.',
                            'Target quantity and expected reorder frequency.',
                            'Destination port/country and preferred Incoterms.',
                        ],
                    ],
                    [
                        'title' => 'Comparing Quotes Without Missing Hidden Costs',
                        'paras' => [
                            'Pricing is more than unit cost. Compare tooling, packaging, sampling fees, payment terms, and inspection costs to avoid surprises.',
                            'Ask for a quote validity period and confirm whether the price is tied to raw material indexes.',
                        ],
                        'bullets' => [
                            'Confirm MOQ and price breaks by quantity.',
                            'Confirm whether packaging is included or itemized.',
                        ],
                    ],
                ],
            ],
            [
                'url_key' => 'certifications-compliance',
                'name' => 'Certifications & Compliance',
                'title_seed' => 'Certifications and Compliance Overview',
                'topic' => 'certifications and compliance',
                'img_alt' => 'Certifications Compliance',
                'keywords' => 'certifications, compliance, CE, RoHS, FDA, documentation',
                'description' => 'Learn common certifications and compliance documents for importing goods.',
                'brief' => 'A practical overview of certification expectations and document preparation.',
                'sections' => [
                    [
                        'title' => 'What Compliance Usually Means for Buyers',
                        'paras' => [
                            'Compliance is market-specific. Your target market determines which directives, testing methods, and label requirements apply. Confirm these before sampling to avoid rework.',
                            'When in doubt, start by listing the destination countries and sales channels, then map the compliance requirements accordingly.',
                        ],
                        'bullets' => [
                            'Define destination market and channel requirements early.',
                            'Request test reports and certificates for verification.',
                        ],
                    ],
                    [
                        'title' => 'Documents You May Need',
                        'paras' => [
                            'Typical documents include a commercial invoice, packing list, certificate of origin, and sometimes additional certificates. Lead time can be impacted if documents are prepared at the last minute.',
                            'Ask who issues the documents, how corrections are handled, and how originals are delivered.',
                        ],
                        'bullets' => [
                            'Commercial invoice and packing list consistency is critical.',
                            'Confirm if originals are needed by your customs broker.',
                        ],
                    ],
                ],
            ],
            [
                'url_key' => 'faq-buyers',
                'name' => 'Buyer FAQs',
                'title_seed' => 'Buyer FAQs for Global Sourcing',
                'topic' => 'buyer FAQs',
                'img_alt' => 'Buyer FAQs',
                'keywords' => 'FAQ, buyers, sourcing, manufacturing, shipping, payment',
                'description' => 'Common questions from overseas buyers, answered in a straightforward way.',
                'brief' => 'Frequently asked questions to help buyers move faster and reduce uncertainty.',
                'sections' => [
                    [
                        'title' => 'Questions About Orders and Lead Time',
                        'paras' => [
                            'Most buyers want predictability. Ask for a confirmed production plan and the earliest possible shipping schedule. If your order is seasonal, plan earlier to secure capacity.',
                            'If you need partial shipments, clarify whether they are allowed and how costs are handled.',
                        ],
                        'bullets' => [
                            'What is your standard lead time and peak-season lead time?',
                            'Can you provide photos and inspection results before shipment?',
                        ],
                    ],
                    [
                        'title' => 'Questions About Quality and Claims',
                        'paras' => [
                            'The fastest claims are documented claims. Agree on how defects are recorded and what the resolution path looks like. This protects your customer relationships on your side.',
                            'For repeated items, lock a golden sample so the acceptable standard remains consistent over time.',
                        ],
                        'bullets' => [
                            'What QC checkpoints do you use for this product type?',
                            'What is the standard warranty and claim response time?',
                        ],
                    ],
                ],
            ],
            [
                'url_key' => 'company-profile',
                'name' => 'Company Profile',
                'title_seed' => 'Company Profile for Buyers',
                'topic' => 'company profile',
                'img_alt' => 'Company Profile',
                'keywords' => 'company profile, factory, capability, team, production',
                'description' => 'A buyer-focused company profile: capability, process, and what to expect when working with us.',
                'brief' => 'A quick company profile tailored for international buyers and sourcing teams.',
                'sections' => [
                    [
                        'title' => 'What We Do and How We Support Buyers',
                        'paras' => [
                            'International buyers often need more than a product—they need reliability, transparent communication, and stable lead times. A good supplier provides consistent documentation and clear ownership across the process.',
                            'Our internal workflow is designed to make repeat orders easier by keeping specifications, packaging, and quality records organized.',
                        ],
                        'bullets' => [
                            'Clear handoff from sales to production planning.',
                            'Structured QC checkpoints with reportable records.',
                            'Export-ready packaging and documentation support.',
                        ],
                    ],
                    [
                        'title' => 'Capacity, Capability, and Continuous Improvement',
                        'paras' => [
                            'Capability is not only machines and equipment, but also how a team handles changes. We aim to keep changes traceable and approvals clear so production remains stable.',
                            'For long-term cooperation, continuous improvement matters: fewer defects, faster onboarding for new SKUs, and clearer documentation each quarter.',
                        ],
                        'bullets' => [
                            'Ask for process documentation and sample approval records.',
                            'Use quarterly reviews to improve ordering efficiency.',
                        ],
                    ],
                ],
            ],
        ];
    }
}
