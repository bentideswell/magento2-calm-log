<?php
/**
 *
 */
namespace FishPig\CalmLog\App\Logger;

class SilencerProxy extends \Magento\Framework\Logger\LoggerProxy
{
    /**
     *
     */
    public function info($message, array $context = [])
    {
        if (!$this->isIgnorableMessage($message)) {
            parent::info($message, $context);
        }
    }

    /**
     *
     */
    private function isIgnorableMessage($message): bool
    {
        if (!is_string($message)) {
            return false;
        }

        if (strpos($message, 'Broken reference:') === 0) {
            return true;
        } elseif (strpos($message, 'Add of item with id') !== false) {
            return true;
        } elseif (strpos($message, ' was removed') !== false) {
            return true;
        } elseif (strpos($message, 'Reference to undeclared plugin with name') === 0) {
            return true;
        }

        return false;
    }
}