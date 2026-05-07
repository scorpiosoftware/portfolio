<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServicesSeeder extends Seeder
{
    public function run(): void
    {
        if (Service::exists()) {
            return;
        }

        $services = [
            [
                'icon'       => '🎨',
                'title'      => 'Portfolio Website',
                'subtitle'   => 'Fast, SEO-friendly personal portfolio',
                'popular'    => false,
                'features'   => [
                    'Responsive one-page or multi-page',
                    'Contact form + Mail setup',
                    'Deploy to your domain',
                ],
                'sort_order' => 1,
            ],
            [
                'icon'       => '🚀',
                'title'      => 'Business Website',
                'subtitle'   => 'Corporate sites, blogs, and landing pages',
                'popular'    => true,
                'features'   => [
                    'Admin panel & CMS',
                    'SSL, backups, analytics',
                    'Performance & SEO optimization',
                ],
                'sort_order' => 2,
            ],
            [
                'icon'       => '🛒',
                'title'      => 'Basic E‑commerce',
                'subtitle'   => 'Full online store',
                'popular'    => false,
                'features'   => [
                    'Admin panel & CMS',
                    'Product management & payments',
                    'Shipping, coupons',
                    'Cash on Delivery',
                ],
                'sort_order' => 3,
            ],
            [
                'icon'       => '💳',
                'title'      => 'Basic POS System',
                'subtitle'   => 'Retail & restaurant solution',
                'popular'    => true,
                'features'   => [
                    'Inventory management',
                    'Barcode scanning',
                    'Receipt printing',
                    'Sales reporting & analytics',
                    'Multi-payment options (cash, card, mobile)',
                    'Customer management',
                    'Tax calculation',
                ],
                'sort_order' => 4,
            ],
            [
                'icon'       => '🍽️',
                'title'      => 'Restaurant POS & Menu Manager',
                'subtitle'   => 'Complete digital menu & order system',
                'popular'    => true,
                'note'       => 'Customizable for cafes, bars & cloud kitchens',
                'features'   => [
                    '📱 Digital Menu Management (Categories, Modifiers, Images)',
                    '🔄 Real-Time Order Sync (Dine-in, Takeaway, Delivery)',
                    '💳 POS Integration (Table Management, Split Bills, Kot Printing)',
                    '🎯 Promotions & Offers (Happy Hour, Combo Deals, Coupons)',
                    '📢 Ads Manager (Push Notifications, Banner Ads, Upsell Suggestions)',
                    '📊 Analytics Dashboard (Top Items, Peak Hours, Customer Trends)',
                    '🌐 QR Code Ordering (Contactless Menu & Payment)',
                ],
                'sort_order' => 5,
            ],
        ];

        foreach ($services as $service) {
            Service::create($service);
        }
    }
}
