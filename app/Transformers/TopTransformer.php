<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class TopTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform($data)
    {
        return [
            'integer' => $data->integer,
            'roman_numeral' => $data->roman_numeral,
            'conversions' => $data->conversions,
            'last_converted_at' => $data->last_converted_at
        ];
    }
}
