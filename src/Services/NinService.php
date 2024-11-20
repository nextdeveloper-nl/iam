<?php

namespace NextDeveloper\IAM\Services;

use Carbon\Carbon;
use NextDeveloper\Commons\Database\Models\Countries;
use NextDeveloper\IAAS\Database\Models\Accounts;
use NextDeveloper\IAM\Database\Models\Users;
use NextDeveloper\IAM\Database\Scopes\AuthorizationScope;
use NextDeveloper\IAM\Helpers\UserHelper;

/**
 * Class NinService
 *
 * This service class is responsible for verifying the National Identification Number (NIN)
 * for both citizens and foreign individuals. It uses locale-specific services to perform
 * the verification and updates the user's information upon successful verification.
 *
 * @package NextDeveloper\IAM\Services
 */
class NinService
{
    /**
     * Verifies the National Identification Number (NIN) for a citizen or foreign individual.
     *
     * @param array $data The data required for NIN verification. Expected keys are:
     *                    - 'name': string, the name of the individual
     *                    - 'surname': string, the surname of the individual
     *                    - 'nin': string, the National Identification Number
     *                    - 'year': int, the birth year of the individual
     *                    - 'month': int, the birth month of the individual (only for foreign individuals)
     *                    - 'day': int, the birthday of the individual (only for foreign individuals)
     * @param bool $isCitizen Indicates whether the NIN belongs to a citizen (true) or a foreign individual (false).
     * @param string $locale The locale for the service, default is 'tr'.
     *
     * @return bool True if the NIN is verified, false otherwise.
     *
     * @throws \Exception If the locale service is not found.
     */
    public static function verify(array $data, bool $isCitizen = true, string $locale = 'tr'): bool
    {
        // Determine the class to use for the specified locale
        $class = match ($locale) {
            default => config("iam.nin.{$locale}.class"),
        };

        // Throw an exception if the class is not found
        if (!$class) {
            throw new \Exception("NIN service for locale '{$locale}' not found.");
        }

        // Instantiate the service class with the provided data and locale
        $service = new $class($data, $locale);

        // Perform the NIN verification
        $verify = $service->verify($isCitizen);

        // If verification is successful, update the user's information
        if ($verify) {
            // Format the birthday day and month if not exists set to 01 and 01
            if (!$isCitizen) {
                $birthday = $data['year'] . '-' . $data['month'] . '-' . $data['day'];
            } else {
                $birthday = $data['year'] . '-01-01';
            }

            // Retrieve the current user and update their information
            $user = Users::where('nin', $data['nin'])->first();
            $user->name = $data['name'];
            $user->surname = $data['surname'];
            $user->nin = $data['nin'];
            $user->birthday = $birthday;
            $user->is_nin_verified = true;

            // Save the updated user information
            $user->save();
        }

        // Return the result of the verification
        return $verify;
    }

    public static function verifyUser(Users $user)
    {
        $countries = Countries::withoutGlobalScope(AuthorizationScope::class)
            ->where('id', $user->common_country_id)
            ->first();

        $locale = $countries->locale;
        $locale = strtolower($locale);

        // Determine the class to use for the specified locale
        $class = match ($locale) {
            default => config("iam.nin.{$locale}.class"),
        };

        // Throw an exception if the class is not found
        if (!$class) {
            throw new \Exception("NIN service for locale '{$locale}' not found.");
        }

        $birthday = Carbon::parse($user->birthday);

        // Instantiate the service class with the provided data and locale
        $service = new $class([
            'name' => $user->name,
            'surname' => $user->surname,
            'nin' => $user->nin,
            'day' => $birthday->day,
            'month' => $birthday->month,
            'year' => $birthday->year
        ], $countries->locale);

        $isCitizen = $countries->locale == 'TR' ? true : false;

        // Perform the NIN verification
        $verify = $service->verify($isCitizen);

        if($verify) {
            $user->update([
                'is_nin_verified'       =>  true,
                'is_profile_verified'   =>  true
            ]);

            $account = Accounts::where('iam_account_id', UserHelper::currentAccount()->id)
                ->first();

            //  We are enabling the account only if the user is
            if(UserHelper::me()->id == UserHelper::currentAccount()->iam_user_id) {
                if(!$account) {
                    $account = Accounts::createQuietly([
                        'iam_account_id'        =>  UserHelper::currentAccount()->id,
                        'is_service_enabled'    =>  true
                    ]);
                }

                $account->updateQuietly([
                    'is_service_enabled'    =>  true
                ]);
            }
        }

        return $verify;
    }
}
