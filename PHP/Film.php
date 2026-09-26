<?php
class Film
{
    private $idFilm;
    private $judul;
    private $genre;
    private $durasi;
    private $foto_produk;

    public function __construct()
    {
        $this->idFilm = '';
        $this->judul = '';
        $this->genre = '';
        $this->durasi = 0;
        $this->foto_produk = '';
    }

    public function getId() { return $this->idFilm; }
    public function setId($idFilm) { $this->idFilm = $idFilm; }
    public function getJudul() { return $this->judul; }
    public function setJudul($judul) { $this->judul = $judul; }
    public function getGenre() { return $this->genre; }
    public function setGenre($genre) { $this->genre = $genre; }
    public function getDurasi() { return $this->durasi; }
    public function setDurasi($durasi) { $this->durasi = $durasi; }
    public function getFotoProduk() { return $this->foto_produk; }
    public function setFotoProduk($foto_produk) { $this->foto_produk = $foto_produk; }
}
