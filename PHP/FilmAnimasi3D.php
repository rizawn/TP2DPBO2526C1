<?php
require_once __DIR__ . '/FilmAnimasi.php';

class FilmAnimasi3D extends FilmAnimasi
{
    private $software3D;
    private $mesinRender;
    private $formatModel;

    public function __construct()
    {
        parent::__construct();
        $this->software3D = '';
        $this->mesinRender = '';
        $this->formatModel = '';
    }

    public function getSoftware3D() { return $this->software3D; }
    public function setSoftware3D($software3D) { $this->software3D = $software3D; }
    public function getMesinRender() { return $this->mesinRender; }
    public function setMesinRender($mesinRender) { $this->mesinRender = $mesinRender; }
    public function getFormatModel() { return $this->formatModel; }
    public function setFormatModel($formatModel) { $this->formatModel = $formatModel; }
}
