<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Helpers\UploadHelper;
use App\Interfaces\CrudInterface;
use App\Models\Video;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class VideoRepository implements CrudInterface
{
    /**
     * Authenticated User Instance.
     *
     * @var User
     */
    public User | null $user;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->user = Auth::guard()->user();
    }

    /**
     * Get All Videos.
     *
     * @return collections Array of Video Collection
     */
    public function getAll(): Paginator
    {
        return $this->user->videos()
            ->orderBy('id', 'desc')
            ->with('user')
            ->paginate(10);
    }

    /**
     * Get Paginated Video Data.
     *
     * @param int $pageNo
     * @return collections Array of Video Collection
     */
    public function getPaginatedData($perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 12;
        return Video::orderBy('id', 'desc')
            ->with('user')
            ->paginate($perPage);
    }

    /**
     * Get Searchable Video Data with Pagination.
     *
     * @param int $pageNo
     * @return collections Array of Video Collection
     */
    public function searchVideo($keyword, $perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 10;

        return Video::where('title', 'like', '%' . $keyword . '%')
            ->orWhere('description', 'like', '%' . $keyword . '%')
            ->orWhere('price', 'like', '%' . $keyword . '%')
            ->orderBy('id', 'desc')
            ->with('user')
            ->paginate($perPage);
    }

    /**
     * Create New Video.
     *
     * @param array $data
     * @return object Video Object
     */
    public function create(array $data): Video
    {
        $titleShort      = Str::slug(substr($data['title'], 0, 20));
        $data['user_id'] = $this->user->id;

        if (!empty($data['file'])) {
            $data['file'] = UploadHelper::upload('file', $data['file'], $titleShort . '-' . time(), 'files/videos');
        }

        return Video::create($data);
    }

    /**
     * Delete Video.
     *
     * @param int $id
     * @return boolean true if deleted otherwise false
     */
    public function delete(int $id): bool
    {
        $video = Video::find($id);
        if (empty($video)) {
            return false;
        }

        UploadHelper::deleteFile('files/videos/' . $video->file);
        $video->delete($video);
        return true;
    }

    /**
     * Get Video Detail By ID.
     *
     * @param int $id
     * @return void
     */
    public function getByID(int $id): Video|null
    {
        return Video::with('user')->find($id);
    }

    /**
     * Update Video By ID.
     *
     * @param int $id
     * @param array $data
     * @return object Updated Video Object
     */
    public function update(int $id, array $data): Video|null
    {
        $video = Video::find($id);
        if (!empty($data['file'])) {
            $titleShort = Str::slug(substr($data['title'], 0, 20));
            $data['file'] = UploadHelper::update('file', $data['file'], $titleShort . '-' . time(), 'files/videos', $video->file);
        } else {
            $data['file'] = $video->file;
        }

        if (is_null($video)) {
            return null;
        }

        // If everything is OK, then update.
        $video->update($data);

        // Finally return the updated video.
        return $this->getByID($video->id);
    }
}
