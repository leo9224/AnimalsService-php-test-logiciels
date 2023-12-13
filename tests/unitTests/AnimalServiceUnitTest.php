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

    public function testGetAllAnimalsWhenDbIsEmpty() {
        $this->animalService->deleteAllAnimal();

        $this->assertEquals([],$this->animalService->getAllAnimals());
    }

    public function testGetAllAnimalsWithMultipleAnimals() {
        $this->animalService->deleteAllAnimal();

        $this->animalService->createAnimal("lapin","1");
        $this->animalService->createAnimal("chat","2");
        $this->animalService->createAnimal("chien","3");

        $this->assertEquals([["id"=>1,"nom"=>"lapin","numeroIdentifcation"=>"1"]
        ,["id"=>2,"nom"=>"chat","numeroIdentifcation"=>"2"]
        ,["id"=>3,"nom"=>"chien","numeroIdentifcation"=>"3"]],$this->animalService->getAllAnimals());
    }

    public function testCreationAnimalWithoutAnyText() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("le nom doit être renseigné");

        $this->animalService->createAnimal(null,null);
    }

    public function testCreationAnimalWithoutName() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("le nom doit être renseigné");

        $this->animalService->createAnimal(null,"2");
    }

    public function testCreationAnimalWithoutNumber() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("le numeroIdentification doit être renseigné");

        $this->animalService->createAnimal("lapin",null);
    }

    public function testCreationCorrectAnimal() {
        $this->animalService->deleteAllAnimal();

        $this->animalService->createAnimal("lapin","1");
        $this->assertEquals(["id"=>1,"nom"=>"lapin","numeroIdentifcation"=>"1"],$this->animalService->getAnimal(1));
    }

    public function testSearchAnimalWithNumber() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("search doit être une chaine de caractères");

        $this->animalService->searchAnimal(1);
    }

    public function testSearchAnimalWithEmptySearch() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("search doit être renseigné");

        $this->animalService->searchAnimal(null);
    }
    public function testSearchAnimalWithCorrectNumeroIdentification() {
        $this->animalService->deleteAllAnimal();
        $this->animalService->createAnimal("lapin","1");

        $this->assertEquals([["id"=>1,"nom"=>"lapin","numeroIdentifcation"=>"1"]],$this->animalService->searchAnimal("1"));
    }

    public function testSearchAnimalWithCorrectNom() {
        $this->animalService->deleteAllAnimal();
        $this->animalService->createAnimal("lapin","1");

        $this->assertEquals([["id"=>1,"nom"=>"lapin","numeroIdentifcation"=>"1"]],$this->animalService->searchAnimal("lapin"));
    }

    public function testModifyAnimalWithInvalidId() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être un entier non nul");

        $this->animalService->updateAnimal("f","rabbit","1");
    }

    public function testModifyAnimalWithInvalidNom() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("le nom  doit être renseigné");

        $this->animalService->deleteAllAnimal();
        $this->animalService->createAnimal("lapin","1");

        $this->animalService->updateAnimal("1",null,"1");
    }

    public function testModifyAnimalWithInvalidNumeroidentification() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("le numeroIdentification doit être renseigné");

        $this->animalService->deleteAllAnimal();
        $this->animalService->createAnimal("lapin","1");

        $this->animalService->updateAnimal("1","rabbit",null);
    }

    public function testCorrectModifyAnimal() {
        $this->animalService->deleteAllAnimal();

        $this->animalService->createAnimal("lapin","1");
        $this->assertEquals(["id"=>1,"nom"=>"lapin","numeroIdentifcation"=>"1"],$this->animalService->getAnimal(1));

        $this->animalService->updateAnimal("1","rabbit","2");
        $this->assertEquals(["id"=>1,"nom"=>"rabbit","numeroIdentifcation"=>"2"],$this->animalService->getAnimal(1));
    }

    public function testDeleteAnimalWithTextAsId() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être un entier non nul");

        $this->animalService->deleteAnimal("b");
    }

    public function testDeleteAnimalWithoutId() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être renseigné");

        $this->animalService->deleteAnimal(null);
    }

    public function testDeleteAnimalWithNegativeId() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être un entier non nul");

        $this->animalService->deleteAnimal(-2);
    }

    public function testGetAnimalWithNegativeId() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être un entier non nul");

        $this->animalService->getAnimal(-2);
    }

    public function testGetAnimalWithoutId() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être renseigné");

        $this->animalService->getAnimal(null);
    }

    public function testGetAnimalWithTextAsId() {
        $this->expectException(invalidInputException::class);
        $this->expectExceptionMessage("l'id doit être un entier non nul");

        $this->animalService->getAnimal("fr");
    }
}
