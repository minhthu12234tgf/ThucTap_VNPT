<?php

namespace Illuminate\Support\Facades;

interface Auth
{
    /**
     * @return \App\Models\TaiKhoan|false
     */
    public static function loginUsingId(mixed $id, bool $remember = false);

    /**
     * @return \App\Models\TaiKhoan|false
     */
    public static function onceUsingId(mixed $id);

    /**
     * @return \App\Models\TaiKhoan|null
     */
    public static function getUser();

    /**
     * @return \App\Models\TaiKhoan
     */
    public static function authenticate();

    /**
     * @return \App\Models\TaiKhoan|null
     */
    public static function user();

    /**
     * @return \App\Models\TaiKhoan|null
     */
    public static function logoutOtherDevices(string $password);

    /**
     * @return \App\Models\TaiKhoan
     */
    public static function getLastAttempted();
}