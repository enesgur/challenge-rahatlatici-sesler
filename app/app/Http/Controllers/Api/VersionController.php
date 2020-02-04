<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Composer\Semver\Semver;
use Composer\Semver\Comparator;

class VersionController extends Controller
{
    /**
     * @var string
     *
     * Current application version
     */
    const App_Version = '3.2.0';

    /**
     * @var string
     *
     * Application min version
     */
    const App_Min_Version = '3.0.0';

    /**
     * @var string
     *
     * Current application language version
     */
    const Language_Version = '4.12.0';

    /**
     * @var string
     *
     * Language min version
     */
    const Language_Min_Version = '4.5.0';

    /**
     * @var string
     *
     * Update types.
     */
    const FORCE_UPDATE = 'force-update';
    const SOFT_UPDATE = 'soft-update';

    public function control(Request $request)
    {
        $pattern = '/^([0-9]+)\.([0-9]+)(?:\.[0-9]+)$/i';
        $validator = Validator::make($request->post(), [
            'appVersion' => 'required|string|regex:' . $pattern,
            'langVersion' => 'required|string|regex:' . $pattern
        ]);

        if ($validator->fails()) {
            return $this->responseError($validator->errors(), 400);
        }

        $appVersion = $request->post('appVersion'); // App version
        $langVersion = $request->post('langVersion'); // Language version

        $appUpdate = ['update' => false, 'type' => null];
        $langUpdate = ['update' => false, 'type' => null];

        // App force update control
        if (Comparator::lessThan($appVersion, self::App_Min_Version)) {
            $appUpdate['update'] = true;
            $appUpdate['type'] = self::FORCE_UPDATE;
        }

        // App soft update control
        if ($appUpdate['update'] === false && Semver::satisfies($appVersion, self::App_Version) == false) {
            $appUpdate['update'] = true;
            $appUpdate['type'] = self::SOFT_UPDATE;
        }

        // Language force update control
        if (Comparator::lessThan($langVersion, self::Language_Min_Version)) {
            $langUpdate['update'] = true;
            $langUpdate['type'] = self::FORCE_UPDATE;
        }

        // Language soft update control
        if ($langUpdate['update'] === false && Semver::satisfies($langVersion, self::Language_Version) == false) {
            $langUpdate['update'] = true;
            $langUpdate['type'] = self::SOFT_UPDATE;
        }

        $return = [
            'app' => [
                'min' => self::App_Min_Version,
                'latest' => self::App_Version,
                'update' => $appUpdate['update'] === false ? false : $appUpdate['type'],
            ],
            'lang' => [
                'min' => self::Language_Min_Version,
                'latest' => self::Language_Version,
                'update' => $langUpdate['update'] === false ? false : $langUpdate['type'],
            ]
        ];

        return $this->responseSuccess($return);
    }
}
