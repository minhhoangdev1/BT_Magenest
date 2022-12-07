<?php

namespace Magenest\UiKnockoutJs\Controller\Adminhtml\Popup;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Ui\Component\MassAction\Filter;
use Magenest\UiKnockoutJs\Model\ResourceModel\Popup\CollectionFactory;

class Delete extends Action
{
    public $collectionFactory;

    public $filter;

    public function __construct(
        Context           $context,
        Filter            $filter,
        CollectionFactory $collectionFactory
    )
    {
        $this->filter = $filter;
        $this->collectionFactory = $collectionFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        try {
            $collection = $this->filter->getCollection($this->collectionFactory->create());

            $count = 0;
            foreach ($collection as $model) {
                $model->delete();
                $count++;
            }
            $this->messageManager->addSuccess(__('A total of %1 items(s) have been deleted.', $count));
        } catch (\Exception $e) {
            $this->messageManager->addError(__($e->getMessage()));
        }
        return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setPath('*/popup/index');
    }
}