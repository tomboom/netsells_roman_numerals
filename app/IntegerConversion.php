<?php

namespace App;

class IntegerConversion implements IntegerConversionInterface
{
	public function toRomanNumerals($integer) {
		
		// Check if integer between 1 and 3999
		
		if(!is_numeric($integer) || ($integer < 1 || $integer > 3999)) {
			throw new \Exception('Must be integer between 1 and 3999.');
		}
		
		// Convert integer to roman numerals
		
		$map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
		
		$result = '';
		
		while($integer > 0) {
        	foreach($map as $roman => $value) {
            	if($integer >= $value) {
					$integer -= $value;
					$result .= $roman;
					break;
				}
			}
		}
		
		return $result;
		
	}
}