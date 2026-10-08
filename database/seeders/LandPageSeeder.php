<?php

namespace Database\Seeders;

use App\Modules\Setting\Models\LandPage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class LandPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $d1 = LandPage::query()->where('area_name','01')->first();
        if (!$d1){
            $this->d1();
        }
        $d2 = LandPage::query()->where('area_name','02')->first();
        if (!$d2){
            $this->d2();
        }
    }



    public function d1()
    {
        $landPage =  new LandPage();
        $landPage->name = 'test1';
        $landPage->area_name = '01';

        $landPage->title = 'title1';
        $landPage->keywords = 'keywords1';
        $landPage->description = 'description1';
        $landPage->url_key = Str::slug('d1');
        $landPage->plate_content_1 = [
            'names' => [
                'Steel Coil Manufacturer',
                'FREE SAMPLE',
                'When tomorrow turns in today, yesterday, and someday that no more important in',
                'When tomorrow turns in today, yesterday, and someday that no more important in',
            ],
            'imgs' => [
                'pages/01/images/banner.jpg',
            ],
        ];
        $landPage->plate_content_2 = [
            'names' => [
                'EmpoWering you to succeed online',
                "When tomorrow turns in today, yesterday, and someday that no more important in your memory, we suddenly realize that we are pushed forward by time.This is not a train in still in which you may feel forward when another train goes by.It is the truth that we've all grown up.And we become different. When tomorrow turns in today, yesterday, and someday that no more important in your memory, we suddenly realize that we are pushed forward by time.This is not a train in still in which you may feel forward when another train goes by.It is the truth that we've all grown up.And we become different.",
                'Prepainted Galvanized Steel Coil',
                'Product Name: PPGI steel coil width: 750mm/1000mm/1200mm/1250mm*C',
                'Prepainted Galvanized Steel Coil',
                'Product Name: PPGI steel coil width: 750mm/1000mm/1200mm/1250mm*C',
                'Prepainted Galvanized Steel Coil',
                'Product Name: PPGI steel coil width: 750mm/1000mm/1200mm/1250mm*C',
                'Prepainted Galvanized Steel Coil',
                'Product Name: PPGI steel coil width: 750mm/1000mm/1200mm/1250mm*C',
            ],
            'imgs' => [
                'pages/01/images/pro_img1.jpg',
                'pages/01/images/pro_img2.jpg',
                'pages/01/images/pro_img3.jpg',
                'pages/01/images/pro_img4.jpg',
            ],
            'urls' => [
                'url-2-1',
                'url-2-2',
                'url-2-3',
                'url-2-4',
            ],
        ];
        $landPage->plate_content_3 = [
            'names' => [
                'Industries We Proudly Serve',
                "When tomorrow turns in today, yesterday, and someday that no more important in your memory, we suddenly realize that we are pushed forward by time.This is not a train in still in which you may feel forward when another train goes by.It is the truth that we've all grown up.And we become different.",
                'Blanking/ Shearing',
                'Blanking/ Shearing',
                'Blanking/ Shearing',
                'Blanking/ Shearing',
                'Blanking/ Shearing',
                'Blanking/ Shearing',
            ],
            'imgs' => [
                'pages/01/images/app_img1.jpg',
                'pages/01/images/app_img2.jpg',
                'pages/01/images/app_img3.jpg',
                'pages/01/images/app_img4.jpg',
                'pages/01/images/app_img5.jpg',
                'pages/01/images/app_img6.jpg',
            ],
            'urls' => [
                'url-3-1',
                'url-3-2',
                'url-3-3',
                'url-3-4',
                'url-3-5',
                'url-3-6',
            ],
        ];
        $landPage->plate_content_4 = [
            'names' => [
                'SUCCESS STORIES',
                "When tomorrow turns in today, yesterday, and someday that no more important in your memory, we suddenly realize that we are pushed forward by time.This is not a train in still in which you may feel forward when another train goes by.It is the truth that we've all grown up.And we become different.",
                'Working with Structural Stainless Steel',
                'Structural stainless steel was first used for larger applications in the United States in the mid 1960’s.',
                'Working with Structural Stainless Steel',
                'Structural stainless steel was first used for larger applications in the United States in the mid 1960’s.',
                'Working with Structural Stainless Steel',
                'Structural stainless steel was first used for larger applications in the United States in the mid 1960’s.',
                'Working with Structural Stainless Steel',
                'Structural stainless steel was first used for larger applications in the United States in the mid 1960’s.',
            ],
            'imgs' => [
                'pages/01/images/Stories_img1.jpg',
                'pages/01/images/Stories_img2.jpg',
                'pages/01/images/Stories_img3.jpg',
                'pages/01/images/Stories_img4.jpg',
            ],
            'urls' => [
                'url-3-1',
                'url-3-2',
                'url-3-3',
                'url-3-4',
            ],
        ];
        $landPage->plate_content_5 = [
            'names' => [
                'FREE SAMPLE',
                'We now have established machine installations with equipment that meet and exceed industry standards',
                'FREE SAMPLE',
                'FREE SAMPLE',
                'If you are interested in our products and want to know more details,please leave a message here,we will reply you as soon as we can.',
            ],
            'urls' => [
                'url-3-1',
            ],
        ];
        $landPage->plate_content_6 = [
            'names' => [
                'Cooperation Process',
                "When tomorrow turns in today, yesterday, and someday that no more important in your memory, we suddenly realize that we are pushed forward by time.This is not a train in still in which you may feel forward when another train goes by.It is the truth that we've all grown up.And we become different.",

                'Research',
                'Tell us your needs, let us understand your needs as comprehensively as possible.',

                'Idea & Concept',
                'Tell us your needs, let us understand your needs as comprehensively as possible.',

                'Sample Production',
                'According to your needs, provide a complete set of procurement recommendations for your reference.',

                'Sales & Support',
                'Tell us your needs, let us understand your needs as comprehensively as possible.',

                'Negotiation',
                'Tell us your needs, let us understand your needs as comprehensively as possible.',

                'Purchase',
                'Produce samples according to your needs and confirm that all details meet your requirements.',

                'Bulk Production',
                'Tell us your needs, let us understand your needs as comprehensively as possible.',

                'Delivery',
                'Officially started mass production and strictly enforced contract quality and delivery time.',
            ],
        ];
        $landPage->plate_content_7 = [
            'names' => [
                'Cooperation Process',
                "When tomorrow turns in today, yesterday, and someday that no more important in your memory, we suddenly realize that we are pushed forward by time.This is not a train in still in which you may feel forward when another train goes by.It is the truth that we've all grown up.And we become different.",
                'Business Scope',
                'Processing, manufacturing and sales of stainless coil/sheet, stainless pipe,galvanized coil, PPGI, roofing sheet, section steels, etc..',
                'Strict management',
                'Committed to meeting the requirements of its quality management system and taking practical steps to improve the system',
                'High quality',
                'A full set of steel solutions that can provide source, supply and service concepts, the foundation of our business foundation is still based on quality',
                'Our strength',
                'We focus on R&D activities to maintain our best position in the industry, with advanced professional knowledge and technical expertise',
            ],
        ];
        $landPage->plate_content_8 = [
            'names' => [
                'What you need to know',
                "When tomorrow turns in today, yesterday, and someday that no more important in your memory, we suddenly realize that we are pushed forward by time.This is not a train in still in which you may feel forward when another train goes by.It is the truth that we've all grown up.And we become different.",

                'Filling adopts servo motor,with the advantages of accurate positioning, high',
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
                'Risus commodo viverra maecenas accumsan lacus vel facilisis.',
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
                'Stirring uses Taiwan geared motor: low noise, long life, and lifetime',
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
                'Stirring uses Taiwan geared motor: low noise, long life, and lifetime',
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
                'Filling adopts servo motor,with the advantages of accurate positioning, high',
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
                'Risus commodo viverra maecenas accumsan lacus vel facilisis.',
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
                'Risus commodo viverra maecenas accumsan lacus vel facilisis.',
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
                'Risus commodo viverra maecenas accumsan lacus vel facilisis.',
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua',
            ],
        ];
        $landPage->plate_content_9 = [
            'names' => [
                'your complete solution for business online',
                "When tomorrow turns in today, yesterday, and someday that no more important in your memory, we suddenly realize that we are pushed forward by time.This is not a train in still in which you may feel forward when another train goes by.It is the truth that we've all grown up.And we become different.",
                'Copyright © 2017 EEKOO ELECTRONICS CO., LTD All Rights Reserved. Powered by',
            ],
            'contents' => [
                '<p>Copyright © 2017 EEKOO ELECTRONICS CO., LTD All Rights Reserved. Powered by <a href="http://www.dyyseo.com/">dyyseo.com</a></p>'
            ],
        ];
        $landPage->save();
    }

    public function d2(){
        $landPage =  new LandPage();
        $landPage->name = 'Wholesale Yoga Mats,Custom Printed Yoga Mats,Cork Yoga Mat Supplier';
        $landPage->area_name = '02';
        $landPage->title = 'Wholesale Yoga Mats,Custom Printed Yoga Mats,Cork Yoga Mat Supplier';
        $landPage->keywords = 'Eco Friendly Yoga Mat,Natural Rubber Yoga Mats,Yoga Mats Supplier';
        $landPage->description = 'Secondpage is a professional yoga mats manufacturers and suppliers. We design and print custom yoga mats as well. Durable,comfortable and excellent performance. Get in touch today.';
        $landPage->url_key = 'd2';
        $plate_content_1 =  [
            'names' => [
                'Home',
                'FIRST PAGE YOGA',
                'Yoga Mats',
                'PU Yoga Mat',
                'PU Yoga Mat',

                'Yoga Accessories',

                'Yoga Blocks',
                'Yoga Wear',
                'Yoga Mat',
                'Yoga Mat',
                'Yoga Mat',
                'Yoga Mat',
                'Yoga Mat',
                'Yoga Mat',
                'Yoga Mat',

                'Yoga Mat',
                'Yoga Mat',
                'Yoga Mat',
                'Yoga Mat',

                'Yoga Mat',
                'Yoga Mat',
                'Yoga Mat',
                'Yoga Mat',

                'PRODUCTS',
                'VIDEOS',
                'CONTACT US',
            ],
            'imgs' => [
                'pages/02/images/logo.jpeg',
            ],
        ];
        for ($i=1;$i<=26;$i++){
            if ($i==1){
                $plate_content_1['urls'][] = 'https://cloud.first-page.cn';
                continue;
            }

            if ($i==2){
                $plate_content_1['urls'][] = 'https://cloud.first-page.cn/about-us';
                continue;
            }

            if ($i==3){
                $plate_content_1['urls'][] = 'https://cloud.first-page.cn/products';
                continue;
            }


            if ($i==4){
                $plate_content_1['urls'][] = 'https://cloud.first-page.cn/self-service-cash-register';
                continue;
            }


            if ($i==5){
                $plate_content_1['urls'][] = 'https://cloud.first-page.cn/pos-with-keyboard';
                continue;
            }




            if ($i==24){
                $plate_content_1['urls'][] = 'https://cloud.first-page.cn/products';
                continue;
            }

            if ($i==25){
                $plate_content_1['urls'][] = 'https://cloud.first-page.cn/support';
                continue;
            }

            if ($i==26){
                $plate_content_1['urls'][] = 'https://cloud.first-page.cn/contact-us';
                continue;
            }

            $plate_content_1['urls'][] = 'https://cloud.first-page.cn/pos-with-keyboard';
        }
        $landPage->plate_content_1 = $plate_content_1;

        $landPage->plate_content_2 = [
            'images'  => [
                "首页轮播图" => [
                    [
                        'is_main' =>1,
                        'sort' =>22,
                        'alt' =>'yoga mats',
                        'path' =>'pages/02/images/banner1.jpeg',
                    ],
                    [
                        'is_main' =>0,
                        'sort' =>22,
                        'alt' =>'yoga mats supplier',
                        'path' =>'pages/02/images/banner2.jpeg',
                    ],
                ],
            ],

            'urls' => [
                'https://cloud.first-page.cn',
                'https://cloud.first-page.cn/about-us',
                'https://cloud.first-page.cn',
                'https://cloud.first-page.cn',
                'https://cloud.first-page.cn',
            ],
        ];
        $plate_content_3 = [
            'names' => [
                'Firstpagetech specialized in OEM PU/cork/suede yoga mats,yoga blocks,yoga wear,yoga accessories etc.',
                'Welcome to our website,We are one of the biggest natural rubber yoga mat company in Eastern China. The main products are Suede yoga mats,Pu yoga mats,Cork yoga mats and so on.  OEM service are also welcome. Samples are supported.  Natural rubber yoga mats are eco-friendly, anti slip, absorbent, durable, elastic, soft, comfortable and tear resistance, and are good for body exercise.',
            ],
        ];
        for ($i=1;$i<=8;$i++){
            $images = [];
            for ($j=1;$j<=2;$j++){
                if ($i==5 && $j==2){
                    continue;
                }
                $images[] = [
                    'is_main' =>1,
                    'sort' =>22,
                    'alt' =>'aaa',
                    'path' =>'pages/02/images/p3_'.$i.'_'.$j.'.jpeg',
                ];
            }

            $plate_content_3['images']['产品'.$i] = $images;
            $plate_content_3['names'][] = 'Anti Slip Natural Rubber Pu Leather Eco Friendly Yoga Mat';
        }
        $landPage->plate_content_3 = $plate_content_3;
        $landPage->plate_content_4 = [
            'names' => [
                'Want to see the details of our yoga mats? Download the catalog!',
                "Please leave your Email and download.",
            ],
            'urls' => [
                'https://cloud.first-page.cn/products',
            ],
        ];
        $landPage->plate_content_5 = [
            'names' => [
                'leave a message',
                'leave a message',
                'If you are interested in our products and want to know more details,please leave a message here,we will reply you as soon as we can.',
            ],
        ];
        $landPage->plate_content_6 = [
            'names' => [
                'FIRST PAGE YOGA — Your Yoga One-stop Supplier',
                "First page Tech Co., Ltd. was founded in 2001, with an area of more than 8000 square meters.",
                'It is a yoga one-stop factory integrating development, design, production and sales in East China.',


                'Customization:It is a yoga one-stop factory integrating development, design, production and sales in East China.',
                'We have served a lot of OEM clients for their own brands all over the world.',
                'Price - more competitive under the same quality level',

                'Get A Free Quote'
            ],
            'imgs' => [
                'pages/02/images/b6_1.png',
                'pages/02/images/b6_2.png',
                'pages/02/images/b6_3.png',
                'pages/02/images/b6_4.png',
                'pages/02/images/b6_5.png',
            ],
        ];
        $landPage->plate_content_7 = [
            'names' => [
                "It's just simple with FIRST PAGE one stop OEM solution.",
                'Custom Seamless Yoga Wear',
                'Custom Seamless Yoga Wear',
                'Custom Seamless Yoga Wear',
                'Custom Seamless Yoga Wear',
            ],
            'imgs' => [
                'pages/02/images/p7_1.jpeg',
                'pages/02/images/p7_2.jpeg',
                'pages/02/images/p7_3.jpeg',
                'pages/02/images/p7_4.jpeg',
            ],
        ];
        $landPage->plate_content_8 = [
            'names' => [
                'FIRST PAGE YOGA In The World',
            ],
            'imgs' => [
                'pages/02/images/map.jpg',
            ],
            'contents' => [
                " <p>Small quantity? No worries.

                    We have different distributors all over the world.

                    We can provide distributors for you.

                    You can buy near.</p>
                <p><span>Contact us NOW!!</span></p>"
            ]
        ];
        $landPage->plate_content_9 = [
            'names' => [
                'WHY CHOOSE US',
                'First page Tech Co., Ltd. was founded in 2001, with an area of more than 8000 square meters. It is a yoga one-stop factory integrating development, design, production and sales in East China. It owns a natural rubber yoga mat factory, TPE / NBR / PVC plastic material factory, yoga towel and wear factory, yoga accessories factory etc. Our factory production capacity can meet the demand of 100000 pcs per month. We have a professional design team, high-quality sales team and SGS REACH certified high-quality yoga products. We have served a lot of OEM clients for their own brands all over the world.',
                '25years',
                'Established in 1995',
                '130+',
                'Company employees',
                '120000',
                'm',
                '2',
                'Yoga mats',
            ]
        ];
        $plate_content_10 =  [];
        for ($i=1;$i<=6;$i++){
            $plate_content_10['imgs'][] = 'pages/02/images/p10_'.$i.'.jpeg';
            $plate_content_10['names'][] ='Automatic Production';
            $plate_content_10['contents'][] = '<p>Our highly-automatic machines and standardized in-house production ensures a short lead time & consistent quality, no matter how large or small your project is.</p>';
        }
        $plate_content_10['imgs'][] = 'pages/02/images/right-wx.png';
        $plate_content_10['contents'][] = '<div class="certifiction_con">
            <div class="i_title">
                <div class="h4">CERTIFICATION</div>
                <p>Quality control is strictly carried out in the whole production procedure. Our certified system are the guarantee of our quality products. Download and check the certifications of our casters.</p>
            </div>
            <p class="certifiction_more"><a href="#">View MoreMedical Casters Certificates ></a></p>
        </div>
        <div class="certifiction_footer">

            <div class="certifiction_footer_left">
                <p>Move your Business Forward with LFC Casters!</p>
                <p>See how we can provide your premium solutions and machines on-time and on-budget.</p>
            </div>
            <div class="certifiction_footer_right">
                <p class="certifiction_more"><a href="#pro_inq_c">VGet Free Quotes Now</a></p>
            </div>
        </div>';
        $plate_content_10['names'][] ='+86-18056885201';
        $plate_content_10['names'][] = 'ceshi@firstpage.com';
        $plate_content_10['names'][] = '+86-595-881110221';
        $plate_content_10['names'][] = 'firstpage';
        $landPage->plate_content_10 = $plate_content_10;
        $landPage->save();
    }
}
