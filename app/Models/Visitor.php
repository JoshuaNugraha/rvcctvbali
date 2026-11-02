<?php

namespace App\Models;

use Database\Factories\VisitorFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class Visitor extends Model
{
    /** @use HasFactory<VisitorFactory> */
    use HasFactory;

    /**
     * @var list<string>
     */
    protected $fillable = [
        'ip_address',
        'date',
        'location',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }

    /**
     * Record a new visitor entry if the visitor is not an authenticated admin
     * and has not visited within the last 5 hours.
     */
    public static function recordVisit(Request $request): ?self
    {
        if (auth()->check()) {
            return null;
        }

        $ipAddress = (string) $request->ip();
        if ($ipAddress === '') {
            return null;
        }

        $fiveHoursAgo = now()->subHours(5);

        $hasRecentVisit = static::where('ip_address', $ipAddress)
            ->where('date', '>=', $fiveHoursAgo)
            ->exists();

        if ($hasRecentVisit) {
            return null;
        }

        $location = static::resolveLocation($request, $ipAddress);

        return static::create([
            'ip_address' => $ipAddress,
            'date' => now(),
            'location' => $location,
        ]);
    }

    /**
     * Resolve the location for the given IP address.
     */
    public static function resolveLocation(Request $request, string $ipAddress): string
    {
        if ($country = $request->header('CF-IPCountry')) {
            $city = $request->header('CF-IPCity');

            return $city ? "{$city}, {$country}" : (string) $country;
        }

        if (
            $ipAddress === '127.0.0.1'
            || $ipAddress === '::1'
            || ! filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)
        ) {
            return 'Localhost';
        }

        try {
            $response = Http::timeout(1)->get("http://ip-api.com/json/{$ipAddress}?fields=status,country,city");
            if ($response->successful()) {
                $data = $response->json();
                if (isset($data['status']) && $data['status'] === 'success') {
                    $city = $data['city'] ?? null;
                    $country = $data['country'] ?? null;

                    if ($city && $country) {
                        return "{$city}, {$country}";
                    }

                    return (string) ($city ?: ($country ?: 'Unknown'));
                }
            }
        } catch (\Throwable) {
            // Fallback silently if offline or lookup fails
        }

        return 'Unknown';
    }
}
