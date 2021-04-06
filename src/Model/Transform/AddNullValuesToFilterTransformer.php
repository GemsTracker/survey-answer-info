<?php

namespace Gems\SurveyAnswerInfo\Model\Transform;

class AddNullValuesToFilterTransformer extends \MUtil_Model_ModelTransformerAbstract
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
            if (isset($filter[$fieldName])
                && !isset($filter[$fieldName . ' IS NULL'])
                && !isset($filter[$fieldName . ' IS NOT NULL'])
            ) {
                $newFilter = [
                    $fieldName . ' IS NULL',
                    $fieldName => $filter[$fieldName],
                ];

                foreach($filter as $filterKey=>$filterValue) {
                    if (strpos($filterValue, $fieldName) === 0) {
                        $newFilter[] = $filterValue;
                        unset($filter[$filterKey]);
                    }
                }
                $filter[] = $newFilter;
            }
        }
        return $filter;
    }
}
