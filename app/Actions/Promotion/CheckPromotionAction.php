<?php

namespace App\Actions\Promotion;
use App\Models\Payment;
use App\Models\Promotion;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class CheckPromotionAction
{
    public function execute($data): array
    {
        $promotion = Promotion::query()->where('code', Str::upper($data['code']))->first();
        if (!$promotion || !$promotion->is_available) {
            abort(410, __('Promo code not available or inactive.'));
        }
        $this->checkRestrictions($promotion, $data);

        return [
            'original_price' => $data['amount'],
            'discounted_price' => $this->calculateDiscount($promotion, $data['amount']),
        ];
    }

    /**
     *
     * @param Promotion $promotion
     * @param array $validated
     * @throws HttpResponseException
     */
    private function checkRestrictions(Promotion $promotion, array $validated): void
    {
        $now = Carbon::now();
        if (!$this->isDayValid($promotion, $now)) {
            abort(406, __('Promo code is not valid for today.'));
        }
        if (!$this->isTimeValid($promotion, $now)) {
            abort(406, __('Promo code is not valid at this time.'));
        }
        if (!$this->isDateValid($promotion, $now)) {
            abort(406, __('Promo code is not valid for this date range.'));
        }

        if (!$this->isTotalUsageValid($promotion)) {
            abort(406, __('Promo code usage limit reached.'));
        }
        if (!$this->isUserUsageValid($promotion, $validated['user_id'])) {
            abort(406, __('You have reached the usage limit for this promo code.'));
        }
        if (!$this->isFirstOrderValid($promotion, $validated['user_id'])) {
            abort(406, __('This promo code is only valid for the first order.'));
        }
    }

    private function isDayValid(Promotion $promotion, Carbon $now): bool
    {
        $todayName = strtolower($now->format('l'));
        return $promotion->avb_days === ['all'] || in_array($todayName, $promotion->avb_days ?? []);
    }

    private function isTimeValid(Promotion $promotion, Carbon $now): bool
    {
        if (!$promotion->have_times) {
            return true;
        }

        $currentTime = $now->format('H:i');
        $startTime = $promotion->times['start'] ?? null;
        $endTime = $promotion->times['end'] ?? null;

        return $startTime && $endTime && $currentTime >= $startTime && $currentTime <= $endTime;
    }

    private function isDateValid(Promotion $promotion, Carbon $now): bool
    {
        if (!$promotion->have_dates) {
            return true;
        }

        $currentDate = $now->format('Y-m-d');
        $startDate = $promotion->dates['start'] ?? null;
        $endDate = $promotion->dates['end'] ?? null;

        return $startDate && $endDate && $currentDate >= $startDate && $currentDate <= $endDate;
    }

    private function isTotalUsageValid(Promotion $promotion): bool
    {
        $usageLimit = $promotion->usage_limit['total'] ?? null;
        return !$usageLimit || $promotion->usage_count < $usageLimit;
    }

    private function isUserUsageValid(Promotion $promotion, int $userId): bool
    {
        $usageLimit = $promotion->usage_limit['per_user'] ?? null;
        if (!$usageLimit) {
            return true;
        }

        $userUsageCount = Payment::query()->where('user_id', $userId)
            ->where('promotion_id', $promotion->id)
            ->count();

        return $userUsageCount < $usageLimit;
    }

    private function isFirstOrderValid(Promotion $promotion, int $userId): bool
    {
        $firstOrder = $promotion->usage_limit['first_order'] ?? null;
        if (!$firstOrder) {
            return true;
        }

        return !Payment::query()->where('user_id', $userId)->exists();
    }

    private function calculateDiscount(Promotion $promotion, float $price): float
    {
        $discount = 0;

        if ($promotion->discount['type'] === 'percent') {
            $discount = $price * ($promotion->discount['value'] / 100);
        } elseif ($promotion->discount['type'] === 'fixed') {
            $discount = $promotion->discount['value'];
        }

        return max($price - $discount, 0);
    }

}
