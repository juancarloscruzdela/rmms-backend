<?php

namespace Tests\Unit;

use App\Models\Video;
use App\Models\User;
use App\Repositories\VideoRepository;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class VideoTest extends TestCase
{
    /**
     * Check if public profile api is accessible or not.
     *
     * @return void
     */
    public function test_can_access_public_video_api()
    {
        $response = $this->get('/api/videos/view/all');

        $response->assertStatus(200);
    }

    /**
     * Check if video list is private. only user can see his videos.
     *
     * @return void
     */
    public function test_can_not_access_private_video_api()
    {
        $response = $this->get('/api/videos');
        $response->assertStatus(401);
    }

    /**
     * Test if video is creatable.
     *
     * @return void
     */
    public function test_can_create_video()
    {
        // Login the user first.
        Auth::login(User::where('email', 'admin@example.com')->first());
        $videoRepository = new VideoRepository();

        // First count total number of videos
        $totalVideos = Video::get('id')->count();

        $video = $videoRepository->create([
            'title'       => 'Hello',
            'price'       => 100,
            'user_id'     => 1,
            'description' => 'Hello',
        ]);

        $this->assertDatabaseCount('videos', $totalVideos + 1);

        // Delete the video as need to keep it in database for other tests
        $video = Video::where('title', 'Hello')->where('price', 100)->first();
        $video->delete();
    }
}
