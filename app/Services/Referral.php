<?php

namespace App\Services;

use App\Models\ClientPreference;
use App\Models\Order;
use App\Models\User;
use App\Models\UserRefferal;
use Illuminate\Support\Facades\Log;

final class Referral
{
    protected UserRefferal $referral;

    /**
     * Creates a new referral instance if an array is provided, else uses the provided model
     *
     * @param \App\Models\UserReferral|array $userRefferal
     */
    public function __construct($userRefferal = null)
    {
        if (is_array($userRefferal) && !is_null($referralCode = $userRefferal['reffered_by'] ?? null)) {
            $userRefferal['reffered_by'] = optional(UserRefferal::where('refferal_code', $referralCode)->first(['id']))
                ->id;
        }

        $this->referral = is_array($userRefferal)
            ? UserRefferal::create($userRefferal)
            : $userRefferal;

        assert($this->referral instanceof UserRefferal);
    }

    public static function find($refferalCode, array $columns = ['*'], array $with = []): ?self
    {
        $model = (new UserRefferal())->select($columns ?: ['*'])->with($with);

        $model = is_integer($refferalCode)
            ? $model->where('id', $refferalCode)->first()
            : $model->where('refferal_code', $refferalCode)->first();

        if (! is_null($model)) {
            return new static($model);
        }

        return null;
    }

    public function getReferral()
    {
        return $this->referral;
    }

    public function redeem(?int $userId = null)
    {
        $wallet             = optional($refferer = $this->referral->referrer)->wallet;
        $hasCompletedOrders = Order::whereHas('vendors', fn ($q) => $q->where('order_status_option_id', 6))
            ->whereRaw('NOT EXISTS (SELECT id FROM order_return_requests WHERE order_return_requests.order_id = orders.id)')
            ->where('user_id', optional($refferer)->id)
            ->exists();

        if (is_null($wallet)) {
            Log::critical("no wallet found for referrer of referral code: {$this->referral->refferal_code}");
        }

        if (is_null($wallet) || !$hasCompletedOrders) {
            return false;
        }

        [
            'reffered_by_amount' => $reffered_by_amount,
            'reffered_to_amount' => $reffered_to_amount,
        ] = ClientPreference::first(['reffered_by_amount', 'reffered_to_amount'])->attributesToArray();

        if (is_null($reffered_by_amount) || is_null($reffered_to_amount)) {
            return false;
        }

        $users = User::with('wallet')->whereHas(
            'referral',
            fn ($q) => $q->where('reffered_by', $this->referral->id)->where('redeemed', false)
        );

        if (!is_null($userId)) {
            $users->where('id', $userId);
        }

        $users->get()->each(function (User $user) use ($wallet, $reffered_by_amount, $reffered_to_amount, $refferer) {
            $user->wallet->depositFloat(
                $reffered_to_amount,
                [sprintf('You used refferal code of <b>%s<b>', $refferer->name)]
            );

            $wallet->depositFloat(
                $reffered_by_amount,
                [sprintf('Your refferal code was used by <b>%s</b>', $user->name)]
            );

            $user->referral()->rawUpdate(['redeemed' => true]);
        });
    }

    public function appraise()
    {
        if (is_null($this->referral->reffered_by)) {
            return null;
        }

        return optional(static::find($this->referral->reffered_by))
            ->redeem($this->referral->user_id);
    }
}
