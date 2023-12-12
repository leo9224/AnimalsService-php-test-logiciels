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
final class AnimalServiceIntegrationTest extends TestCase
{
    private $animalService;

    public function __construct(string $name = null, array $data = [], $dataName = '') {
        parent::__construct($name, $data, $dataName);
        $this->animalService = new AnimalService();
    }

    public function testCreationAnimal()
    {
        static::assertTrue($this->animalService->createAnimal('testNom', 'testnumeroIdentification'));
        $data = $this->animalService->getAllAnimals();
        // echo "Creation animal :";
        // echo var_dump($data);
        static::assertSame('testNom', $data[0]['nom']);
        static::assertSame('testnumeroIdentification', $data[0]['numeroIdentifcation']);
        $this->id = $data[0]['id'];

    }

}
