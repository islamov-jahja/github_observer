<?php

namespace app\components\entities\interfaces;

interface IGithubUserEntity
{

    /**
     * @return int
     */
    public function getId(): ?int;

    /**
     * @param  int
     */
    public function setId(int $id): void;

    /**
     * @return string
     */
    public function getName(): string;

    /**
     * @param  string  $name
     */
    public function setName(string $name): void;

    /**
     * @param  \app\components\repository\interfaces\IGithubUserRepository[]
     */
    public function setRepositories(array $repositories): void;

    /**
     * @return  \app\components\entities\interfaces\IGithubUserEntity[]
     */
    public function getRepositories(): array;

    public function validate();

    /**
     * @return array
     */
    public function getErrors();

    /**
     * @return array
     */
    public function toArray(): array;
}