<?php

namespace App\Services;

class RequestHelper
{
    const AVAILABLE_PARAMS = ['name' => '', 'weigth' => ''];

    private array $query;

    public function __construct(array $query)
    {
        $this->query = $query;
        $this->validate();
    }

    public function stripQueryParams(): array
    {
        if (!empty($this->query['form'])) {
            foreach ($this->query['form'] as $key => $val) {
                $this->query['form'][$key] = strip_tags($val);
            }
            $this->query['page'] = strip_tags($this->query['page']);
        }

        return $this->query;
    }

    private function validate(): void
    {
        if (!empty($this->query['form'])) {
            $dif = array_diff_key(self::AVAILABLE_PARAMS, $this->query['form']);
            if (!empty($dif)) {
                $this->query['form'] = array_merge($this->query['form'], $dif);
            }
        }
        if (
            !array_key_exists('page', $this->query) ||
            (!empty($this->query['page']) && !is_int((int)$this->query['page']))
        ) {
            $this->query['page'] = 1;
        }

        if (array_key_exists('sortWeigth', $this->query) && array_key_exists('sortName', $this->query)) {
            unset($this->query['sortWeigth']);
            unset($this->query['sortName']);
        }
    }
}
