<?php

if (!function_exists('paginate')) {
    function paginate($data, $page, $limit)
    {
        $total = $data->count();
        $skip = ($page - 1) * $limit;
        $data = $data->slice($skip, $limit);
        return [
            'data' => $data,
            'total' => $total,
            'page' => $page,
            'limit' => $limit,
        ];
    }
}