<?php


namespace app\components\entities\interfaces;


use app\components\repository\interfaces\IGithubUserRepository;

interface IGithubUserEntity
{
    public function getId(): ?int;
    public function setId(int $id);

    public function getName(): string;
    public function setName(string $name);

    /**
     * @param IGithubUserRepository[]
    */
    public function setRepositories(array $repositories);

    /**
     * @return  IGithubUserRepository[]
     */
    public function getRepositories(): array;

    public function validate(): bool;
    public function getErrors();
    public function toArray();
}