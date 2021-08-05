<?php

namespace app\components\entities\interfaces;

interface IGithubRepositoryEntity
{

    /**
     * @return \DateTime
     */
    public function getUpdatedDateTime(): \DateTime;

    /**
     * @param  \DateTime
     */
    public function setUpdateDateTime(\DateTime $updatedDatetime): void;

    /**
     * @return int
     */
    public function getId(): ?int;

    /**
     * @param  int  $id
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
     * @return \app\components\entities\interfaces\IGithubUserEntity
     */
    public function getGithubUserEntity(): IGithubUserEntity;

    /**
     * @param  \app\components\entities\interfaces\IGithubUserEntity  $githubUserRepository
     */
    public function setGithubUserEntity(IGithubUserEntity $githubUserRepository): void;

    /**
     * @return string
     */
    public function getLink(): string;

    /**
     * @param  string  $link
     */
    public function setLink(string $link): void;

    public function validate(): void;

    /**
     * @return array
     */
    public function getErrors(): array;

    /**
     * @return array
     */
    public function toArray(): array;
}