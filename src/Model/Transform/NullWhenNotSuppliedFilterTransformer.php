<?php

namespace Gems\SurveyAnswerInfo\Model\Transform;

class NullWhenNotSuppliedFilterTransformer extends \MUtil_Model_ModelTransformerAbstract
{
    /**
     * @var array
     */
    protected $optionalFields;

    public function __construct(array $fields)
    {
        $this->optionalFields = $fields;
    }

    public function transformFilter(\MUtil_Model_ModelAbstract $model, array $filter)
    {
        foreach ($this->optionalFields as $fieldName) {
            if (!isset($filter[$fieldName])
                && !isset($filter[$fieldName . ' IS NULL'])
                && !isset($filter[$fieldName . ' IS NOT NULL'])
            ) {
                $filter[] = $fieldName . ' IS NULL';
            }
        }
    }
}
