<?php

namespace Database\Seeders;

use App\Models\CampPage;
use App\Models\CampWeek;
use App\Models\HomePage;
use App\Models\Speaker;
use Illuminate\Database\Seeder;

class Summer2027ScheduleSeeder extends Seeder
{
    /**
     * Apply the Summer 2027 camp week schedule and speaker assignments.
     */
    public function run(): void
    {
        $tony = $this->speaker('Tony Shirley');
        $scott = $this->speaker('Scott Pauley');
        $wilkerson = $this->speaker(
            'John Wilkerson',
            'speaker-images/john-wilkerson.jpg',
            'John Wilkerson has been the pastor at First Baptist Church in Hammond, IN since 2013. Prior to that he pastored in Long Beach, CA.',
        );
        $ed = $this->speaker('Ed Loney');
        $tj = $this->speaker('TJ Gardiner');
        $charlie = $this->speaker(
            'Charlie Clark',
            'speaker-images/charlie-clark.jpg',
            'Charlie Clark helped his father pioneer Solid Rock Baptist Church in 1981 and has been full time in the ministry there for over 35 years where he currently serves as the co-pastor.',
        );
        $david = $this->speaker(
            'David Corn',
            'speaker-images/david-corn.jpg',
            'Evangelist David Corn is an Independent Baptist preacher and professional illusionist who uses magic shows to deliver the Gospel message. Traveling full-time under David Corn Ministries based out of Houston, Texas, he partners with local churches to hold community-wide youth rallies, revivals, and outreach events.',
        );
        $abdel = $this->speaker('Abdel Judeh');

        $weeks = [
            [
                'name' => 'Teen Camp 1',
                'slug' => 'teen-camp-1',
                'type_id' => 1,
                'start_date' => '2027-06-07',
                'end_date' => '2027-06-11',
                'speakers' => [$tony->id, $scott->id],
            ],
            [
                'name' => 'Teen Camp 2',
                'slug' => 'teen-camp-2',
                'type_id' => 1,
                'start_date' => '2027-06-14',
                'end_date' => '2027-06-18',
                'speakers' => [$wilkerson->id, $ed->id],
            ],
            [
                'name' => 'Teen Camp 3',
                'slug' => 'teen-camp-3',
                'type_id' => 1,
                'start_date' => '2027-06-21',
                'end_date' => '2027-06-25',
                'speakers' => [$tj->id],
            ],
            [
                'name' => 'Teen Camp 4',
                'slug' => 'teen-camp-4',
                'type_id' => 1,
                'start_date' => '2027-06-28',
                'end_date' => '2027-07-02',
                'speakers' => [$charlie->id],
            ],
            [
                'name' => 'Junior Camp',
                'slug' => 'junior-camp',
                'type_id' => 2,
                'start_date' => '2027-07-12',
                'end_date' => '2027-07-16',
                'speakers' => [$david->id],
            ],
            [
                'name' => 'Combo Camp',
                'slug' => 'combo-camp',
                'type_id' => 3,
                'start_date' => '2027-07-26',
                'end_date' => '2027-07-30',
                'speakers' => [$abdel->id],
            ],
        ];

        $keepIds = [];

        foreach ($weeks as $def) {
            $speakers = $def['speakers'];
            unset($def['speakers']);

            $week = CampWeek::query()
                ->where('slug', $def['slug'])
                ->orWhere('name', $def['name'])
                ->first();

            $payload = array_merge($def, ['status' => 'active']);

            if ($week) {
                $week->update($payload);
            } else {
                $week = CampWeek::query()->create($payload);
            }

            $week->speakers()->sync($speakers);
            $keepIds[] = $week->id;
        }

        CampWeek::query()
            ->whereNotIn('id', $keepIds)
            ->update(['status' => 'hidden']);

        HomePage::query()->update([
            'main_subtitle' => 'Indian Creek 2027',
            'hero_button_text' => 'Explore 2027 Camps',
        ]);

        CampPage::query()->update([
            'hero_season' => 'Summer 2027',
        ]);
    }

    private function speaker(string $name, ?string $image = null, ?string $bio = null): Speaker
    {
        $speaker = Speaker::query()->where('name', $name)->first();

        if ($speaker) {
            $updates = [];

            if ($image) {
                $updates['image'] = $image;
            }

            if ($bio !== null) {
                $updates['bio'] = $bio;
            }

            if ($updates !== []) {
                $speaker->update($updates);
            }

            return $speaker->fresh();
        }

        return Speaker::query()->create([
            'name' => $name,
            'image' => $image ?? 'speaker-images/placeholder.jpg',
            'bio' => $bio ?? '',
        ]);
    }
}
