#ifndef FILMANIMASI3D_CPP
#define FILMANIMASI3D_CPP

#include <string>
#include "FilmAnimasi.cpp"

using namespace std;

class FilmAnimasi3D : public FilmAnimasi {
private:
    string software3D;
    string mesinRender;
    string formatModel;

public:
    FilmAnimasi3D() {
        software3D = "";
        mesinRender = "";
        formatModel = "";
    }

    void setSoftware3D(string software3D) {
        this->software3D = software3D;
    }

    string getSoftware3D() const {
        return software3D;
    }

    void setMesinRender(string mesinRender) {
        this->mesinRender = mesinRender;
    }

    string getMesinRender() const {
        return mesinRender;
    }

    void setFormatModel(string formatModel) {
        this->formatModel = formatModel;
    }

    string getFormatModel() const {
        return formatModel;
    }
};

#endif
