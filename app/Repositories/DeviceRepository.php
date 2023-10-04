<?php

namespace App\Repositories;

use Illuminate\Support\Str;
use App\Helpers\UploadHelper;
use App\Interfaces\CrudInterface;
use App\Models\Device;
use App\Models\User;
use Illuminate\Contracts\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class DeviceRepository implements CrudInterface
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
     * Get All Devices.
     *
     * @return collections Array of Device Collection
     */
    public function getAll(): Paginator
    {
        return $this->user->devices()
            ->orderBy('updated_at', 'desc')
            ->paginate(50);
    }

    /**
     * Get Paginated Device Data.
     *
     * @param int $pageNo
     * @return collections Array of Device Collection
     */
    public function getPaginatedData($perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 50;
        return Device::orderBy('updated_at', 'desc')
            ->paginate($perPage);
    }

    /**
     * Get Searchable Device Data with Pagination.
     *
     * @param int $pageNo
     * @return collections Array of Device Collection
     */
    public function searchDevice($keyword, $perPage): Paginator
    {
        $perPage = isset($perPage) ? intval($perPage) : 10;

        return Device::where('ip', 'like', '%' . $keyword . '%')
            ->orderBy('id', 'desc')
            ->paginate($perPage);
    }

    /**
     * Create New Device.
     *
     * @param array $data
     * @return object Device Object
     */
    public function create(array $data): Device
    {
        $ipShort      = Str::slug(substr($data['ip'], 0, 20));
        $data['user_id'] = $this->user->id;

        return Device::create($data);
    }

    /**
     * Delete Device.
     *
     * @param int $id
     * @return boolean true if deleted otherwise false
     */
    public function delete(int $id): bool
    {
        $device = Device::find($id);
        if (empty($device)) {
            return false;
        }

        UploadHelper::deleteFile('files/devices/' . $device->file);
        $device->delete($device);
        return true;
    }

    /**
     * Get Device Detail By ID.
     *
     * @param int $id
     * @return void
     */
    public function getByID(int $id): Device|null
    {
        return Device::with('user')->find($id);
    }

    /**
     * Update Device By ID.
     *
     * @param int $id
     * @param array $data
     * @return object Updated Device Object
     */
    public function update(int $id, array $data): Device|null
    {
        $device = Device::find($id);

        $ipShort = Str::slug(substr($data['ip'], 0, 20));

        if (is_null($device)) {
            return null;
        }

        // If everything is OK, then update.
        $device->update($data);

        // Finally return the updated device.
        return $this->getByID($device->id);
    }
}
