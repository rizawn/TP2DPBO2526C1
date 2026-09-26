#ifndef FILM_CPP
#define FILM_CPP

#include <string>

using namespace std;

class Film {
private:
    string idFilm;
    string judul;
    string genre;
    int durasi;

public:
    Film() {
        idFilm = "";
        judul = "";
        genre = "";
        durasi = 0;
    }

    void setId(string idFilm) {
        this->idFilm = idFilm;
    }

    string getId() const {
        return idFilm;
    }

    void setJudul(string judul) {
        this->judul = judul;
    }

    string getJudul() const {
        return judul;
    }

    void setGenre(string genre) {
        this->genre = genre;
    }

    string getGenre() const {
        return genre;
    }

    void setDurasi(int durasi) {
        this->durasi = durasi;
    }

    int getDurasi() const {
        return durasi;
    }
};

#endif
