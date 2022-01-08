<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Test1And2
{
    public function duplicate(Request $request)
    {
        $payload = $request->only('number');
        $array = array_count_values(str_split($payload['number']));
        foreach ($array as $key => $data) {
            if($data > 1)
            return $array[$key];
        }
    }

    public function bubbleSort(Request $request)
    {
        $sort = $request->sort == 'asc' ? SORT_ASC : SORT_DESC;
        if (!$request->filled('sort')|| !$request->filled('field')) {
            throw new \Exception("input sort dan field", 403);
        }
        $array = str_split($request->field);
        array_multisort($array, $sort);
        return $array;
    }
}
