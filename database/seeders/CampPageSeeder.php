<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CampPage;

class CampPageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CampPage::updateOrCreate(
            ['id' => 1],
            [
                // Hero section
                'hero_season' => 'Summer 2026',
                'hero_title' => 'Summer Camp',
                'hero_subtitle' => 'At ICBC',
                'hero_helper_text' => 'Start your adventure in 5 easy steps.',
                'hero_video' => '/short-video.mp4',
                'hero_poster' => '/background.jpg',

                // Step 3: Register Your Church
                'step_3_title' => 'Step 3:Register Your Church',
                'step_3_content' => '',
                'step_3_faq' => [
                    [
                        'question' => 'Can we change weeks?',
                        'answer' => 'In most cases, no. Our weeks fill up fast. If you need to change weeks, please contact the office as soon as possible.',
                    ],
                    [
                        'question' => 'How many counselors are needed?',
                        'answer' => 'Each church must bring at least one male counselor for the boys (if they are bringing boys) and one female for the girls (if they are bringing girls.) Counselors must stay with the campers all week and will sleep in the cabins.',
                    ],
                ],
                'step_3_info_text' => [
                    ['paragraph' => 'Camp space is limited. We have camps sell out every year.'],
                    ['paragraph' => 'You must fill out a form for your church and send in a (non-refundable) deposit to reserve your church\'s place at camp.'],
                    ['paragraph' => 'Download the form below and mail it (with deposit check) to:'],
                ],
                'step_3_address' => "Indian Creek Baptist Camp\n2214 Bank Street,\nLouisville, KY 40212",
                'step_3_download' => 'https://indiancreek.camp/church-form.pdf',
                'step_3_download_content' => 'Download Registration Form',

                // Step 4: Register Your Campers
                'step_4_title' => 'Step 4:Register Your Campers',
                'step_4_content' => '',
                'step_4_info_text' => 'After you have registered your church group, you can start to register individual campers and counselors. Each camper must have the information filled out by their parent/guardian and you must bring this form and the difference of their camp cost with you when you come to camp.

Download the form below and bring it with you to camp:',
                'step_4_faq' => [
                    [
                        'question' => 'How do you determine a camper\'s grade?',
                        'answer' => 'We go by the grade the camper will be entering next fall. So someone who was in sixth grade in the spring would be considered a seventh grader.',
                    ],
                ],
                'step_4_download' => 'https://indiancreek.camp/Camper-Registration.pdf',
                'step_4_download_content' => 'Download Registration Form',

                // Step 5: Come Ready to Enjoy Camp
                'step_5_title' => 'Step 5: Come Ready to Enjoy Camp',
                'step_5_content' => [],
                'step_5_sections' => [
                    [
                        'title' => 'Get to Camp',
                        'content' => 'Indian Creek is close by, but its still a camp - finding it can be tricky if you don\'t know where you are going. Click the map below or visit this page to get directions.',
                        'link_url' => 'https://maps.app.goo.gl/N6jxLGrDyv1xpXoF6',
                        'link_text' => 'visit this page',
                    ],
                    [
                        'title' => 'Follow the Guidelines',
                        'content' => 'Information about what to bring and how to act can be found at this link:',
                        'link_url' => 'https://indiancreek.camp/coc.pdf',
                        'link_text' => 'Download Code of Conduct',
                    ],
                    [
                        'title' => 'Have a Blast',
                        'content' => 'We want you to come, have fun, and grow closer to Jesus. Start preparing your heart now for an amazing week of camp!',
                        'link_url' => null,
                        'link_text' => null,
                    ],
                ],
                'step_5_background_image' => '/landscape2.jpg',
            ]
        );
    }
}
