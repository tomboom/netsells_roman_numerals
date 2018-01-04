<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;

class RecentTransformer extends TransformerAbstract
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
            'converted_at' => $data->created_at
        ];
    }
}
