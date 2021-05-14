<?php
namespace app\components\entities\interfaces;


use app\components\repository\interfaces\IGithubUserRepository;

interface IGithubRepositoryEntity
{
    public function getUpdatedDateTime(): \DateTime;
    public function setUpdateDateTime(\DateTime $updatedDatetime);

    public function getId(): ?int;
    public function setId(int $id);

    public function getName(): string;
    public function setName(string $name);

    public function getGithubUserEntity(): IGithubUserEntity;
    public function setGithubUserEntity(IGithubUserEntity $githubUserRepository);

    public function toArray();
}