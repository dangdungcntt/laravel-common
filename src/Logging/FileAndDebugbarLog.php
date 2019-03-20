<?php
/**
 * Created by PhpStorm.
 * User: dangdung
 * Date: 29/10/2018
 * Time: 00:20
 */

namespace Pushtimize\Common\Logging;

use Illuminate\Log\Logger;
use Illuminate\Support\Facades\Log;

class FileAndDebugbarLog extends Logger
{
    public function debug($message, array $context = [])
    {
        return $this->log('debug', $message, $context);
    }

    public function log($level, $message, array $context = [])
    {
        if ($level == 'log' || ! method_exists($this, $level)) {
            return false;
        }

        Log::{$level}($message, $context);
        if (function_exists('debugbar') && method_exists(debugbar(), $level)) {
            debugbar()->{$level}($message, $context);
        }
        return true;
    }

    public function info($message, array $context = [])
    {
        return $this->log('info', $message, $context);
    }

    public function error($message, array $context = [])
    {
        return $this->log('error', $message, $context);
    }

    public function alert($message, array $context = [])
    {
        return $this->log('alert', $message, $context);
    }

    public function critical($message, array $context = [])
    {
        return $this->log('critical', $message, $context);
    }

    public function emergency($message, array $context = [])
    {
        return $this->log('emergency', $message, $context);
    }

    public function warning($message, array $context = [])
    {
        return $this->log('warning', $message, $context);

    }

    public function notice($message, array $context = [])
    {
        return $this->log('notice', $message, $context);
    }
}
