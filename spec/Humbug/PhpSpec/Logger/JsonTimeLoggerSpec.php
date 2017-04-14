<?php

namespace spec\Humbug\PhpSpec\Logger;

use PhpSpec\ObjectBehavior;

class JsonTimeLoggerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Logger\\JsonTimeLogger');
    }

    public function it_logs_specifications()
    {
        $this->logSpecification('foo', 1);
        $this->write();
        $expected = [
            'specifications' => [
                'foo' => 1,
            ],
            'examples' => [],
        ];
        $this->shouldHaveWrittenLog($expected);
    }

    public function it_logs_examples()
    {
        $this->logExample('foo', 'bar', 1);
        $this->write();
        $expected = [
            'specifications' => [
            ],
            'examples' => [
                'foo' => [
                    [
                        'title' => 'bar',
                        'time'  => 1,
                    ],
                ],
            ],
        ];
        $this->shouldHaveWrittenLog($expected);
    }

    public function getMatchers()
    {
        return [
            'haveWrittenLog' => function ($subject, $value) {
                return $value === json_decode(file_get_contents(sys_get_temp_dir().'/phpspec.times.humbug.json'), true);
            },
        ];
    }
}
