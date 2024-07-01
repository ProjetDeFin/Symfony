<?php

namespace App\Model;

use App\Entity\DiplomaSearched;
use App\Entity\StudyLevel;
use App\Repository\DiplomaSearchedRepository;
use App\Repository\StudyLevelRepository;

class StudentRegisterDTO
{
    private int $phone;
    private StudyLevel $studyLevel;
    private DiplomaSearched $diplomaSearched;
    private string $schoolName;

    public function __construct(
        array $data,
        DiplomaSearchedRepository $diplomaSearchedRepository,
        StudyLevelRepository $studyLevelRepository,
    ){
        $phone = $data['phone'];
        $studyLevel = $data['studyLevel'];
        $diplomaSearched = $data['diplomaSearched'];
        $schoolName = $data['schoolName'];

        if (!$phone || !$studyLevel || !$diplomaSearched || !$schoolName)
        {
            throw new \InvalidArgumentException('Phone, study level, diploma searched and school name are required');
        }

        if (!is_numeric($data['mobile']) || strlen($data['mobile']) !== 10) {
            throw new \InvalidArgumentException("The provided phone number is not a valid.");
        }

        if (!is_numeric($data['studyLevel'])) {
            throw new \InvalidArgumentException("The provided study level is not a valid.");
        }

        if (!is_numeric($data['diploma'])) {
            throw new \InvalidArgumentException("The provided diploma id is not a valid.");
        }

        $diplomaSearched = $diplomaSearchedRepository->find($diplomaSearched);
        if (null === $diplomaSearched) {
            throw new \InvalidArgumentException('Diploma searched not found');
        }

        $studyLevel = $studyLevelRepository->findOneBy(['level' => $studyLevel]);
        if (null === $studyLevel) {
            throw new \InvalidArgumentException('Study level not found');
        }

        $this->phone = $phone;
        $this->studyLevel = $studyLevel;
        $this->diplomaSearched = $diplomaSearched;
        $this->schoolName = $schoolName;
    }

    public function getPhone(): int
    {
        return $this->phone;
    }

    public function getStudyLevel(): StudyLevel
    {
        return $this->studyLevel;
    }

    public function getDiplomaSearched(): DiplomaSearched
    {
        return $this->diplomaSearched;
    }

    public function getSchoolName(): string
    {
        return $this->schoolName;
    }
}