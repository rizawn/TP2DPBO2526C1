<?php
require_once __DIR__ . '/Film.php';

class FilmAnimasi extends Film
{
    private $studio;
    private $negaraAsal;
    private $targetUsia;

    public function __construct()
    {
        parent::__construct();
        $this->studio = '';
        $this->negaraAsal = '';
        $this->targetUsia = '';
    }

    public function getStudio() { return $this->studio; }
    public function setStudio($studio) { $this->studio = $studio; }
    public function getNegaraAsal() { return $this->negaraAsal; }
    public function setNegaraAsal($negaraAsal) { $this->negaraAsal = $negaraAsal; }
    public function getTargetUsia() { return $this->targetUsia; }
    public function setTargetUsia($targetUsia) { $this->targetUsia = $targetUsia; }
}
