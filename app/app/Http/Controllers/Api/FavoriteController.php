<?php

namespace App\Http\Controllers\Api;

use App\Models\Category;
use App\Models\Favorite;
use App\Models\Song;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use \Exception;

class FavoriteController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function songs(Request $request)
    {
        $uid = Auth::user()->id;
        $data = Favorite::songs($uid);
        return $this->responseSuccess($data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function add(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'id' => ['required', 'integer', 'exists:songs,id']
        ]);

        if ($validation->fails()) {
            return $this->responseError(
                'The song id is not valid',
                $validation->errors(),
                self::ERROR_CODE_VALIDATION,
                400);
        }

        // Get user
        $uid = Auth::user()->id;
        $id = $request->post('id');
        // Favorite list control
        $data = Favorite::songs($uid);
        foreach ($data as $row) {
            if ((int)$row['id'] === $id) {
                return $this->responseError(
                    'The song is already in favorite list',
                    null,
                    self::ERROR_CODE_VALIDATION,
                    400);
            }
        }

        try {
            Favorite::add($id, $uid);
        } catch (Exception $e) {
            return $this->responseError(
                'Favorite operation has been failed',
                ['message' => $e->getMessage()],
                self::ERROR_CODE_DB_ERROR,
                500
            );
        }

        return $this->responseSuccess('Favorite add operation has been success');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove($id, Request $request)
    {
        // Get user
        $uid = Auth::user()->id;

        $data = Favorite::songs($uid);
        $exist = false;
        foreach ($data as $row) {
            if ((int)$row['id'] === (int)$id) {
                $exist = true;
                break;
            }
        }

        if ($exist === false) {
            return $this->responseError(
                'The song is not in favorite list',
                null,
                self::ERROR_CODE_VALIDATION,
                400);
        }

        try {
            Favorite::remove($id, $uid);
        } catch (Exception $e) {
            return $this->responseError(
                'Favorite operation has been failed',
                ['message' => $e->getMessage()],
                self::ERROR_CODE_DB_ERROR,
                500
            );
        }

        return $this->responseSuccess('Favorite remove operation has been success');
    }
}
