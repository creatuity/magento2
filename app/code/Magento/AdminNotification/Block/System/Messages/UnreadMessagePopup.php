<?php
/**
 * @copyright Copyright (c) 2014 X.commerce, Inc. (http://www.magentocommerce.com)
 */
namespace Magento\AdminNotification\Block\System\Messages;

use Magento\Framework\Notification\MessageInterface;

class UnreadMessagePopup extends \Magento\Backend\Block\Template
{
    /**
     * List of item classes per severity
     *
     * @var array
     */
    protected $_itemClasses = [
        MessageInterface::SEVERITY_CRITICAL => 'error',
        MessageInterface::SEVERITY_MAJOR => 'warning',
    ];

    /**
     * System Message list
     *
     * @var \Magento\AdminNotification\Model\Resource\System\Message\Collection
     */
    protected $_messages;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\AdminNotification\Model\Resource\System\Message\Collection\Synchronized $messages
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\AdminNotification\Model\Resource\System\Message\Collection\Synchronized $messages,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->_messages = $messages;
    }

    /**
     * Render block
     *
     * @return string
     */
    protected function _toHtml()
    {
        if (count($this->_messages->getUnread())) {
            return parent::_toHtml();
        }
        return '';
    }

    /**
     * Retrieve list of unread messages
     *
     * @return MessageInterface[]
     */
    public function getUnreadMessages()
    {
        return $this->_messages->getUnread();
    }

    /**
     * Retrieve popup title
     *
     * @return string
     */
    public function getPopupTitle()
    {
        $messageCount = count($this->_messages->getUnread());
        if ($messageCount > 1) {
            return __('You have %1 new system messages', $messageCount);
        } else {
            return __('You have %1 new system message', $messageCount);
        }
    }

    /**
     * Retrieve item class by severity
     *
     * @param MessageInterface $message
     * @return string
     */
    public function getItemClass(MessageInterface $message)
    {
        return $this->_itemClasses[$message->getSeverity()];
    }
}
