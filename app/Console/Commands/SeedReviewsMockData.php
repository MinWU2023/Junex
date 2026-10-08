<?php

namespace App\Console\Commands;

use App\Modules\User\Models\CustomerReview;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class SeedReviewsMockData extends Command
{
    protected $signature = 'seed:reviews-mock {--count=60 : Total records to create} {--truncate=0 : Whether to truncate customer_reviews before seeding (1/0)}';

    protected $description = 'Seed mock customer reviews for front Reviews page (10 no images, 20 one image, 30 two images), shuffled.';

    public function handle()
    {
        $count = (int)$this->option('count');
        if ($count <= 0) {
            $count = 60;
        }

        $truncate = (int)$this->option('truncate') === 1;

        $img1 = '/front/imgs/reviews-01.png';
        $img2 = '/front/imgs/reviews-02.png';

        $defaultLocale = (string)config('app.locale');
        if ($defaultLocale === '') {
            $defaultLocale = 'en';
        }

        $names = [
            'Grace', 'Richard M', 'Sibille', 'Olivia', 'Noah', 'Liam', 'Emma', 'Sophia', 'Mia', 'Ava',
            'Lucas', 'Ethan', 'James', 'Amelia', 'Harper', 'Evelyn', 'Isabella', 'Charlotte', 'Henry', 'Benjamin',
        ];

        $subjects = [
            'Easy install and great quality.',
            'The viewing experience has improved tenfold!',
            'Happy with our purchase.',
            'Fast shipping, solid packaging.',
            'Super easy to set up and use.',
            'Very satisfied with the service.',
            'Worth the price, would recommend.',
            'Works exactly as described.',
        ];

        $contents = [
            'I bought this to keep an eye on things while traveling. It meets all the listed features and feels well-built.',
            'The picture is crystal clear with amazing viewing angles. Setup took only a few minutes.',
            'Great experience overall. Support was responsive and helpful when I had questions.',
            'Product quality is consistent and delivery was on time. I will order again.',
            'Everything worked smoothly. The instructions were clear and the result is excellent.',
        ];

        // Build target distribution for 60. If custom count, scale roughly but keep at least 0.
        $noImg = (int)round($count * (10 / 60));
        $oneImg = (int)round($count * (20 / 60));
        $twoImg = $count - $noImg - $oneImg;
        if ($twoImg < 0) {
            $twoImg = 0;
        }

        $items = [];
        for ($i = 0; $i < $noImg; $i++) {
            $items[] = ['imgs' => []];
        }
        for ($i = 0; $i < $oneImg; $i++) {
            $items[] = ['imgs' => [($i % 2 === 0) ? $img1 : $img2]];
        }
        for ($i = 0; $i < $twoImg; $i++) {
            $items[] = ['imgs' => [$img1, $img2]];
        }

        shuffle($items);

        DB::beginTransaction();
        try {
            if ($truncate) {
                DB::table('customer_reviews')->truncate();
                if (DB::getSchemaBuilder()->hasTable('customer_review_translations')) {
                    DB::table('customer_review_translations')->truncate();
                }
            }

            $now = date('Y-m-d H:i:s');

            foreach ($items as $idx => $row) {
                $username = $names[$idx % count($names)];
                $subject = $subjects[$idx % count($subjects)];
                $content = $contents[$idx % count($contents)];

                $review = CustomerReview::query()->create([
                    'product' => 'Junex',
                    'email' => 'demo' . ($idx + 1) . '@example.com',
                    'username' => $username,
                    'score' => 5,
                    'imgs' => $row['imgs'],
                    $defaultLocale => [
                        'subject' => $subject,
                        'content' => $content,
                    ],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);

                // Ensure default locale translation exists even if underlying translatable behavior changes
                if (DB::getSchemaBuilder()->hasTable('customer_review_translations')) {
                    DB::table('customer_review_translations')->updateOrInsert(
                        ['customer_review_id' => (int)$review->id, 'locale' => $defaultLocale],
                        ['subject' => $subject, 'content' => $content]
                    );
                }
            }

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error($e->getMessage());
            return 1;
        }

        $this->info('Seeded ' . count($items) . ' mock reviews.');
        $this->info('Done.');
        return 0;
    }
}
