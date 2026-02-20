<?php

use App\Models\Cases;
use App\Models\CaseStatus;
use App\Models\Installment;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Course;
use Illuminate\Support\Str;
use App\Models\CourseLesson;
use App\Utils\GlobalConstant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Models\CompletedStudentCourse;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

if (!function_exists('currency_symbol')) {
    function currency_symbol(): string
    {
        return "$";
    }
}

if (!function_exists('seconds_to_hour')) {
    function seconds_to_hour($init)
    {
        $hours = floor($init / 3600);
        $minutes = floor(($init / 60) % 60);

        return $hours . "h " . $minutes . "m";
    }
}

if (!function_exists('feature_string_to_array')) {
    function feature_string_to_array($str)
    {
        return explode('|', $str);
    }
}


if (!function_exists('tag_process_for_front')) {
    function tag_process_for_front($tag_str)
    {
        try {
            $tag_array = tag_string_to_array($tag_str);
            $process_tag = [];
            foreach ($tag_array as $tag) {
                $t = new \stdClass();
                $t->value = $tag;
                $process_tag[] = $t;
            }
            return json_encode($process_tag);
        } catch (Exception $e) {
            log_error($e);
            return '';
        }
    }
}
if (!function_exists('tag_string_to_array')) {
    function tag_string_to_array($str)
    {
        return explode(',', $str);
    }
}


if (!function_exists('tags_to_string')) {
    function tags_to_string($tag_array)
    {
        $all_tags = [];
        try {
            foreach (json_decode($tag_array) as $tag) {
                $all_tags[] = $tag->value;
            }
        } catch (Exception $e) {
            log_error($e);
        }
        return implode(',', $all_tags);
    }
}

function str_title($title)
{
    return Str::title($title);
}

function get_current_route_name()
{
    //    Log::info(Route::current()->getName());
    return Route::current()->getName();
}

if (!function_exists('days_ago_from_now')) {

    function days_ago_from_now($date, $full = false)
    {
        $now = new DateTime();
        $ago = new DateTime($date);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) {
            $string = array_slice($string, 0, 1);
        }

        $data = $string ? implode(', ', $string) . ' ago' : 'just now';
        return $data;
    }
}

if (!function_exists('make_2_digits')) {

    function make_2_digits($num)
    {
        return sprintf('%02d', $num);
    }
}

if (!function_exists('random_number')) {
    function random_number()
    {
        return random_int(100000, 999999);
    }
}


if (!function_exists('str_limit')) {

    function str_limit($string, $limit, $end = '...')
    {
        return Str::limit($string, $limit, $end);
    }
}

if (!function_exists('month_list')) {

    function month_list()
    {
        return [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'December',
        ];
    }
}

if (!function_exists('get_storage_image')) {

    function get_storage_image($path, $name, $type = 'normal')
    {
        $full_path = '/storage/' . $path . '/' . $name;
        if ($name) {
            return asset($full_path);
        }
        return get_default_image($type);
    }
}
if (!function_exists('get_storage_file')) {
    function get_storage_file($path, $name)
    {
        $full_path = '/storage/' . $path . '/' . $name;
        if ($name) {
            return asset($full_path);
        }
        return get_default_image();
    }
}

if (!function_exists('get_default_image')) {

    function get_default_image($type = 'normal')
    {
        if ($type == 'user') {
            return asset('/images/user_default.png');
        } elseif ($type == 'normal') {
            return asset('/images/default.png');
        }
    }
}


if (!function_exists('record_custom_flash')) {

    function record_custom_flash($message = null)
    {
        Session::flash('custom', $message ?? 'Record modified successfully');
    }
}

if (!function_exists('message_send_flash')) {

    function message_send_flash($message = null)
    {
        Session::flash('message', $message ?? 'Your message was sent successfully');
    }
}

if (!function_exists('record_created_flash')) {

    function record_created_flash($message = null)
    {
        Session::flash('success', $message ?? 'Record created successfully');
    }
}

if (!function_exists('record_updated_flash')) {

    function record_updated_flash($message = null)
    {
        Session::flash('update', $message ?? 'Record updated successfully');
    }
}

if (!function_exists('record_verified_flash')) {

    function record_verified_flash($message = null)
    {
        Session::flash('verified', $message ?? 'Record updated successfully');
    }
}

if (!function_exists('file_uploaded_flash')) {

    function file_uploaded_flash($message = null)
    {
        Session::flash('file_uploaded', $message ?? 'Record updated successfully');
    }
}

if (!function_exists('record_deleted_flash')) {

    function record_deleted_flash($message = null)
    {
        Session::flash('delete', $message ?? 'Record deleted successfully');
    }
}

if (!function_exists('something_wrong_flash')) {

    function something_wrong_flash($message = null)
    {
        Session::flash('error', $message ?? 'Something is wrong!');
    }
}

if (!function_exists('custom_flash')) {

    function custom_flash($title = null, $message = null)
    {
//        Session::flash('custom_title', $title);
//        Session::flash('custom_message', $message);
        Session::flash($title, $message ?? 'Something is wrong!');
    }
}

if (!function_exists('log_error')) {

    function log_error(\Exception $e)
    {
        Log::error($e->getMessage());
    }
}

if (!function_exists('get_page_meta')) {

    function get_page_meta($metaName = "title", $raw = false)
    {
        if (session()->has('page_meta_' . $metaName)) {
            $title = session()->get("page_meta_" . $metaName);
            //            session()->forget("page_meta_" . $metaName);
            if ($raw) {
                return str_replace(' |', '', $title);
            } else {
                return $title;
            }
        }
        return null;
    }
}

if (!function_exists('set_page_meta')) {

    function set_page_meta($content = null, $metaName = "title")
    {
        if ($content && $metaName == "title") {
            session()->put('page_meta_' . $metaName, $content . ' |');
        } else {
            session()->put('page_meta_' . $metaName, $content);
        }
    }
}
if (!function_exists('custom_datetime')) {

    function custom_datetime($datetime, $format = null)
    {
        if ($format) {
            return date($format, strtotime($datetime));
        }

        return date('M j, Y, g:i A', strtotime($datetime));
    }
}

if (!function_exists('custom_date')) {

    function custom_date($datetime, $format = null)
    {
        if ($format) {
            return date($format, strtotime($datetime));
        }

        return date('M j, Y', strtotime($datetime));
    }
}

if (!function_exists('user_fullname')) {

    function user_fullname($user)
    {
        if ($user->middle_name) {
            return $user->first_name . ' ' . $user->middle_name . ' ' . $user->last_name;
        } else {
            return $user->first_name . ' ' . $user->last_name;
        }
    }
}



if (!function_exists('getImage')) {
    function getImage($image = null, $type = null)
    {
        if ($image && Storage::disk('public')->exists($image)) {
            return Storage::disk('public')->url($image);
        } else {
            return asset('/images/default.png');
        }
    }
}


if (!function_exists('show_limited_string')) {

    function show_limited_string($str, $length)
    {
        return strlen($str) > $length ? substr($str, 0, $length) . "..." : $str;
    }
}



if (!function_exists('commission')) {

    function commission($fee_amount, $total_attendee)
    {
        $commission = round((($fee_amount * $total_attendee) * Config('settings.system_COMMISSION')) / 100, 2);

        return $commission;
    }
}


if (!function_exists('is_admin_fee_collected')) {

    function is_admin_fee_collected($items)
    {
        $total = 0;
        foreach ($items as $item){
            $total += $item->admin_fee_amount;
        }
        return $total;
    }
}

// Function to convert number to words
function numberToWords($num) {
    $ones = array(
        0 => "Zero", 1 => "One", 2 => "Two", 3 => "Three", 4 => "Four",
        5 => "Five", 6 => "Six", 7 => "Seven", 8 => "Eight", 9 => "Nine",
        10 => "Ten", 11 => "Eleven", 12 => "Twelve", 13 => "Thirteen", 14 => "Fourteen",
        15 => "Fifteen", 16 => "Sixteen", 17 => "Seventeen", 18 => "Eighteen", 19 => "Nineteen"
    );

    $tens = array(
        0 => "", 1 => "Ten", 2 => "Twenty", 3 => "Thirty", 4 => "Forty",
        5 => "Fifty", 6 => "Sixty", 7 => "Seventy", 8 => "Eighty", 9 => "Ninety"
    );

    $hundreds = array(
        "Hundred", "Thousand,", "Million,", "Billion,", "Trillion,", "Quadrillion,"
    );

    if ($num < 20) {
        return $ones[$num];
    } elseif ($num < 100) {
        return $tens[floor($num / 10)] . ($num % 10 ? "-" . $ones[$num % 10] : "");
    } elseif ($num < 1000) {
        return $ones[floor($num / 100)] . " " . $hundreds[0] . ($num % 100 ? " and " . numberToWords($num % 100) : "");
    } else {
        for ($i = 1, $unit = 1000; $unit <= pow(1000, count($hundreds)); $i++, $unit *= 1000) {
            if ($num < $unit * 1000) {
                return numberToWords(floor($num / $unit)) . " " . $hundreds[$i] . ($num % $unit ? " " . numberToWords($num % $unit) : "");
            }
        }
    }
}

// Function to convert decimal number to words
function decimalToWords($num) {
    $num_parts = explode(".", $num);

    $integer_part = $num_parts[0];
    $fractional_part = isset($num_parts[1]) ? $num_parts[1] : 0;

    $integer_words = numberToWords($integer_part);
    $fractional_words = $fractional_part ? numberToWords($fractional_part) : "Zero";

    return $integer_words . " and Cents " . $fractional_words;
}

//daily compound interest
if (!function_exists('calculateDailyCompoundInterest')) {

    function calculateDailyCompoundInterest($principal, $annualRate)
    {
        $annualRate = $annualRate/100;
        $dailyRate = $annualRate / 365;
        $amount = $principal * pow((1 + $dailyRate), 1);
        return $amount - $principal; // This gives the interest earned in one day
    }
}

if (!function_exists('calculateDailySimpleInterest')) {

    function calculateDailySimpleInterest($principal, $annualRate)
    {
        $dailyRate = $annualRate / 100 / 365;
        $interest = $principal * $dailyRate * 1;
        return $interest;
       // return $amount - $principal; This gives the interest earned over the specified number of days
    }
}






if (!function_exists('calculateCompoundInterestForDays')) {

    function calculateCompoundInterestForDays($principal, $annualRate, $days)
    {
        $dailyRate = $annualRate / 365;
        $t = $days / 365;
        $amount = $principal * pow((1 + $dailyRate), $t);
        return $amount;
       // return $amount - $principal; This gives the interest earned over the specified number of days
    }
}



if (!function_exists('totalBalance')) {

    function totalBalance($case_id)
    {
        $installment = Installment::where('case_id',$case_id)->sum('amount_paid');
        $case = Cases::find($case_id);

        return $case->total_amount_owed - $installment;
    }
}

if (!function_exists('totalBalanceSum')) {

    function totalBalanceSum()
    {
        $installments = Installment::all()->sum('amount_paid');
        $total_amount_owed = Cases::all()->sum('total_amount_owed');
        return $balance = number_format($total_amount_owed - $installments,2);
    }
}

if (!function_exists('totalPaid')) {

    function totalPaid($case_id)
    {
        return Installment::where('case_id',$case_id)->sum('amount_paid');
    }
}

if (!function_exists('totalAmountOwed')) {

    function totalAmountOwed($case_id)
    {
        $installments = Installment::where('case_id',$case_id)->sum('amount_paid');
        $case = Cases::find($case_id);
        return $totalPaid = number_format($case->total_amount_owed - $installments,2);
    }
}


if (!function_exists('formatPaidTo')){
    function formatPaidTo($value) {
        if (!$value) {
            return '-';
        }

        $value = strtolower($value);

        if ($value === 'securre') {
            return 'Securre';
        }
        if ($value === 'client') {
            return 'Client';
        }

        return $value;
    }
}

if (!function_exists('getCaseStatus')){
    function getCaseStatus($value) {
        if (!$value) {
            return '-';
        }
        return CaseStatus::where('value',$value)->first()->name;
    }
}

if (!function_exists('buildInstallmentSms')){
    function buildInstallmentSms($debtor,$installment)
    {
        $balance = totalBalance($installment->case_id);
        $date = optional($installment->next_payment_date)->format('d M Y');
        return "Hello {$debtor->name}(#{$installment->case->case_sku}),\n\n"
            . "This is a gentle reminder of your {$installment->next_payment_amount} payment due by 4pm on {$date}.\n\n"
            . "Please make payment via PayNow to 87428158.\n\n"
            . "Kindly forward us the payment receipt via WhatsApp to 85055484.\n\n"
            . "Thank you.\n\n"
            . "Securre Network\n\n"
            . "Current Bal: {$balance}";
    }

}

if (!function_exists('buildFieldVisitSms')){
    function buildFieldVisitSms($debtor,$case)
    {
        $balance = totalBalance($case->id);
        return "Hello {$debtor->name}(#{$case->case_sku})\n\n"
            . "This is to inform you that your outstanding balance of {$balance} remains unpaid.\n\n"
            . "We have now assigned your case for a field visit.\n\n"
            . "If you wish to avoid this, settle via PayNow to 87428158.\n\n"
            . "Forward receipt via WhatsApp to 85055484.\n\n"
            . "Thank you\n\n"
            . "Securre Network";
    }


}
