<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ConvertArabicDigits
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $input = $request->all();

        if (!empty($input)) {
            $request->merge($this->convertDigits($input));
        }

        return $next($request);
    }

    /**
     * Recursively convert Arabic/Persian digits to English digits.
     *
     * @param mixed $value
     * @return mixed
     */
    private function convertDigits($value)
    {
        if (is_array($value)) {
            return array_map([$this, 'convertDigits'], $value);
        }

        if (is_string($value)) {
            $arabicDigits = ['٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩'];
            $persianDigits = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
            $englishDigits = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];

            $value = str_replace($arabicDigits, $englishDigits, $value);
            $value = str_replace($persianDigits, $englishDigits, $value);
        }

        return $value;
    }
}
