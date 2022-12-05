<?php

namespace App\Tests;

use App\Services\RequestHelper;
use PHPUnit\Framework\TestCase;

class RequestHelperTest extends TestCase
{
    /**
     * @param array $input
     * @param array $output
     * @return void
     * @dataProvider dpData
     */
    public function testValidate(array $input, array $output): void
    {
        $helper = (new RequestHelper($input))->stripQueryParams();

        $this->assertEquals($output, $helper);
    }



    /**
     * @return array[]
     */
    public function dpData(): array
    {
        return [
            'sort_success' => [
                'input' => [
                    "form" => [
                        "name" => "",
                        "weigth" => "",
                        "sortName" => "true"
                    ]
                ],
                'output' => [
                    "form" => [
                        "name" => "",
                        "weigth" => "",
                        "sortName" => "true",
                    ],
                    "page" => 1
                ],

            ],
            'empty_query' => [
                'input' => [],
                'output' => [
                    "page" => 1
                ],
            ]
        ];
    }
}
