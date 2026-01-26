<?php

namespace App\Repositories\Interfaces;

interface ProjectRepositoryInterface
{
    public function getAll();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);

    public function getOpenProjects();
    public function getProjectsWithBids();

    public function filterProjects($filters);
    public function getProjectCreators();
    public function countProjectsByContractor($contractorId);
    public function getOngoingProjectsByContractor($contractorId);
    public function getProjectsByContractor($contractorId);
    public function countBidsByContractor($contractorId);
}
