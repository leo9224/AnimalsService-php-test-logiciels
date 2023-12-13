<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use PHPUnit\Framework\TestCase;

require __DIR__ . '/../../src/AnimalService.php';

/**
 * * @covers invalidInputException
 * @covers \AnimalService
 *
 * @internal
 */
final class AnimalServiceUnitTest extends TestCase {
    private $animalService;

    public function __construct(string $name = null, array $data = [], $dataName = '') {
        parent::__construct($name, $data, $dataName);
        $this->animalService = new AnimalService();
    }


    public function testCreationAnimalWithoutAnyText() {
    }

    public function testCreationAnimalWithoutName() {
    }

    public function testCreationAnimalWithoutNumber() {
    }

    public function testSearchAnimalWithNumber() {
    }

    public function testModifyAnimalWithInvalidId() {
    }

    public function testDeleteAnimalWithTextAsId() {
    }

}
