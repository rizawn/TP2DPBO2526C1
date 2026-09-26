#ifndef FILMANIMASI_CPP
#define FILMANIMASI_CPP

#include <string>
#include "Film.cpp"

using namespace std;

class FilmAnimasi : public Film {
private:
    string studio;
    string negaraAsal;
    string targetUsia;

public:
    FilmAnimasi() {
        studio = "";
        negaraAsal = "";
        targetUsia = "";
    }

    void setStudio(string studio) {
        this->studio = studio;
    }

    string getStudio() const {
        return studio;
    }

    void setNegaraAsal(string negaraAsal) {
        this->negaraAsal = negaraAsal;
    }

    string getNegaraAsal() const {
        return negaraAsal;
    }

    void setTargetUsia(string targetUsia) {
        this->targetUsia = targetUsia;
    }

    string getTargetUsia() const {
        return targetUsia;
    }
};

#endif
