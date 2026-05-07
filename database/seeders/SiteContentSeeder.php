<?php

namespace Database\Seeders;

use App\Models\SiteContent;
use Illuminate\Database\Seeder;

class SiteContentSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            // Branding
            ['key' => 'brand_name',    'label' => 'Brand Name', 'section' => 'branding', 'type' => 'text',     'value' => 'Scorpio Software'],
            ['key' => 'brand_tagline', 'label' => 'Tagline',    'section' => 'branding', 'type' => 'text',     'value' => 'Software Development • Software Engineer'],

            // Hero
            ['key' => 'hero_badge',         'label' => 'Status Badge',              'section' => 'hero', 'type' => 'text',     'value' => 'Available for new projects'],
            ['key' => 'hero_headline',       'label' => 'Main Headline',             'section' => 'hero', 'type' => 'textarea', 'value' => 'I build fast, maintainable web apps & e‑commerce systems'],
            ['key' => 'hero_description',    'label' => 'Description',               'section' => 'hero', 'type' => 'textarea', 'value' => 'I design and develop portfolio sites, business websites, e‑commerce stores and full POS systems. I also provide hosting, domain setup and continuous support.'],
            ['key' => 'hero_stat_years',     'label' => 'Stat — Years',              'section' => 'hero', 'type' => 'text',     'value' => '6+'],
            ['key' => 'hero_stat_projects',  'label' => 'Stat — Projects',           'section' => 'hero', 'type' => 'text',     'value' => '30+'],
            ['key' => 'hero_stat_clients',   'label' => 'Stat — Clients',            'section' => 'hero', 'type' => 'text',     'value' => '20+'],
            ['key' => 'hero_stat_support',   'label' => 'Stat — Support',            'section' => 'hero', 'type' => 'text',     'value' => '24/7'],
            ['key' => 'hero_featured_title', 'label' => 'Featured Card Title',       'section' => 'hero', 'type' => 'text',     'value' => 'Featured Project'],
            ['key' => 'hero_featured_desc',  'label' => 'Featured Card Description', 'section' => 'hero', 'type' => 'textarea', 'value' => 'E-commerce websites built from scratch & complete POS systems tailored for small to medium businesses.'],

            // Services
            ['key' => 'services_subtitle',     'label' => 'Section Subtitle',    'section' => 'services', 'type' => 'text',     'value' => 'What I Offer'],
            ['key' => 'services_title',        'label' => 'Section Title',       'section' => 'services', 'type' => 'text',     'value' => 'Services'],
            ['key' => 'services_description',  'label' => 'Section Description', 'section' => 'services', 'type' => 'textarea', 'value' => 'I offer end-to-end services: planning, development, deployment, hosting, domain management and ongoing maintenance.'],

            // Contact
            ['key' => 'contact_email',    'label' => 'Email',                'section' => 'contact', 'type' => 'text',     'value' => 'info@scorpiosoft.tech'],
            ['key' => 'contact_phone',    'label' => 'Phone',                'section' => 'contact', 'type' => 'text',     'value' => '+961-71-036488'],
            ['key' => 'contact_hours',    'label' => 'Working Hours',        'section' => 'contact', 'type' => 'text',     'value' => '9:00 — 18:00 (GMT+3)'],
            ['key' => 'contact_location', 'label' => 'Location Description', 'section' => 'contact', 'type' => 'textarea', 'value' => 'Based in Beirut, Lebanon — available for remote or local projects.'],
        ];

        foreach ($items as $item) {
            SiteContent::firstOrCreate(['key' => $item['key']], $item);
        }
    }
}
