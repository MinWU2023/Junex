<?php

namespace App\Console\Commands\Init;

use App\Modules\User\Models\Faq;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SeedFaqs extends Command
{
    protected $signature = 'seed:faqs {--groups=2 : Number of groups} {--per-group=10 : Items per group}';
    protected $description = 'Seed FAQs with en translations (two groups, 10 items each by default).';

    public function handle(): int
    {
        $groups = (int)$this->option('groups');
        $perGroup = (int)$this->option('per-group');

        if ($groups <= 0 || $perGroup <= 0) {
            $this->error('Groups and per-group must be greater than 0.');
            return 1;
        }

        DB::beginTransaction();
        try {
            for ($g = 1; $g <= $groups; $g++) {
                $groupName = 'Group '.$g;
                for ($i = 1; $i <= $perGroup; $i++) {
                    $subject = $this->subjectWords();
                    $content = $this->contentWords(50, 100);

                    $faq = new Faq();
                    $faq->group = $groupName;
                    $translation = $faq->translateOrNew('en');
                    $translation->subject = $subject;
                    $translation->content = $content;
                    $faq->save();
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('Seed failed: '.$e->getMessage());
            return 1;
        }

        $this->info('Faqs seeded successfully.');
        return 0;
    }

    private function subjectWords(): string
    {
        $words = [
            'How','to','choose','the','right','yoga','outfit','for','daily','practice',
            'What','materials','keep','you','cool','and','comfortable','during','sessions',
            'Tips','for','maintaining','stretch','and','shape','after','washing',
            'Best','fit','guidelines','for','high','waist','leggings','and','tops',
            'How','to','layer','for','studio','and','outdoor','training',
            'Why','breathable','fabrics','matter','for','active','lifestyles',
            'Sizing','advice','for','a','supportive','yet','flexible','fit',
            'How','to','care','for','performance','fabrics','properly',
            'Choosing','between','lightweight','and','thermal','layers',
            'What','makes','a','good','sports','bra','for','yoga',
        ];

        $count = rand(8, 12);
        $picked = [];
        while (count($picked) < $count) {
            $picked[] = $words[array_rand($words)];
        }

        return implode(' ', $picked);
    }

    private function contentWords(int $min, int $max): string
    {
        $base = [
            'our','yoga','apparel','is','designed','for','comfort','and','support',
            'the','fabric','is','soft','breathable','and','stretchy',
            'choose','a','fit','that','moves','with','your','body',
            'washing','in','cold','water','helps','maintain','shape',
            'air','drying','preserves','elasticity','and','color',
            'layering','allows','better','temperature','control',
            'a','good','sports','bra','offers','stable','support',
            'select','sizes','based','on','your','measurements',
            'quality','stitching','improves','durability','over','time',
            'the','right','materials','help','reduce','irritation',
            'stretch','fabric','returns','to','shape','after','use',
        ];

        $target = rand($min, $max);
        $words = [];
        for ($i = 0; $i < $target; $i++) {
            $words[] = $base[array_rand($base)];
        }

        return ucfirst(implode(' ', $words)).'.';
    }
}
