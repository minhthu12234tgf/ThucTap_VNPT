<?php

namespace Illuminate\Contracts\Auth;

interface Guard
{
    /**
     * @return \App\Models\TaiKhoan|null
     */
    public function user();
}