<?php

namespace Core\Service;

class ModelService extends BaseService
{
	protected function removeInputFilter($data)
    {
        foreach ($data as $key => $value) {
            if ($key == 'inputFilter') {
                unset($data[$key]);
            }
        }
        return $data;
    }
    public function prepareDataToSelectInput($data, $key, $value)
    {
        if(sizeof($data) > 0) {
            foreach ($data as $k => $v) {
                $preparedData[$v->{$key}] = $v->{$value};
            }
        } else {
            $preparedData[0] = '';
        }
        return $preparedData;
    }
}