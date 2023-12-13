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

    // test de suppression de toute les données, nécessaire pour nettoyer la bdd de tests à la fin
    public function testDeleteAll()
    {
        $this->animalService->deleteAllAnimal();

        $this->assertEmpty($this->animalService->getAllAnimals());
    }

    public function testCreation()
    {
        $this->animalService->createAnimal("lapin","1");
        $this->assertEquals(["id"=>1,"nom"=>"lapin","numeroIdentifcation"=>"1"],$this->animalService->getAnimal(1));
        $this->assertEquals([["id"=>1,"nom"=>"lapin","numeroIdentifcation"=>"1"]],$this->animalService->getAllAnimals());

        $this->animalService->createAnimal("chat","2");
        $this->assertEquals(["id"=>2,"nom"=>"chat","numeroIdentifcation"=>"2"],$this->animalService->getAnimal(2));
        $this->assertEquals([["id"=>1,"nom"=>"lapin","numeroIdentifcation"=>"1"],
            ["id"=>2,"nom"=>"chat","numeroIdentifcation"=>"2"]],$this->animalService->getAllAnimals());

        $this->animalService->deleteAllAnimal();
    }

    public function testSearch()
    {
        $this->animalService->createAnimal("lapin","1");
        $this->animalService->createAnimal("chat","2");
        $this->animalService->createAnimal("chien","2");

        $this->assertEquals([["id"=>1,"nom"=>"lapin","numeroIdentifcation"=>"1"]],$this->animalService->searchAnimal("1"));
        $this->assertEquals([["id"=>1,"nom"=>"lapin","numeroIdentifcation"=>"1"]],$this->animalService->searchAnimal("lapin"));

        $this->assertEquals([["id"=>2,"nom"=>"chat","numeroIdentifcation"=>"2"],
            ["id"=>3,"nom"=>"chien","numeroIdentifcation"=>"2"]],$this->animalService->searchAnimal("2"));
        $this->assertEquals([["id"=>2,"nom"=>"chat","numeroIdentifcation"=>"2"]],$this->animalService->searchAnimal("chat"));
        $this->assertEquals([["id"=>3,"nom"=>"chien","numeroIdentifcation"=>"2"]],$this->animalService->searchAnimal("chien"));

        $this->animalService->deleteAllAnimal();
    }

    public function testModify()
    {
        $this->animalService->createAnimal("lapin","1");
        $this->assertEquals(["id"=>1,"nom"=>"lapin","numeroIdentifcation"=>"1"],$this->animalService->getAnimal(1));

        $this->animalService->updateAnimal("1","rabbit","2");
        $this->assertEquals(["id"=>1,"nom"=>"rabbit","numeroIdentifcation"=>"2"],$this->animalService->getAnimal(1));

        $this->animalService->deleteAllAnimal();
    }

    public function testDelete()
    {
        $this->animalService->createAnimal("lapin","1");
        $this->animalService->createAnimal("chat","2");
        $this->animalService->createAnimal("chien","2");

        $this->animalService->deleteAnimal(3);
        $this->assertEquals([["id"=>1,"nom"=>"lapin","numeroIdentifcation"=>"1"],
            ["id"=>2,"nom"=>"chat","numeroIdentifcation"=>"2"]],$this->animalService->getAllAnimals());

        $this->animalService->deleteAnimal(2);
        $this->assertEquals([["id"=>1,"nom"=>"lapin","numeroIdentifcation"=>"1"]],$this->animalService->getAllAnimals());

        $this->animalService->deleteAnimal(1);
        $this->assertEmpty($this->animalService->getAllAnimals());

        $this->animalService->deleteAllAnimal();
    }
}
