<?php

use App\Modules\Setting\Models\SectionTitle;
use App\Modules\Setting\Models\WhyChooseSetting;
use App\Services\SectionTitleService;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSectionFieldsFromWhyChooseSettings extends Migration
{
    public function up()
    {
        if (!Schema::hasTable('why_choose_setting_translations')) {
            return;
        }

        // Move existing section title/description into section_titles before dropping columns
        try {
            if (Schema::hasTable('section_titles') && Schema::hasTable('section_title_translations')) {
                app(SectionTitleService::class)->seedDefaults();

                $setting = WhyChooseSetting::query()->with(['translations'])->orderBy('id')->first();
                $section = SectionTitle::query()->where('sign', 'why_choose')->first();
                if ($setting && $section && Schema::hasColumn('why_choose_setting_translations', 'section_title')) {
                    foreach ($setting->translations as $tr) {
                        $locale = (string)$tr->locale;
                        $title = trim((string)($tr->section_title ?? ''));
                        $subtitle = trim((string)($tr->section_description ?? ''));
                        if ($title === '' && $subtitle === '') {
                            continue;
                        }
                        $payload = [];
                        if ($title !== '') {
                            $payload['title'] = $title;
                        }
                        if ($subtitle !== '') {
                            $payload['subtitle'] = $subtitle;
                        }
                        if (!empty($payload)) {
                            $section->fill([$locale => $payload]);
                        }
                    }
                    $section->save();
                }
            }
        } catch (\Throwable $e) {
            // continue dropping columns
        }

        Schema::table('why_choose_setting_translations', function (Blueprint $table) {
            if (Schema::hasColumn('why_choose_setting_translations', 'section_title')) {
                $table->dropColumn('section_title');
            }
            if (Schema::hasColumn('why_choose_setting_translations', 'section_description')) {
                $table->dropColumn('section_description');
            }
        });
    }

    public function down()
    {
        if (!Schema::hasTable('why_choose_setting_translations')) {
            return;
        }

        Schema::table('why_choose_setting_translations', function (Blueprint $table) {
            if (!Schema::hasColumn('why_choose_setting_translations', 'section_title')) {
                $table->string('section_title')->nullable()->after('locale');
            }
            if (!Schema::hasColumn('why_choose_setting_translations', 'section_description')) {
                $table->text('section_description')->nullable()->after('section_title');
            }
        });
    }
}
