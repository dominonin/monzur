<?php

interface CRUD {
    public function Create($media);
    public function Update($media);
    public function Delete($media);
    public function getByYear($year);
    public function getAll();
    public function getYears();
}