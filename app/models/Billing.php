<?php

use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableInterface;

class Billing extends Eloquent {

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'billings';
  protected $primaryKey = 'idBilling';
  protected $appends = array('amountPaidFormatted', 'paymentDateTime', 'status', 'daysRemaining', 'daysOfType'
                            , 'startDateTimeFormatted', 'endDateTimeFormatted');
  
  public function payer()
  {
    return $this->belongsTo('User', 'payersRut', 'rut');
  }
  
  public function getAmountPaidFormattedAttribute()
  {
    return '$ ' . number_format($this->amountPaid, 0, ',', '.');
  }
  
  public function setPaymentMethodAttribute($value)
  {
    $v = null;
    if ($value == 'deposit')
      $v = 1;
    if ($value == 'transfer')
      $v = 2;
    if ($value == 'creditCard')
      $v = 3;
      
    $this->attributes['paymentMethod'] = $v;
  }
  
  public function getPaymentMethodAttribute()
  {
    $v = null;
    switch($v)
    {
      case 1:
        $v = 'deposit';
        break;
      case 2:
        $v = 'transfer';
        break;
      case 3:
        $v = 'creditCard';
        break;
      default:
        $v = $this->attributes['paymentMethod'];
        break;
    }
    
    $this->attributes['paymentMethod'] = $v;
  }
  
  public function getPaymentDateTimeFormattedAttribute()
	{
    try
    {
      $dateTime = new DateTime($this->paymentDateTime);
      return $dateTime->format('d/m/Y H:i:s');
    }
    catch(Exception $e)
    {
      return $this->paymentDateTime;
    }
	}
  
  public function getStatusAttribute()
  {
    // Dias pasados desde el pago
    $interval = (new DateTime($this->startDateTime))->diff(new DateTime());

    $days = $interval->format('%R%a');

    if ($this->type == 'forLifeSuscription')
      return 'active';
  
    if ($days > $this->daysOfType)
      return 'expired';
    else
      return 'active';
  }
  
  public function getDaysOfTypeAttribute()
  {
    switch($this->type)
    {
      case 'oneMonthSuscription':
        return 30;
      case 'twoMonthSuscription':
        return 2 * 30;
      case 'threeMonthSuscription':
        return 3 * 30;
      case 'sixMonthSuscription':
        return 6 * 30;
      case 'oneYearSuscription':
        return 365;
      case 'forLifeSuscription':
        return -1;
      default:
        return 0;
    }
  }
  
  public function getDaysRemainingAttribute()
  {
    $days = (new DateTime($this->startDateTime))->diff(new DateTime())->format('%R%a');
    
    if ($this->type == 'forLifeMonthSuscription')
      return -1;
    
    return $this->daysOfType - $days;
  }
  
  public function getStartDateTimeFormattedAttribute()
  {
    try
    {
      $dateTime = new DateTime($this->startDateTime);
      return $dateTime->format('d/m/Y H:i:s');
    }
    catch(Exception $e)
    {
      return $this->startDateTime;
    }
  }
  
  public function getEndDateTimeFormattedAttribute()
  {
    if ($this->type == 'forLifeSuscription')
      return 'Vitalicia';
    return (new DateTime($this->startDateTime))->add(new DateInterval("P" . $this->daysOfType . "D"))
      ->format('d/m/Y H:i:s');
  }
}