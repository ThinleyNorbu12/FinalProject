<?php
// Updated Model: RequiredCarInfo.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequiredCarInfo extends Model
{
    use HasFactory;
    
    protected $table = 'required_car_info';
    
    protected $fillable = [
        'car_id',
        'vehicle_registration_number',
        'owner_license_number',
        'valid_registration',
        'insurance_valid',
        'road_tax_paid',
        'fitness_certificate',
        'pollution_certificate',
        'scratches',
        'dents',
        'cracked_lights_or_mirrors',
        'tire_condition',
        'body_exterior_acceptable',
        'seat_dashboard_condition',
        'ac_working',
        'interior_condition_good',
        'engine_condition_good',
        'brakes_functional',
        'lights_working',
        'horn_working',
        'no_engine_warning_lights',
        'indicators_wipers_working',
        'safety_features_working',
        'spare_tire_available',
        'jack_available',
        'initial_fuel_level',
        'additional_notes',
        'overall_status',
    ];
    
    protected $casts = [
        'valid_registration' => 'boolean',
        'insurance_valid' => 'boolean',
        'road_tax_paid' => 'boolean',
        'fitness_certificate' => 'boolean',
        'pollution_certificate' => 'boolean',
        'body_exterior_acceptable' => 'boolean',
        'ac_working' => 'boolean',
        'interior_condition_good' => 'boolean',
        'engine_condition_good' => 'boolean',
        'brakes_functional' => 'boolean',
        'lights_working' => 'boolean',
        'horn_working' => 'boolean',
        'no_engine_warning_lights' => 'boolean',
        'indicators_wipers_working' => 'boolean',
        'safety_features_working' => 'boolean',
        'spare_tire_available' => 'boolean',
        'jack_available' => 'boolean',
    ];

    // Relationship with Car model
    public function car()
    {
        return $this->belongsTo(Car::class);
    }

    // Helper method to check if inspection passed
    public function isPassed()
    {
        return $this->overall_status === 'approved';
    }

    // Helper method to get inspection score (percentage of passed checks)
    public function getInspectionScore()
    {
        $booleanFields = [
            'valid_registration', 'insurance_valid', 'road_tax_paid', 
            'fitness_certificate', 'pollution_certificate', 'body_exterior_acceptable',
            'ac_working', 'interior_condition_good', 'engine_condition_good',
            'brakes_functional', 'lights_working', 'horn_working',
            'no_engine_warning_lights', 'indicators_wipers_working',
            'safety_features_working', 'spare_tire_available', 'jack_available'
        ];
        
        $totalFields = count($booleanFields);
        $passedFields = 0;

        foreach ($booleanFields as $field) {
            if ($this->{$field}) {
                $passedFields++;
            }
        }

        return $totalFields > 0 ? round(($passedFields / $totalFields) * 100, 2) : 0;
    }

    // Get tire condition options
    public static function getTireConditionOptions()
    {
        return [
            'excellent' => 'Excellent',
            'good' => 'Good',
            'fair' => 'Fair',
            'poor' => 'Poor',
            'needs_replacement' => 'Needs Replacement'
        ];
    }

    // Get fuel level options
    public static function getFuelLevelOptions()
    {
        return [
            'full' => 'Full',
            'three_quarter' => '3/4 Full',
            'half' => 'Half',
            'quarter' => '1/4 Full',
            'empty' => 'Empty'
        ];
    }
}
