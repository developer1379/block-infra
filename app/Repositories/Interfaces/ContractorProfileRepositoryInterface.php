<?php

namespace App\Repositories\Interfaces;

interface ContractorProfileRepositoryInterface
{
    public function getProfile();
    public function updateProfile(array $data);
}
