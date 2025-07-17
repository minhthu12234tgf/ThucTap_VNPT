<?php

namespace Illuminate\Http;

interface Request
{
    /**
     * @return \App\Models\TaiKhoan|null
     */
    public function user($guard = null);
}