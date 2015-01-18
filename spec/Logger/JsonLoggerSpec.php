<?php

namespace spec\Humbug\PhpSpec\Logger;

use Humbug\PhpSpec\Logger\JsonLogger;
use PhpSpec\ObjectBehavior;

class JsonLoggerSpec extends ObjectBehavior
{
    function let()
    {
        $this->file = sys_get_temp_dir() . '/humbugspec.timings.json';
        $this->beConstructedWith($this->file);
    }

    function letgo()
    {
        @unlink($this->file);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Logger\\JsonLogger');
    }

    function it_logs_specifications()
    {
        $this->logSpecification('foo', 1);
        $this->write();
        $expected = [
            'specifications' => [
                'foo' => 1
            ],
            'examples' => []
        ];
        $this->shouldHaveWrittenLog($expected);
    }

    function it_logs_examples()
    {
        $this->logExample('foo', 'bar', 1);
        $this->write();
        $expected = [
            'specifications' => [
            ],
            'examples' => [
                'foo' => [
                    'title' => 'bar',
                    'time' => 1
                ]
            ]
        ];
        $this->shouldHaveWrittenLog($expected);
    }

    public function getMatchers()
    {
        return [
            'shouldHaveWrittenLog' => function($subject, $value) {
                return $value === json_decode(file_get_contents($this->file), true);
            }
        ];
    }
}
