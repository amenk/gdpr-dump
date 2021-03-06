<?php

declare(strict_types=1);

namespace Smile\GdprDump\Tests\Unit\Converter\Randomizer;

use Smile\GdprDump\Converter\Parameters\ValidationException;
use Smile\GdprDump\Converter\Randomizer\RandomizeText;
use Smile\GdprDump\Tests\Unit\TestCase;

class RandomizeTextTest extends TestCase
{
    /**
     * Test the converter.
     */
    public function testConverter(): void
    {
        $converter = new RandomizeText();

        $value = $converter->convert(null);
        $this->assertSame('', $value);

        $value = $converter->convert('user1');
        $this->assertStringNotContainsString('user1', $value);
    }

    /**
     * Test the converter with a custom min length.
     */
    public function testCustomLength(): void
    {
        $converter = new RandomizeText(['min_length' => 10]);

        $value = $converter->convert('user1');
        $this->assertSame(10, strlen($value));
    }

    /**
     * Test the converter with a custom character replacement string.
     */
    public function testCustomReplacements(): void
    {
        $converter = new RandomizeText(['replacements' => 'a']);

        $value = $converter->convert('user1');
        $this->assertSame('aaaaa', $value);
    }

    /**
     * Assert that an exception is thrown when the parameter "replacements" is empty.
     */
    public function testEmptyReplacements(): void
    {
        $this->expectException(ValidationException::class);
        new RandomizeText(['replacements' => '']);
    }
}
