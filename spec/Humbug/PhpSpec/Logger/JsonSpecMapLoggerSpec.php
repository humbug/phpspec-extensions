<?php

namespace spec\Humbug\PhpSpec\Logger;

use PhpSpec\ObjectBehavior;

class JsonSpecMapLoggerSpec extends ObjectBehavior
{
    public function it_is_initializable()
    {
        $this->shouldHaveType('\\Humbug\\PhpSpec\\Logger\\JsonSpecMapLogger');
    }

    public function it_logs_specifications()
    {
        $this->logSpecification('/path/to/Foo', 'FooSpec', 'spec\Foo', 'Foo');
        $this->write();
        $expected = [
            '/path/to/Foo' => [
                'specTitle' => 'FooSpec',
                'specClass' => 'spec\Foo',
                'srcClass'  => 'Foo',
            ],
        ];
        $this->shouldHaveWrittenLog($expected);
    }

    public function getMatchers()
    {
        return [
            'haveWrittenLog' => function ($subject, $value) {
                return $value === json_decode(file_get_contents(sys_get_temp_dir().'/phpspec.specmap.humbug.json'), true);
            },
        ];
    }
}
