<?php
class Bypass
{
    private $defaultUserId = 2;
    private $myIp = "178.83.23.15";
    private $on = true;

    public function getDefaultId() {
        return $this->defaultUserId;
    }

    public function isNeeded() {
        return $_SERVER['REMOTE_ADDR'] == $this->myIp && $this->on;
    }
}